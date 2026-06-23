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

    public function materialBelico()
    {
        return $this->hasMany(MaterialBelico::class);
    }

    public function cargaHorariaTotal()
    {
        return $this->disciplinas()->sum('carga_horaria');
    }

    public function numeroProjeto()
    {
        $ids = self::where('curso_id', $this->curso_id)
            ->orderBy('data_aprovacao')
            ->orderBy('id')
            ->pluck('id')
            ->values();
        $id = $ids->search($this->id) + 1;
        return $this->curso->sigla." ".$id.'/'.date('Y',strtotime($this->data_aprovacao));
    }
}
