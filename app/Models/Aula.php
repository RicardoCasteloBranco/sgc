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
        $horarioAtual = $this->horario;

        return self::where('disciplina_id', $this->disciplina_id)
            ->where(function ($query) use ($horarioAtual) {

                $query->where('data_aula', '<', $this->data_aula)

                    ->orWhere(function ($query) use ($horarioAtual) {

                        $query->where('data_aula', $this->data_aula)
                            ->whereHas('horario', function ($query) use ($horarioAtual) {
                                $query->where('hora_inicio', '<=', $horarioAtual->hora_inicio);
                            });

                    });

            })
            ->count();
    }
}
