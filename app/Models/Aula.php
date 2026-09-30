<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aula extends Model
{
    protected $table = 'aulas';

    protected $fillable = [
        'data_aula',
        'horario_id',
        'disciplina_id',
    ];

    public function horario()
    {
        return $this->belongsTo(Horario::class);
    }

    public function disciplina()
    {
        return $this->belongsTo(Disciplina::class);
    }

    public function aulasMinistradas()
    {
        return $this->where('data_aula', '<=', 'data_aula')
        ->groupBy('data_aula')->count();
    }
}
