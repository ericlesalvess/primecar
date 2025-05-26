<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';
    protected $guarded = ['id'];

    public function locacoes()
    {
        return $this->hasMany(Locacao::class, 'cliente_id');
    }
}