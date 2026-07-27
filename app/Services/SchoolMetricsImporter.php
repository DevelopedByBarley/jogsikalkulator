<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\SchoolMetric;
use Core\XlsxReader;

/**
 * KAV VSM és ÁKÓ táblázatok teljes importja.
 *
 * A teljes fájlt beolvassuk: MINDEN kategória (AM, "A1, A2, A összesítve",
 * B, C…) és MINDEN negyedév (pl. 2026.1, 2026.2) külön sorrá robban.
 * A weboldal később azt kéri le, amire szüksége van.
 *
 * Fájlszerkezet (egyesített, többszintű fejléc):
 *
 *  VSM (3 fejlécsor):
 *    sor0: [Ssz.][Képző szerv]  [AM .....][A1, A2, A összesítve .....][B .....][C .....]
 *    sor1:                      [Elmélet][Forgalom] blokkonként
 *    sor2:      [Név][Azon.]     [2026.1][2026.2] minden (kategória,mutató) alatt
 *
 *  ÁKÓ (2 fejlécsor):
 *    sor0: [Ssz.][Képzőszerv]    [AM][A1, A2, A összesítve][B][C]
 *    sor1:      [Név][Azonosító] [2026.1][2026.2] kategóriánként
 *
 * Az értékek 0..1 törtek -> ×100 = százalék. "X" = nem indult képzés,
 * "-" = nincs elég vizsga, üres = nincs adat: a nyers jelet is eltároljuk.
 */
class SchoolMetricsImporter
{
    /**
     * Beolvassa mindkét fájlt teljesen, és iskola+kategória+negyedév szerinti
     * sorokat ad vissza (mentés nélkül). Előnézethez.
     *
     * @return array{rows: array<int, array<string, mixed>>, warnings: array<int, string>, periods: array<int, string>, categories: array<int, string>}
     */
    public function preview(string $vsmPath, string $akoPath, string $vsmName, string $akoName): array
    {
        $vsm = $this->parseVsm($vsmPath);
        $ako = $this->parseAko($akoPath);

        // Kulcs: ext_id|category|period
        $merged = [];
        $categories = [];
        $periods = [];

        foreach ($vsm['data'] as $key => $d) {
            $merged[$key] = [
                'school_ext_id'     => $d['ext_id'],
                'school_name'       => $d['name'],
                'school_key'        => SchoolMetric::normalizeName($d['name']),
                'category'          => $d['category'],
                'period'            => $d['period'],
                'year'              => $d['year'],
                'quarter'           => $d['quarter'],
                'vsm_theory'        => $d['theory'],
                'vsm_theory_raw'    => $d['theory_raw'],
                'vsm_traffic'       => $d['traffic'],
                'vsm_traffic_raw'   => $d['traffic_raw'],
                'ako_practical'     => null,
                'ako_practical_raw' => null,
                'source_vsm'        => $vsmName,
                'source_ako'        => null,
                'matched'           => false,
            ];
            $categories[$d['category']] = true;
            $periods[$d['period']] = true;
        }

        $onlyAko = 0;
        foreach ($ako['data'] as $key => $d) {
            if (isset($merged[$key])) {
                $merged[$key]['ako_practical']     = $d['practical'];
                $merged[$key]['ako_practical_raw'] = $d['practical_raw'];
                $merged[$key]['source_ako']        = $akoName;
                $merged[$key]['matched']           = true;
            } else {
                $merged[$key] = [
                    'school_ext_id'     => $d['ext_id'],
                    'school_name'       => $d['name'],
                    'school_key'        => SchoolMetric::normalizeName($d['name']),
                    'category'          => $d['category'],
                    'period'            => $d['period'],
                    'year'              => $d['year'],
                    'quarter'           => $d['quarter'],
                    'vsm_theory'        => null,
                    'vsm_theory_raw'    => null,
                    'vsm_traffic'       => null,
                    'vsm_traffic_raw'   => null,
                    'ako_practical'     => $d['practical'],
                    'ako_practical_raw' => $d['practical_raw'],
                    'source_vsm'        => null,
                    'source_ako'        => $akoName,
                    'matched'           => false,
                ];
                $onlyAko++;
            }
            $categories[$d['category']] = true;
            $periods[$d['period']] = true;
        }

        $onlyVsm = 0;
        foreach ($merged as $row) {
            if ($row['source_vsm'] !== null && $row['source_ako'] === null) {
                $onlyVsm++;
            }
        }

        $warnings = [];
        if ($onlyVsm > 0) {
            $warnings[] = sprintf('%d sor csak a VSM fájlban szerepel (ÁKÓ érték üresen marad).', $onlyVsm);
        }
        if ($onlyAko > 0) {
            $warnings[] = sprintf('%d sor csak az ÁKÓ fájlban szerepel (VSM értékek üresen maradnak).', $onlyAko);
        }

        $rows = array_values($merged);
        usort($rows, static function ($a, $b) {
            return [$a['school_name'], $a['category'], $a['period']]
                <=> [$b['school_name'], $b['category'], $b['period']];
        });

        $catList = array_keys($categories);
        $perList = array_keys($periods);
        sort($perList);

        return ['rows' => $rows, 'warnings' => $warnings, 'periods' => $perList, 'categories' => $catList];
    }

