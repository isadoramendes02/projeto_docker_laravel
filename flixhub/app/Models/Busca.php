<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Busca extends Model
{
    use HasFactory;

    protected $table = 'buscas';

    protected $fillable = [
    'user_id',
    'titulo_obra',
    'tipo',
    'genero',
    'nota',
    'favorito',
    'imagem',
    'comentario',
    'status',
];
}
