<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\Source;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->integer('calories');
            $table->text('description')->nullable();
            $table->integer('distance');
            $table->date('date');
            $table->integer('elevate');
            $table->integer('heart_rate')->nullable();
            $table->string('name');
            $table->integer('pace')->nullable();
            $table->string('pace_string')->nullable();
            $table->string('source');
            $table->unsignedBigInteger('source_id')->unique();
            $table->integer('sport_type');
            $table->unsignedBigInteger('start_time_unix');
            $table->integer('total_time');
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
