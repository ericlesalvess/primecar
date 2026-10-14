<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FluxoCaixa extends Model
{
    protected $table = 'fluxo_caixa';
    protected $guarded = ['id'];

    public function categoria()
    { 
        return $this->belongsTo(CategoriaFinanceira::class, 'categoria_financeira_id');
    }

     public function locacao()
    {
        return $this->belongsTo(Locacao::class,'locacao_id');
    }


}
