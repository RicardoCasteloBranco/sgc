<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Projeto extends Model
{
    protected $fillable = [
        'curso_id',
        'data_aprovacao',
        'parecer_tecnico',
        'quantidade_turmas',
    ];

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    public function disciplinas()
    {
        return $this->hasManyThrough(Disciplina::class, 'disciplina_projeto', 'projeto_id', 'id', 'id', 'disciplina_id');
    }

    public function turmas()
    {
        return $this->hasMany(Turma::class);
    }

    public function encerrado()
    {
        return $this->turmas()->whereNotNull('data_fim')->exists();
    }
}
