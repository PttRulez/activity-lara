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
        Schema::create('food_in_meals', function (Blueprint $table) {
            $table->id();
            $table->integer('calories');
            $table->integer('calories_per_100');
            $table->foreignId('meal_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->integer('weight');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('food_in_meals');
    }
};
