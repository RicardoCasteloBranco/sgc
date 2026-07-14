<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $table = "materiais";
    protected $fillable = [
        'quantidade_por_turma',
        'custo_unitario',
        'projeto_id',
        'tipo_material_id'
    ];

    public function tipoMaterial()
    {
        return $this->belongsTo(TipoMaterial::class, 'tipo_material_id');
    }

    public function projeto()
    {
        return $this->belongsTo(Projeto::class,'projeto_id');
    }
}
