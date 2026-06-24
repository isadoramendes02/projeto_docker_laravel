<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filme extends Model
{
    use HasFactory;

    // Define o nome correto da tabela no banco
    protected $table = 'filmes';

    // AUTORIZAÇÃO: Permite que o user_id seja gravado no banco
    protected $fillable = [
        'titulo',
        'genero',
        'descricao',
        'nota',
        'imagem',
        'user_id' // 👈 Garanta que essa linha está EXATAMENTE assim
    ];
}
