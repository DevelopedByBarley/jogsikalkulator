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
            // Normalizált név a párosításhoz és kereséshez (kisbetűs, ékezet/szóköz tisztítva)
            $table->string('school_key')->index();

            $table->string('category', 20)->nullable();

            $table->unsignedSmallInteger('year');
            $table->unsignedTinyInteger('quarter');

            // Vizsga Sikerességi Mutató (VSM) — százalék, 2 tizedesig
            $table->decimal('vsm_theory', 6, 2)->nullable();
            $table->decimal('vsm_traffic', 6, 2)->nullable();

            // Átlagos Képzési Óraszám (ÁKÓ) — százalék
            $table->decimal('ako_practical', 6, 2)->nullable();

            // Audit: melyik feltöltött fájlból származik az adat
            $table->string('source_file_vsm')->nullable();
            $table->string('source_file_ako')->nullable();

            $table->timestamps();

            $table->unique(['school_key', 'category', 'year', 'quarter'], 'school_metrics_unique');
        });
    }

    public function down(): void
    {
        db()->getConnection()->getSchemaBuilder()->dropIfExists('school_metrics');
    }
};
