<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coordenador extends Model
{
    public $table = "coordenadores";
    public $fillable = [
        'data_designacao',
        'parecer_tecnico',
        'pessoa_id',
        'turma_id'
    ];

    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class,'pessoa_id');
    }

    public function turma()
    {
        return $this->belongsTo(Turma::class,'turma_id');
    }
}
