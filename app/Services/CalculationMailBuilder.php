<?php

declare(strict_types=1);

namespace App\Services;

/**
 * A kalkuláció pillanatképét email-hez készíti elő.
 *
 * Itt CSAK adat van: normalizálás és összegzés. A HTML-t a
 * resources/views/emails/calculation.view.php rendereli.
 *
 * A csoportok és a sorrend szándékosan ugyanaz, mint a kliensoldali
 * calc-breakdown.js-ben – amit a felhasználó a képernyőn lát, azt kapja
 * a levélben is. A számokat itt ÚJRA összeadjuk: a kliens által küldött
 * végösszegben nem bízunk meg.
 */
class CalculationMailBuilder
{
    /** A kalkulátorban is használt kategórialista. */
    private const CATEGORIES = ['AM', 'A1', 'A2', 'A', 'B'];

    /**
     * A nyers bemenetből olyan struktúrát csinál, aminek minden mezője
     * garantáltan létezik és helyes típusú. Így a renderelés nem tud
     * hiányzó kulcson elszállni, akárhogy is néz ki a POST body.
     *
     * @param array<mixed> $input
     * @return array<mixed>
     */
    public static function normalize(array $input): array
    {
        $category = (string) ($input['category'] ?? 'B');
        if (!in_array($category, self::CATEGORIES, true)) {
            $category = 'B';
        }

        $theoritical = is_array($input['theoritical'] ?? null) ? $input['theoritical'] : [];
        $practical   = is_array($input['practical'] ?? null) ? $input['practical'] : [];
        $firstAid    = is_array($input['first_aid'] ?? null) ? $input['first_aid'] : [];
        $others      = is_array($input['others'] ?? null) ? $input['others'] : [];

        return [
            'category'      => $category,
            'medical_price' => self::int($input['medical_price'] ?? 0),
            'theoritical'   => [
                'training_price' => self::int($theoritical['training_price'] ?? 0),
                'exam_fee'       => self::int($theoritical['exam_fee'] ?? 0),
            ],
            'practical'     => [
                'training_basic_hours_price'  => self::int($practical['training_basic_hours_price'] ?? 0),
                'training_basic_hours'        => self::int($practical['training_basic_hours'] ?? 0),
                'training_extra_hours_price'  => self::int($practical['training_extra_hours_price'] ?? 0),
                'extra_training_hours_amount' => self::int($practical['extra_training_hours_amount'] ?? 0),
                'practical_exam_fee_price'    => self::int($practical['practical_exam_fee_price'] ?? 0),
                'vehicle_handling_price'      => self::int($practical['vehicle_handling_price'] ?? 0),
            ],
            'first_aid'     => [
                'training_basic_price' => self::int($firstAid['training_basic_price'] ?? 0),
                'exam_fee'             => self::int($firstAid['exam_fee'] ?? 0),
            ],
            'others'        => [
                'administration_fee' => self::int($others['administration_fee'] ?? 0),
                'document_fee'       => self::int($others['document_fee'] ?? 0),
            ],
        ];
    }

    /**
     * Az iskola + mutatói, vagy null. A mutatók celláit a publikus API
     * ['value' => ?float, 'note' => ?string] alakban adja.
     *
     * @param array<mixed> $input
     * @return array{name: string, period: ?string, metrics: array<string, array{value: ?float, note: ?string}>}|null
     */
    public static function normalizeSchool(mixed $input): ?array
    {
        if (!is_array($input)) {
            return null;
        }

        $name = trim((string) ($input['name'] ?? ''));
        if ($name === '') {
            return null;
        }

        $metrics = is_array($input['metrics'] ?? null) ? $input['metrics'] : [];
        $cells   = [];

        foreach (['vsm_theory', 'vsm_traffic', 'ako_practical'] as $key) {
            $cell = is_array($metrics[$key] ?? null) ? $metrics[$key] : [];
            $cells[$key] = [
                'value' => is_numeric($cell['value'] ?? null) ? (float) $cell['value'] : null,
                'note'  => is_string($cell['note'] ?? null) ? $cell['note'] : null,
            ];
        }

        $period = $metrics['period']['label'] ?? null;

        return [
            'name'    => $name,
            'period'  => is_string($period) ? $period : null,
            'metrics' => $cells,
        ];
    }

