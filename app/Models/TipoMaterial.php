<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoMaterial extends Model
{
    protected $table = "tipo_materiais";
    protected $fillable = [
        'descricao',
        'material_belico',
        'unidade_medida',
    ];

    public function materiais()
    {
        return $this->hasMany(Material::class);
    }
}
