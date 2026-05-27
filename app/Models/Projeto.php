<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Projeto extends Model
{
    protected $fillable = [
        'curso_id',
        'data_aprovacao',
        'quantidade_turmas',
        'custo_pessoal',
        'custo_material',
        'custo_servicos',
        'centro_ensino_id',
    ];

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    public function disciplinas()
    {
        return $this->hasMany(Disciplina::class);
    }

    public function turmas()
    {
        return $this->hasMany(Turma::class);
    }

    public function centroEnsino()
    {
        return $this->belongsTo(CentroEnsino::class);
    }

    public function encerrado()
    {
        return $this->turmas()->whereNotNull('data_fim')->exists();
    }

    public function pareceresTecnicos()
    {
        return $this->hasMany(ParecerTecnico::class);
    }
}
