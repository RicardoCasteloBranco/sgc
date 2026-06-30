<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menus';
    protected $fillable = [
        'titulo',
        'rota'
    ];

    public function perfil()
    {
        return $this->belongsToMany(Perfil::class,'acessos','menu_id','pefil_id');
    }
}