    /**
     * Csoportok a kalkulátor sorrendjében.
     *
     * @param array<mixed> $calc normalize() kimenete
     * @return array<array{title: string, total: int, rows: array<array{label: string, hint?: string, value: int}>}>
     */
    public static function groups(array $calc): array
    {
        $p = $calc['practical'];

        $practicalRows = [
            [
                'label' => 'Gyakorlati képzés díja (alap)',
                'hint'  => self::ft($p['training_basic_hours_price']) . ' * ' . $p['training_basic_hours'] . ' tanóra',
                'value' => $p['training_basic_hours_price'] * $p['training_basic_hours'],
            ],
            [
                'label' => 'Gyakorlati képzés díja (pótórák)',
                'hint'  => self::ft($p['training_extra_hours_price']) . ' * ' . $p['extra_training_hours_amount'] . ' tanóra',
                'value' => $p['training_extra_hours_price'] * $p['extra_training_hours_amount'],
            ],
        ];

        if ($p['vehicle_handling_price'] > 0) {
            $practicalRows[] = ['label' => 'Járműkezelési vizsgadíj', 'value' => $p['vehicle_handling_price']];
        }

        $practicalRows[] = ['label' => 'Forgalmi vizsgadíj', 'value' => $p['practical_exam_fee_price']];

        return [
            [
                'title' => 'ORVOSI ALKALMASSÁG',
                'total' => $calc['medical_price'],
                'rows'  => [
                    ['label' => 'Orvosi alkalmassági vizsgálat díja', 'value' => $calc['medical_price']],
                ],
            ],
            [
                'title' => 'ELMÉLET',
                'total' => $calc['theoritical']['training_price'] + $calc['theoritical']['exam_fee'],
                'rows'  => [
                    ['label' => 'Elméleti képzés díja', 'value' => $calc['theoritical']['training_price']],
                    ['label' => 'Közlekedési alapismeretek vizsgadíj', 'value' => $calc['theoritical']['exam_fee']],
                ],
            ],
            [
                'title' => 'GYAKORLAT',
                'total' => array_sum(array_column($practicalRows, 'value')),
                'rows'  => $practicalRows,
            ],
            [
                'title' => 'ELSŐSEGÉLY',
                'total' => $calc['first_aid']['training_basic_price'] + $calc['first_aid']['exam_fee'],
                'rows'  => [
                    ['label' => 'Elsősegély-tanfolyam díja', 'value' => $calc['first_aid']['training_basic_price']],
                    ['label' => 'Elsősegély vizsga díja', 'value' => $calc['first_aid']['exam_fee']],
                ],
            ],
            [
                'title' => 'EGYÉB',
                'total' => $calc['others']['administration_fee'] + $calc['others']['document_fee'],
                'rows'  => [
                    ['label' => 'Egyéb autósiskolai adminisztrációs költség', 'value' => $calc['others']['administration_fee']],
                    ['label' => 'Okmány elkészítés díja (első jogosítvány)', 'value' => $calc['others']['document_fee']],
                ],
            ],
        ];
    }

    /**
     * A levél HTML-je. A view-nak kész, formázott adatot adunk át, hogy
     * abban ne kelljen számolni.
     *
     * @param array<mixed> $calc normalize() kimenete
     * @param array<mixed>|null $school normalizeSchool() kimenete
     */
    public static function render(array $calc, ?array $school = null): string
    {
        $groups = self::groups($calc);
        $total  = array_sum(array_column($groups, 'total'));

        return view('emails/calculation', [
            'category' => $calc['category'],
            'groups'   => $groups,
            'total'    => $total,
            'school'   => $school,
        ]);
    }

    /** Ezer-elválasztós forint formátum: "412 500 Ft". */
    public static function ft(int $n): string
    {
        return number_format($n, 0, ',', ' ') . ' Ft';
    }

    /**
     * Mutató cella szövege: szám -> "97,50%", egyébként a hatóság jelzése.
     *
     * @param array{value: ?float, note: ?string}|null $cell
     */
    public static function percent(?array $cell): string
    {
        if ($cell === null) {
            return '–';
        }

        if ($cell['value'] === null) {
            return $cell['note'] ?? '–';
        }

        return number_format($cell['value'], 2, ',', ' ') . '%';
    }

    private static function int(mixed $value): int
    {
        return is_numeric($value) ? (int) $value : 0;
    }
}
