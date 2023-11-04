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
        Schema::create('pathology_patients', function (Blueprint $table) {
            $table->id();
            $table->string('unique_id');
            $table->string('name');
            $table->string('contact');
            $table->string('age');
            $table->integer('age_type')->comment('1=day/2=month/3=year');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('doctor_id')->nullable()->constrained('doctors')->onDelete('cascade');
            $table->foreignId('referral_id')->nullable()->constrained('referrals')->onDelete('cascade');
            $table->foreignId('gender_id')->constrained('genders')->onDelete('cascade')->nullable();
            $table->double('total');
            $table->double('discount_amount');
            $table->double('discount_percent');
            $table->double('grand_total');
            $table->double('paid');
            $table->boolean('is_reported')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pathology_patients');
    }
};
