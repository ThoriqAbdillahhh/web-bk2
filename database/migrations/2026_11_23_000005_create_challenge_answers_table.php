<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('challenge_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('challenge_id')->constrained()->cascadeOnDelete();
            $table->foreignId('selected_option_id')
                ->nullable()
                ->constrained('challenge_options')
                ->nullOnDelete();
            $table->jsonb('answer_order')->nullable();
            $table->unsignedInteger('attempt_number')->default(1);
            $table->boolean('is_correct')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'challenge_id', 'attempt_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('challenge_answers');
    }
};
