<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('meal_ingredients', function (Blueprint $table) {
            $table->foreignId('meal_id')->constrained()->cascadeOnDelete();
            $table->foreignId('ingredient_id')->constrained()->cascadeOnDelete();
            $table->primary(['meal_id', 'ingredient_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meal_ingredients');
    }
};
