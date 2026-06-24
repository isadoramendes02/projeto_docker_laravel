<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('series', function (Blueprint $table) {
        $table->id();
        $table->string('titulo');
        $table->string('genero');
        $table->text('descricao')->nullable();
        $table->decimal('nota', 2, 1)->default(0.0);
        $table->string('imagem')->nullable();
        $table->timestamps();
    });
}
    public function down(): void
    {
        Schema::dropIfExists('series');
    }
};
