<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Acesso extends Model
{
    protected $table = 'acessos';
    protected $fillable = [
        'perfil_id',
        'menu_id'
    ];
}
