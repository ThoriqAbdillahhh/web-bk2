<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('challenge_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('challenge_id')->constrained()->cascadeOnDelete();
            $table->text('label');
            $table->unsignedSmallInteger('position');
            $table->boolean('is_correct')->nullable();
            $table->unsignedSmallInteger('correct_position')->nullable();
            $table->text('feedback')->nullable();
            $table->timestamps();

            $table->unique(['challenge_id', 'position']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('challenge_options');
    }
};
