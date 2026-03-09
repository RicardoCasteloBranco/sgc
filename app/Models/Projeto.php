<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Projeto extends Model
{
    protected $fillable = [
        'curso_id',
        'ano',
    ];

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }
}
