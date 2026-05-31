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
        Schema::create('filmes', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->string('genero'); // Adicionado
            $table->text('descricao')->nullable();
            $table->decimal('nota', 2, 1)->default(0.0); // Ajustado para aceitar decimais (ex: 4.5)
            $table->string('imagem')->nullable(); // Adicionado
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('filmes');
    }
};
