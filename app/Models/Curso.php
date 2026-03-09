<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    protected $fillable = [
        'nome',
        'objetivo_geral',
        'objetivos_especificos',
        'publico_alvo',
        'centro_ensino_id',
    ];

    public function centroEnsino()
    {
        return $this->belongsTo(CentroEnsino::class);
    }
}
