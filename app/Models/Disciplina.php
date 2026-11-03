<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Disciplina extends Model
{
    protected $fillable = [
        'nome',
        'abreviacao',
        'ementa',
        'carga_horaria',
        'qtd_instrutores_titulares',
        'qtd_instrutores_secundarios',
        'referencias',
        'conteudista_id',
        'projeto_id',
    ];

    public function projeto()
    {
       return $this->belongsTo(Projeto::class);
    }

    public function instrutores()
    {
        return $this->hasMany(Instrutor::class);
    }

    public function conteudista()
    {
        return $this->belongsTo(Instrutor::class);
    }


}
