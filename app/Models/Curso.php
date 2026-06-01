<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    protected $fillable = [
        'nome',
        'sigla',
        'objetivo_geral',
        'objetivos_especificos',
        'publico_alvo',
        'centro_ensino_id',
    ];

    public function projetos()
    {
        return $this->hasMany(Projeto::class);
    }

    public function centroEnsino()
    {
        return $this->belongsTo(CentroEnsino::class);
    }

    public function turmas()
    {
        return $this->hasManyThrough(Turma::class, Projeto::class);
    }
}
