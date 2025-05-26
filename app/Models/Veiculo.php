<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Veiculo extends Model
{
    protected $table = 'veiculos';
    protected $guarded = ['id'];

    public function locacoes()
    {
        return $this->hasMany(Locacao::class, 'veiculo_id');
    }
}
