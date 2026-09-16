<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DisciplinaProjeto extends Model
{
    protected $table = 'disciplina_projeto';

    protected $fillable = [
        'disciplina_id',
        'projeto_id',
    ];

    public function disciplina()
    {
        return $this->belongsTo(Disciplina::class);
    }

    public function projeto()
    {
        return $this->belongsTo(Projeto::class);
    }
}