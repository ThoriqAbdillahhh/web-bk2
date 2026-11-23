<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('challenges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mission_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('prompt');
            $table->text('instructions')->nullable();
            $table->string('challenge_type', 20)->default('choice');
            $table->unsignedSmallInteger('level')->default(1);
            $table->unsignedSmallInteger('position')->default(1);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['mission_id', 'level', 'position']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('challenges');
    }
};
