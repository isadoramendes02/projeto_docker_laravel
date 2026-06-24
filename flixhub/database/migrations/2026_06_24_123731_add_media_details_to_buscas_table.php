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
    Schema::table('buscas', function (Blueprint $table) {
        $table->string('tipo')->nullable()->after('titulo_obra');
        $table->string('genero')->nullable()->after('tipo');
        $table->string('nota')->nullable()->after('genero');
        $table->boolean('favorito')->default(0)->after('nota');
        $table->string('imagem')->nullable()->after('favorito');
    });
}

public function down(): void
{
    Schema::table('buscas', function (Blueprint $table) {
        $table->dropColumn(['tipo', 'genero', 'nota', 'favorito', 'imagem']);
    });
}
};
