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
        Schema::create('pathology_patient_report_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained('pathology_patient_reports')->onDelete('cascade');
            $table->integer('result_id');
            $table->string('result_value');
            $table->string('convert_value');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pathology_patient_report_values');
    }
};