    /**
     * Teljes tábla ürítése, majd az összes sor beszúrása — tranzakcióban.
     *
     * @param array<int, array<string, mixed>> $rows a preview() kimenete
     */
    public function store(array $rows): int
    {
        $connection = SchoolMetric::query()->getConnection();

        return $connection->transaction(function () use ($rows) {
            // Teljes ürítés: mindig a legfrissebb fájl teljes tartalma marad.
            // delete()-et használunk, nem truncate()-et: a TRUNCATE MySQL-ben
            // implicit commitot vált ki, ami megtörné ezt a tranzakciót.
            SchoolMetric::query()->delete();

            $count = 0;
            $now = date('Y-m-d H:i:s');
            $batch = [];

            foreach ($rows as $row) {
                if (($row['school_name'] ?? '') === '') {
                    continue;
                }

                $batch[] = [
                    'school_name'       => $row['school_name'],
                    'school_key'        => $row['school_key'],
                    'school_ext_id'     => $row['school_ext_id'] ?: null,
                    'category'          => $row['category'],
                    'year'              => $row['year'],
                    'quarter'           => $row['quarter'],
                    'vsm_theory'        => $row['vsm_theory'],
                    'vsm_traffic'       => $row['vsm_traffic'],
                    'ako_practical'     => $row['ako_practical'],
                    'vsm_theory_raw'    => $row['vsm_theory_raw'],
                    'vsm_traffic_raw'   => $row['vsm_traffic_raw'],
                    'ako_practical_raw' => $row['ako_practical_raw'],
                    'source_file_vsm'   => $row['source_vsm'] ?? null,
                    'source_file_ako'   => $row['source_ako'] ?? null,
                    'created_at'        => $now,
                    'updated_at'        => $now,
                ];
                $count++;

                // Kötegelt beszúrás, hogy ne fusson ezer külön INSERT
                if (count($batch) >= 500) {
                    SchoolMetric::query()->insert($batch);
                    $batch = [];
                }
            }

            if ($batch !== []) {
                SchoolMetric::query()->insert($batch);
            }

            return $count;
        });
    }

