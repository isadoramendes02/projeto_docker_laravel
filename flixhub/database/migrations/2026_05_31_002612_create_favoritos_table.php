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
    Schema::create('favoritos', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('favoritavel_id');
        $table->string('favoritavel_type');
        $table->text('comentario')->nullable(); // << ADICIONE ESTA LINHA
        $table->timestamps();
        
        $table->index(['favoritavel_id', 'favoritavel_type']);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favoritos');
    }
};
