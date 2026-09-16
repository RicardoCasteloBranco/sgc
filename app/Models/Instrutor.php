<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Instrutor extends Model
{
    protected $table = "instrutores";
    protected $fillable = [
        'posto_graduacao',
        'tipo_instrutor',
        'parecer_tecnico',
        'designacao',
        'substituicao',
        'pessoa_id',
        'turma_id',
        'disciplina_id'
    ];

    public function turma()
    {
        return $this->belongsTo(Turma::class);
    }

    public function disciplina()
    {
        return $this->belongsTo(Disciplina::class);
    }

    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class);
    }
}
