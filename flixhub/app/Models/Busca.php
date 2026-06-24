<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Busca extends Model
{
    use HasFactory;

    // Define a tabela explicitamente (boa prática)
    protected $table = 'buscas';

    // Libera os campos para serem salvos no banco
    protected $fillable = [
    'titulo_obra',
    'comentario',
    'user_id',
    'status'
];
}
