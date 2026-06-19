<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialBelico extends Model
{
    protected $table = "materiais_belicos";
    protected $fillable = [
        'quantidade_por_aluno',
        'projeto_id',
        'tipo_material_belico_id'
    ];

    public function tipoMaterialBelico()
    {
        return $this->belongsTo(TipoMaterialBelico::class, 'tipo_material_belico_id');
    }

    public function projeto()
    {
        return $this->belongsTo(Projeto::class,'projeto_id');
    }
}
