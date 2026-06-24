<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('buscas', function (Blueprint $table) {
        $table->id();
        $table->string('titulo_obra'); 
        $table->text('comentario');   
        $table->timestamps();
    });
}
    public function down(): void
    {
        Schema::dropIfExists('buscas');
    }
};
