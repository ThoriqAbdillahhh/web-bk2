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
    Schema::dropIfExists('consultations');
    Schema::table('users', fn (Blueprint $t) => $t->dropColumn('bio'));
}
public function down(): void {}
};
