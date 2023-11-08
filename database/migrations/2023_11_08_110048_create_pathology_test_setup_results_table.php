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
        Schema::create('pathology_test_setup_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pathology_test_setup_id')->constrained('pathology_test_setups')->onDelete('cascade');
            $table->foreignId('result_id')->constrained('pathology_result_names')->onDelete('cascade');
            $table->integer('result_type')->comment('0=select/1=input');
            $table->integer('heading_id')->nullable();
            $table->integer('pathology_unit_id')->nullable();
            $table->integer('pathology_convert_unit_id')->nullable();
            $table->string('calculation_value')->nullable();
            $table->string('calculation_operator')->nullable();
            $table->string('normal_value')->nullable();
            $table->string('default_value')->nullable();
            $table->string('comment')->nullable();
            $table->boolean('is_converted')->default(false)->comment('0=No/1=Yes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pathology_test_setup_results');
    }
};
