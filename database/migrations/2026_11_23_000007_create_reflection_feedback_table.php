<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reflection_feedback', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reflection_id')->constrained()->cascadeOnDelete();
            $table->foreignId('teacher_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->text('content');
            $table->timestamps();

            $table->index(['teacher_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reflection_feedback');
    }
};
