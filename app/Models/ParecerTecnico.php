<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParecerTecnico extends Model
{
    protected $table = 'pareceres_tecnicos';

    protected $fillable = [
        'numero',
        'validade',
        'protocolo_eletronico',
        'projeto_id',
    ];

    protected $hidden = ['file_data'];

    public function projeto()
    {
        return $this->belongsTo(Projeto::class);
    }
}
