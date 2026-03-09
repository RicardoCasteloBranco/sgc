<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supervisor extends Model
{
    protected $fillable = [
        'user_id',
        'centro_ensino_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function centroEnsino()
    {
        return $this->belongsTo(CentroEnsino::class);
    }
}
