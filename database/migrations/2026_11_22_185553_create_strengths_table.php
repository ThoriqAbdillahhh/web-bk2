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
    Schema::create('strengths', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        $table->string('kind', 10);          // 'kekuatan' atau 'minat'
        $table->string('title');             // misal: "Pandai menjelaskan"
        $table->text('example')->nullable(); // contoh pengalaman nyata
        $table->timestamps();

        $table->index(['user_id', 'kind']);
    });
}   

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('strengths');
    }
};
