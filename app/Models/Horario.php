<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    protected $table = 'horarios';

    protected $fillable = [
        'hora_inicio',
        'hora_fim',
        'turma_id',
    ];

    public function turma()
    {
        return $this->belongsTo(Turma::class);
    }

    public function aulas()
    {
        return $this->hasMany(Aula::class);
    }
}
