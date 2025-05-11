<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('code')->unique();
            $table->uuid('resident_id');
            $table->uuid('report_category_id');
            $table->uuid('study_program_id');
            $table->string('title');
            $table->longText('description');
            $table->string('image');
            $table->string('latitude');
            $table->string('longitude');
            $table->text('address');
            $table->timestamps();

            $table->foreign('resident_id')->references('id')->on('residents')->cascadeOnDelete();
            $table->foreign('report_category_id')->references('id')->on('report_categories')->cascadeOnDelete();
            $table->foreign('study_program_id')->references('id')->on('study_programs')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
