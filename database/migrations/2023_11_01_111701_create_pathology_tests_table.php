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
        Schema::create('pathology_tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pathology_test_category_id')->constrained('pathology_test_categories')->onDelete('cascade');
            $table->string('name');
            $table->string('code');
            $table->double('test_rate');
            $table->double('referral_fee_percent');
            $table->double('referral_fee_amount');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pathology_tests');
    }
};