    /**
     * @return array{data: array<string, array<string, mixed>>}
     */
    private function parseVsm(string $path): array
    {
        $rows = XlsxReader::rows($path);
        if (count($rows) < 4) {
            throw new \RuntimeException('A VSM fájl túl rövid vagy üres.');
        }

        $catRow = $rows[0];
        $metricRow = $rows[1];
        $periodRow = $rows[2];

        [$nameCol, $idCol] = $this->locateNameIdColumns($periodRow, $catRow);
        $blocks = $this->categoryBlocks($catRow);

        // Oszlopmátrix: category => period => ['theory'=>col, 'traffic'=>col]
        //
        // FONTOS: az "Elmélet" / "Forgalom" felirat vízszintesen EGYESÍTETT
        // cella (egy felirat = két negyedév oszlopa), ezért csak a blokk első
        // oszlopában van szöveg. Az üres cellákra továbbvisszük az utolsó
        // látott feliratot, különben a 2026.2 oszlopok kimaradnának.
        $cols = [];
        foreach ($blocks as $category => [$start, $end]) {
            $currentMetric = null;
            for ($c = $start; $c < $end; $c++) {
                $label = $this->norm($metricRow[$c] ?? '');
                if (str_contains($label, 'elmélet') || str_contains($label, 'elmelet')) {
                    $currentMetric = 'theory';
                } elseif (str_contains($label, 'forgalom')) {
                    $currentMetric = 'traffic';
                }

                $period = $this->normalizePeriod($periodRow[$c] ?? '');
                if ($period === null || $currentMetric === null) {
                    continue;
                }
                $cols[$category][$period][$currentMetric] = $c;
            }
        }

        if ($cols === []) {
            throw new \RuntimeException('A VSM fájlban nem sikerült kategória/időszak oszlopokat azonosítani.');
        }

        $data = [];
        $total = count($rows);
        for ($i = 3; $i < $total; $i++) {
            $row = $rows[$i];
            $name = trim($row[$nameCol] ?? '');
            if ($name === '') {
                continue;
            }
            $extId = $idCol !== null ? trim($row[$idCol] ?? '') : '';

            foreach ($cols as $category => $byPeriod) {
                foreach ($byPeriod as $period => $map) {
                    [$year, $quarter] = $this->splitPeriod($period);
                    [$theory, $theoryRaw]   = $this->parseValue(isset($map['theory']) ? ($row[$map['theory']] ?? '') : '');
                    [$traffic, $trafficRaw] = $this->parseValue(isset($map['traffic']) ? ($row[$map['traffic']] ?? '') : '');

                    $key = $this->rowKey($extId, $name, $category, $period);
                    $data[$key] = [
                        'ext_id'      => $extId,
                        'name'        => $name,
                        'category'    => $category,
                        'period'      => $period,
                        'year'        => $year,
                        'quarter'     => $quarter,
                        'theory'      => $theory,
                        'theory_raw'  => $theoryRaw,
                        'traffic'     => $traffic,
                        'traffic_raw' => $trafficRaw,
                    ];
                }
            }
        }

        return ['data' => $data];
    }

    /**
     * @return array{data: array<string, array<string, mixed>>}
     */
    private function parseAko(string $path): array
    {
        $rows = XlsxReader::rows($path);
        if (count($rows) < 3) {
            throw new \RuntimeException('Az ÁKÓ fájl túl rövid vagy üres.');
        }

        $catRow = $rows[0];
        $periodRow = $rows[1];

        [$nameCol, $idCol] = $this->locateNameIdColumns($periodRow, $catRow);
        $blocks = $this->categoryBlocks($catRow);

        // category => period => col
        $cols = [];
        foreach ($blocks as $category => [$start, $end]) {
            for ($c = $start; $c < $end; $c++) {
                $period = $this->normalizePeriod($periodRow[$c] ?? '');
                if ($period !== null) {
                    $cols[$category][$period] = $c;
                }
            }
        }

        if ($cols === []) {
            throw new \RuntimeException('Az ÁKÓ fájlban nem sikerült kategória/időszak oszlopokat azonosítani.');
        }

        $data = [];
        $total = count($rows);
        for ($i = 2; $i < $total; $i++) {
            $row = $rows[$i];
            $name = trim($row[$nameCol] ?? '');
            if ($name === '') {
                continue;
            }
            $extId = $idCol !== null ? trim($row[$idCol] ?? '') : '';

            foreach ($cols as $category => $byPeriod) {
                foreach ($byPeriod as $period => $col) {
                    [$year, $quarter] = $this->splitPeriod($period);
                    [$practical, $practicalRaw] = $this->parseValue($row[$col] ?? '');

                    $key = $this->rowKey($extId, $name, $category, $period);
                    $data[$key] = [
                        'ext_id'        => $extId,
                        'name'          => $name,
                        'category'      => $category,
                        'period'        => $period,
                        'year'          => $year,
                        'quarter'       => $quarter,
                        'practical'     => $practical,
                        'practical_raw' => $practicalRaw,
                    ];
                }
            }
        }

        return ['data' => $data];
    }

