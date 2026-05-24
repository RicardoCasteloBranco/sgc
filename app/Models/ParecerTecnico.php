<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParecerTecnico extends Model
{
    protected $table = 'pareceres_tecnicos';

    protected $fillable = [
        'numero',
        'validade',
        'arquivo',
        'nome_arquivo',
        'projeto_id',
    ];

    public function projeto()
    {
        return $this->belongsTo(Projeto::class);
    }
}
