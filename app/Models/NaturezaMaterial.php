<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NaturezaMaterial extends Model
{
    protected $table = "natureza_materiais";
    protected $primaryKey = "id";
    protected $fillable = [
        'descricao',
    ];

    public function tipoMateriais()
    {
        return $this->hasMany(TipoMaterial::class);
    }
}
