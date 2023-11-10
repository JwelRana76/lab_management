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
        Schema::create('pathology_test_setups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('test_id')->constrained('pathology_tests')->onDelete('cascade');
            $table->integer('result_no');
            $table->boolean('is_normal_value')->default(false)->comment('0=No/1=Yes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pathology_test_setups');
    }
};
