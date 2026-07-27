<?php

declare(strict_types=1);

namespace App\Models;

class SchoolMetric extends Model
{
    protected $table = 'school_metrics';

    protected $casts = [
        'year'          => 'integer',
        'quarter'       => 'integer',
        'vsm_theory'    => 'float',
        'vsm_traffic'   => 'float',
        'ako_practical' => 'float',
    ];

    /** A fájlban szereplő kategóriák (fejléc-blokkok). */
    public const CATEGORIES = ['AM', 'A1, A2, A összesítve', 'B', 'C'];

    /** Alapértelmezett kategória a feltöltéskor. */
    public const DEFAULT_CATEGORY = 'B';

    /**
     * A kalkulátor kategóriái -> a KAV-fájl kategória-oszlopai.
     * Az A1, A2 és A a fájlban EGY közös, összesített oszlopban van.
     */
    private const CATEGORY_MAP = [
        'AM' => 'AM',
        'A1' => 'A1, A2, A összesítve',
        'A2' => 'A1, A2, A összesítve',
        'A'  => 'A1, A2, A összesítve',
        'B'  => 'B',
        'C'  => 'C',
    ];

    /**
     * Kalkulátor-kategóriából (pl. "A2") a fájlbeli oszlopnév.
     * Ismeretlen kategória esetén null -> nincs mit mutatni.
     */
    public static function mapCategory(string $category): ?string
    {
        return self::CATEGORY_MAP[strtoupper(trim($category))] ?? null;
    }

    /**
     * A legfrissebb negyedév, amire ténylegesen van adat a DB-ben.
     * Így a publikus oldal mindig az utolsó negyedévet mutatja anélkül,
     * hogy bárhol dátumot kellene kézzel átírni.
     *
     * @return array{year:int, quarter:int}|null
     */
    public static function latestPeriod(): ?array
    {
        $row = static::query()
            ->selectRaw('year, quarter')
            ->orderByDesc('year')
            ->orderByDesc('quarter')
            ->first();

        return $row ? ['year' => (int) $row->year, 'quarter' => (int) $row->quarter] : null;
    }

    /**
     * Iskolanév normalizálása párosításhoz: kisbetűs, felesleges
     * szóközök összevonva, ékezetek megtartva de trimmelve.
     */
    public static function normalizeName(string $name): string
    {
        $name = trim($name);
        // Több egymás utáni whitespace (a mintában "Járművezetőkép ző") egy szóközzé
        $name = preg_replace('/\s+/u', ' ', $name) ?? $name;

        return mb_strtolower($name, 'UTF-8');
    }
}