    /**
     * A kategória-fejlécsorból: category => [startCol, endCol) blokkhatárok.
     *
     * @param array<int, string> $catRow
     * @return array<string, array{0:int,1:int}>
     */
    private function categoryBlocks(array $catRow): array
    {
        // Az iskola-adatok (Ssz., Képző szerv, Név, Azon.) az első oszlopokban vannak;
        // a kategóriák ezek után kezdődnek.
        //
        // FONTOS: itt PONTOS egyezést nézünk, nem részszöveget. A korábbi
        // str_contains($n, 'ssz') kiszűrte az "A1, A2, A összesítve" oszlopot is,
        // mert az "öSSZesítve" tartalmazza az "ssz" betűsort.
        $serviceLabels = ['ssz.', 'ssz', 'sorszám', 'képző szerv', 'képzőszerv', 'név', 'azon.', 'azonosító'];

        $starts = [];
        foreach ($catRow as $c => $val) {
            $label = trim($val);
            if ($label === '') {
                continue;
            }
            if (in_array($this->norm($label), $serviceLabels, true)) {
                continue;
            }
            $starts[$c] = $label;
        }

        if ($starts === []) {
            return [];
        }

        $maxCol = 0;
        foreach ($catRow as $c => $_) {
            $maxCol = max($maxCol, $c);
        }

        $cols = array_keys($starts);
        $blocks = [];
        $n = count($cols);
        for ($i = 0; $i < $n; $i++) {
            $start = $cols[$i];
            $end = ($i + 1 < $n) ? $cols[$i + 1] : $maxCol + 1;
            $blocks[$starts[$start]] = [$start, $end];
        }

        return $blocks;
    }

    /**
     * @param array<int, string> $periodRow
     * @param array<int, string> $catRow
     * @return array{0:int,1:?int}
     */
    private function locateNameIdColumns(array $periodRow, array $catRow): array
    {
        // Pontos egyezés, nem részszöveg: a laza illesztés kategória-feliratokra
        // is ráugorhat (pl. "összesítve" tartalmazza az "ssz"-t).
        $nameCol = null;
        $idCol = null;
        foreach ($periodRow as $c => $val) {
            $n = $this->norm($val);
            if ($nameCol === null && $n === 'név') {
                $nameCol = $c;
            } elseif ($idCol === null && ($n === 'azon.' || $n === 'azonosító')) {
                $idCol = $c;
            }
        }

        if ($nameCol === null) {
            foreach ($catRow as $c => $val) {
                $n = $this->norm($val);
                if ($n === 'képző szerv' || $n === 'képzőszerv') {
                    $nameCol = $c;
                    break;
                }
            }
            $nameCol ??= 1;
        }

        return [$nameCol, $idCol];
    }

    /**
     * "2026.1" -> "2026.1"; egyéb formák tisztítása; ha nem időszak -> null.
     */
    private function normalizePeriod(string $val): ?string
    {
        $v = trim($val);
        if (preg_match('/^(20\d{2})\.\s*([1-4])$/', $v, $m)) {
            return $m[1] . '.' . $m[2];
        }
        return null;
    }

    /**
     * "2026.1" -> [2026, 1]
     *
     * @return array{0:int,1:int}
     */
    private function splitPeriod(string $period): array
    {
        [$y, $q] = explode('.', $period);
        return [(int) $y, (int) $q];
    }

    private function rowKey(string $extId, string $name, string $category, string $period): string
    {
        $base = $extId !== '' ? 'id:' . $extId : 'nm:' . SchoolMetric::normalizeName($name);
        return $base . '|' . $category . '|' . $period;
    }

    /**
     * @return array{0:?float,1:?string} [százalék|null, nyers_jel|null]
     */
    private function parseValue(string $value): array
    {
        $raw = trim($value);

        if ($raw === '') {
            return [null, ''];
        }
        if ($raw === 'X' || $raw === 'x') {
            return [null, 'X'];
        }
        if ($raw === '-' || $raw === '–' || $raw === '—') {
            return [null, '-'];
        }

        $hadPercent = str_contains($raw, '%');
        $num = str_replace([' ', "\u{00A0}", '%'], '', $raw);
        $num = str_replace(',', '.', $num);
        if (!is_numeric($num)) {
            return [null, $raw];
        }

        $n = (float) $num;
        // A KAV-fájl arányszámként tárol: 1.0 = 100% (VSM 0.4898 -> 48.98%,
        // ÁKÓ 2.0345 -> 203.45%). Ezért mindig ×100. Ha a cella maga már
        // '%'-ot tartalmazott (pl. CSV export), akkor az érték már százalék.
        $percent = $hadPercent ? $n : $n * 100;

        return [round($percent, 2), null];
    }

    private function norm(string $v): string
    {
        return mb_strtolower(trim($v), 'UTF-8');
    }
}
