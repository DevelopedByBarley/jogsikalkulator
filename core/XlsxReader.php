<?php

declare(strict_types=1);

namespace Core;

/**
 * Függőség nélküli táblázat-olvasó.
 *
 * Egy .xlsx fájl valójában egy ZIP, ami XML-eket tartalmaz. A PHP beépített
 * zip + SimpleXML kiterjesztéseivel kiolvasható PhpSpreadsheet nélkül is.
 * A .csv fájlokat is kezeli fallbackként.
 *
 * A rows() sorok tömbjét adja vissza, minden sor cellák (string) tömbje,
 * oszlopindex szerint (0-tól). A hézagos cellák üres stringgel töltődnek.
 */
class XlsxReader
{
    /**
     * @return array<int, array<int, string>>
     */
    public static function rows(string $path): array
    {
        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        if ($ext === 'csv' || $ext === 'txt') {
            return self::readCsv($path);
        }

        return self::readXlsx($path);
    }

    /**
     * @return array<int, array<int, string>>
     */
    private static function readCsv(string $path): array
    {
        $rows = [];
        $handle = fopen($path, 'rb');
        if ($handle === false) {
            throw new \RuntimeException("Nem sikerült megnyitni a fájlt: {$path}");
        }

        // BOM eltávolítás
        $bom = fread($handle, 3);
        if ($bom !== "\xEF\xBB\xBF") {
            rewind($handle);
        }

        // Elválasztó detektálás az első sorból (; vagy ,)
        $firstLine = fgets($handle);
        $delimiter = ($firstLine !== false && substr_count($firstLine, ';') >= substr_count($firstLine, ',')) ? ';' : ',';
        rewind($handle);
        if ($bom === "\xEF\xBB\xBF") {
            fread($handle, 3);
        }

        while (($data = fgetcsv($handle, 0, $delimiter, '"', '')) !== false) {
            $rows[] = array_map(static fn($v) => (string) $v, $data);
        }
        fclose($handle);

        return $rows;
    }

    /**
     * @return array<int, array<int, string>>
     */
    private static function readXlsx(string $path): array
    {
        if (!class_exists(\ZipArchive::class)) {
            throw new \RuntimeException('A ZipArchive kiterjesztés nem elérhető az .xlsx olvasáshoz.');
        }

        $zip = new \ZipArchive();
        if ($zip->open($path) !== true) {
            throw new \RuntimeException("Érvénytelen vagy sérült .xlsx fájl: {$path}");
        }

        // 1) Shared strings tábla
        $sharedStrings = self::readSharedStrings($zip);

        // 2) Az első munkalap megkeresése (workbook -> első sheet -> rels)
        $sheetXml = self::readFirstSheetXml($zip);
        $zip->close();

        if ($sheetXml === null) {
            throw new \RuntimeException('Nem található munkalap az .xlsx fájlban.');
        }

        return self::parseSheet($sheetXml, $sharedStrings);
    }

    /**
     * @return array<int, string>
     */
    private static function readSharedStrings(\ZipArchive $zip): array
    {
        $content = $zip->getFromName('xl/sharedStrings.xml');
        if ($content === false) {
            return [];
        }

        $xml = @simplexml_load_string($content);
        if ($xml === false) {
            return [];
        }

        $strings = [];
        foreach ($xml->si as $si) {
            $strings[] = self::extractText($si);
        }

        return $strings;
    }

    /**
     * Egy <si> elem szövege: lehet egyszerű <t>, vagy több <r><t> run.
     */
    private static function extractText(\SimpleXMLElement $si): string
    {
        if (isset($si->t)) {
            return (string) $si->t;
        }

        $text = '';
        foreach ($si->r as $run) {
            $text .= (string) $run->t;
        }

        return $text;
    }

    private static function readFirstSheetXml(\ZipArchive $zip): ?string
    {
        // A leggyakoribb elrendezés: xl/worksheets/sheet1.xml
        $direct = $zip->getFromName('xl/worksheets/sheet1.xml');
        if ($direct !== false) {
            return $direct;
        }

        // Fallback: keressük meg az első worksheets/*.xml fájlt
        for ($i = 0; $i < $zip->numFiles; $i++) {
            $name = $zip->getNameIndex($i);
            if ($name !== false && preg_match('#^xl/worksheets/sheet\d+\.xml$#', $name)) {
                $content = $zip->getFromName($name);
                return $content === false ? null : $content;
            }
        }

        return null;
    }

    /**
     * @param array<int, string> $sharedStrings
     * @return array<int, array<int, string>>
     */
    private static function parseSheet(string $sheetXml, array $sharedStrings): array
    {
        $xml = @simplexml_load_string($sheetXml);
        if ($xml === false) {
            throw new \RuntimeException('Nem sikerült feldolgozni a munkalap XML-t.');
        }

        $rows = [];
        foreach ($xml->sheetData->row as $row) {
            $cells = [];
            $maxIndex = -1;

            foreach ($row->c as $c) {
                $ref = (string) ($c['r'] ?? '');
                $colIndex = self::columnIndex($ref);

                $type = (string) ($c['t'] ?? '');
                $value = '';

                if ($type === 's') {
                    // shared string index
                    $idx = (int) $c->v;
                    $value = $sharedStrings[$idx] ?? '';
                } elseif ($type === 'inlineStr') {
                    $value = isset($c->is) ? self::extractText($c->is) : '';
                } else {
                    $value = (string) $c->v;
                }

                $cells[$colIndex] = $value;
                if ($colIndex > $maxIndex) {
                    $maxIndex = $colIndex;
                }
            }

            // Hézagos cellák kitöltése üres stringgel, 0-tól maxIndex-ig
            $normalized = [];
            for ($i = 0; $i <= $maxIndex; $i++) {
                $normalized[$i] = $cells[$i] ?? '';
            }

            $rows[] = $normalized;
        }

        return $rows;
    }

    /**
     * "B7" -> 1 (0-alapú oszlopindex). A számot elhagyjuk.
     */
    private static function columnIndex(string $ref): int
    {
        if ($ref === '') {
            return 0;
        }

        preg_match('/^[A-Z]+/', $ref, $m);
        $letters = $m[0] ?? 'A';

        $index = 0;
        $len = strlen($letters);
        for ($i = 0; $i < $len; $i++) {
            $index = $index * 26 + (ord($letters[$i]) - ord('A') + 1);
        }

        return $index - 1;
    }
}
