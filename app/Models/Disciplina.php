<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Disciplina extends Model
{
    protected $fillable = [
        'nome',
        'abreviacao',
        'ementa',
        'conhecimentos',
        'habilidades',
        'atitudes',
        'referencias',
    ];

    public function projetos()
    {
       return $this->belongsToManyThrough(Projeto::class, 'disciplina_projeto', 'disciplina_id', 'projeto_id', 'id', 'id');
    }
}
