<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reflections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('mission_id')->constrained()->cascadeOnDelete();
            $table->text('what_learned');
            $table->text('difficult_part');
            $table->text('next_step');
            $table->boolean('is_shared')->default(false);
            $table->timestamps();

            $table->index(['mission_id', 'is_shared']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reflections');
    }
};
