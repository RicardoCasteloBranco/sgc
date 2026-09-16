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

    public function perfil()
    {
        return $this->belongsTo(Perfil::class);
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
