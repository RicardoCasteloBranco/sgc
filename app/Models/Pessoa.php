<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pessoa extends Model
{
    protected $table = "pessoas";
    protected $fillable = [
        'nome',
        'matricula',
         ];

    public function coordenador()
    {
        return $this->hasMany(Coordenador::class);
    }

    public function aluno()
    {
        return $this->hasMany(Aluno::class);
    }
}
