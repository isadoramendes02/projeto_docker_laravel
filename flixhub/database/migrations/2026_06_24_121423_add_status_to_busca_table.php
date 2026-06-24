<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
{
    // Mude de 'busca' para 'buscas'
    Schema::table('buscas', function (Blueprint $table) {
        $table->string('status')->nullable()->after('titulo_obra');
    });
}

public function down(): void
{
    // Mude de 'busca' para 'buscas'
    Schema::table('buscas', function (Blueprint $table) {
        $table->dropColumn('status');
    });
}
};