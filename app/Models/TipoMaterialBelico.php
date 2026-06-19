<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoMaterialBelico extends Model
{
    protected $table = "tipo_materiais_belicos";
    protected $fillable = [
        'descricao'
    ];

    public function materiaisBelicos()
    {
        return $this->hasMany(MaterialBelico::class);
    }
}
