<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('observations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('observer_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('classroom_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();
            $table->string('activity');
            $table->string('result', 30)->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('observed_at')->nullable();
            $table->timestamps();

            $table->index(['classroom_id', 'observed_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('observations');
    }
};
