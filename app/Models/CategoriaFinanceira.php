<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriaFinanceira extends Model
{
    protected $table = 'categorias_financeiras';
    protected $guarded = ['id'];

    public function lancamentos()
    {
        return $this->hasMany(FluxoCaixa::class, 'categoria_financeira_id');
    }
}
