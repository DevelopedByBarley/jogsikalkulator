<?php

declare(strict_types=1);

use Database\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class implements Migration
{
    public function up(): void
    {
        $schema = db()->getConnection()->getSchemaBuilder();

        if ($schema->hasTable('category_rules')) {
            return;
        }

        $schema->create('category_rules', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->string('category', 10);
            $table->string('prev_category', 10);
            $table->enum('years', ['less_2', 'more_2'])->nullable();

            $table->unsignedInteger('medical_price')->nullable();

            // Elmélet
            $table->unsignedInteger('theoretical_training_price');
            $table->unsignedInteger('theoretical_exam_fee');

            // Gyakorlat
            $table->unsignedInteger('practical_basic_hours_price');
            $table->unsignedInteger('practical_basic_hours');
            $table->unsignedInteger('practical_extra_hours_price');
            $table->unsignedInteger('practical_extra_hours_amount');
            $table->unsignedInteger('practical_exam_fee');
            $table->unsignedInteger('vehicle_handling_price');

            // Elsősegély
            $table->unsignedInteger('first_aid_training_price');
            $table->unsignedInteger('first_aid_exam_fee');

            // Egyéb
            $table->unsignedInteger('administration_fee');
            $table->unsignedInteger('document_fee');

            // Korhatár
            $table->string('age_registration')->nullable();
            $table->string('age_theoretical_exam')->nullable();
            $table->string('age_practical_exam')->nullable();

            $table->unique(['category', 'prev_category', 'years']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        db()->getConnection()->getSchemaBuilder()->dropIfExists('category_rules');
    }
};
