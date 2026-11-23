<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('function_checks', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('item_number')->unique();
            $table->string('title');
            $table->string('status', 30)->default('belum_diperiksa');
            $table->text('notes')->nullable();
            $table->foreignId('checked_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->timestamp('checked_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('function_checks');
    }
};
