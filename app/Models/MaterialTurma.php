<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialTurma extends Model
{
    protected $table = "material_turmas";
    protected $primaryKey = "id";
    protected $fillable = [
        'material_id',
        'turma_id',
        'valor_unitario',
        'descricao_material',
        'quantidade',
    ];

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function turma()
    {
        return $this->belongsTo(Turma::class);
    }
}
