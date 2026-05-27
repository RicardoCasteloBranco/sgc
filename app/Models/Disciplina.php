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
        'conhecimentos',
        'habilidades',
        'atitudes',
        'referencias',
        'projeto_id',
    ];

    public function projeto()
    {
       return $this->belongsTo(Projeto::class);
    }


}
