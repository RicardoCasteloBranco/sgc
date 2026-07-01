<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerfilUsuario extends Model
{
    protected $table = 'perfil_usuarios';
    protected $fillable = [
        'user_id',
        'perfil_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function perfil()
    {
        return $this->belongsTo(Perfil::class);
    }
}
