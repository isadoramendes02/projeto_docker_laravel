<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorito extends Model
{
    protected $table = 'favoritos';
    
    protected $fillable = ['favoritavel_id', 'favoritavel_type', 'comentario'];

    /**
     * Relacionamento polimórfico: descobre sozinho se o item é Filme ou Série
     */
    public function favoritavel()
    {
        return $this->morphTo();
    }
}
