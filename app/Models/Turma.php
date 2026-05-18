<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Turma extends Model
{
    protected $fillable = [
        'data_inicio',
        'data_fim',
        'edital_docente',
        'edital_discente',
        'portaria_docente',
        'portaria_matricula',
        'quantidade_matriculados',
        'portaria_conclusao',
        'quantidade_concluintes',
        'projeto_id'
    ];

    public function projeto()
    {
        return $this->belongsTo(Projeto::class);
    }
}
