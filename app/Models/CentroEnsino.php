<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CentroEnsino extends Model
{
    protected $table = 'centro_ensinos';
    protected $fillable = ['nome', 'sigla', 'centro_ensino_id'];

    public function centroEnsino()
    {
        return $this->belongsTo(CentroEnsino::class, 'centro_ensino_id');
    }

    public function centrosEnsinos()
    {
        return $this->hasMany(CentroEnsino::class, 'centro_ensino_id');
    }

    public function supervidores()
    {
        return $this->hasManyThrough(User::class, Supervisor::class, 'centro_ensino_id', 'id', 'id', 'user_id');
    }

    public function projetos()
    {
        return $this->hasMany(Projeto::class);
    }
}
