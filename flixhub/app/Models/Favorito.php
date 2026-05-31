<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorito extends Model
{
    protected $fillable = [
        'favoritavel_id',
        'favoritavel_type',
        'comentario' // << GARANTA QUE ESTÁ AQUI
    ];

    public function favoritavel()
    {
        return $this->morphTo();
    }
}