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
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('contact');
            $table->string('email')->nullable();
            $table->string('designation')->nullable();
            $table->string('institute')->nullable();
            $table->string('photo')->nullable();
            $table->foreignId('gender_id')->constrained('genders')->onDelete('cascade');
            $table->foreignId('religion_id')->constrained('religions')->onDelete('cascade')->nullable();
            $table->foreignId('blood_group_id')->constrained('blood_groups')->onDelete('cascade')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
