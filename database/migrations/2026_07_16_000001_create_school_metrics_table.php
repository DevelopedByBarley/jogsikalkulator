<?php

declare(strict_types=1);

use Database\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class implements Migration
{
    public function up(): void
    {
        $schema = db()->getConnection()->getSchemaBuilder();

        if ($schema->hasTable('school_metrics')) {
            return;
        }

        $schema->create('school_metrics', function (Blueprint $table): void {
            $table->bigIncrements('id');

            $table->string('school_name');
            // Normalizált név (kisbetűs, szóközök összevonva) — kereséshez / másodlagos párosításhoz
            $table->string('school_key')->index();
            // A fájlbeli "Azonosító" oszlop (pl. 0674) — elsődleges párosítás VSM↔ÁKÓ között
            $table->string('school_ext_id', 50)->nullable()->index();

            // Kategória pontosan ahogy a fájlban van (pl. "B", "A1, A2, A összesítve")
            $table->string('category', 50)->nullable();

            $table->unsignedSmallInteger('year');
            $table->unsignedTinyInteger('quarter');

            // Vizsga Sikerességi Mutató (VSM) — százalék (a fájlbeli 0..1 tört ×100)
            $table->decimal('vsm_theory', 6, 2)->nullable();
            $table->decimal('vsm_traffic', 6, 2)->nullable();
            // Átlagos Képzési Óraszám (ÁKÓ) — százalék
            $table->decimal('ako_practical', 6, 2)->nullable();

            // Nyers érték a fájlból: lehet szám, "X" (nem indult képzés),
            // "-" (nincs elég vizsga) vagy üres — a weboldal pontos megjelenítéséhez
            $table->string('vsm_theory_raw', 20)->nullable();
            $table->string('vsm_traffic_raw', 20)->nullable();
            $table->string('ako_practical_raw', 20)->nullable();

            // Audit: melyik feltöltött fájlból származik az adat
            $table->string('source_file_vsm')->nullable();
            $table->string('source_file_ako')->nullable();

            $table->timestamps();

            // Egyediség a fájlbeli azonosító + kategória + negyedév alapján.
            // (Két különböző iskolának lehet azonos normalizált neve, de az
            //  Azonosító egyedi — ezért erre tesszük a unique kulcsot.)
            $table->unique(['school_ext_id', 'category', 'year', 'quarter'], 'school_metrics_unique');
            $table->index(['category', 'year', 'quarter']);
        });
    }

    public function down(): void
    {
        db()->getConnection()->getSchemaBuilder()->dropIfExists('school_metrics');
    }
};
