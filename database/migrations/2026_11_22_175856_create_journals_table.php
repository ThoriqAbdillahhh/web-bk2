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
        Schema::create('journals', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->cascadeOnDelete();
    $table->unsignedSmallInteger('week_no');
    $table->text('q1');
    $table->text('q2');
    $table->text('q3');
    $table->boolean('is_shared')->default(false);
    $table->timestamps();

    $table->unique(['user_id', 'week_no']);
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('journals');
    }
};
