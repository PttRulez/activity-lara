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
        Schema::create('foods', function (Blueprint $table) {
            $table->id();
            $table->integer('carbs');
            $table->integer('calories');
            $table->boolean('created_by_admin');
            $table->integer('fat');
            $table->string('name');
            $table->integer('protein');
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            
            // Index
            $table->unique(['user_id', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('foods');
    }
};
