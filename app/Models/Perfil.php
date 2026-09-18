<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    protected $table = 'perfils';
    protected $fillable = [
        'descricao'
    ];

    public function menus()
    {
        return $this->belongsToMany(Menu::class,'acessos','perfil_id','menu_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class,'perfil_usuarios','perfil_id','user_id');
    }
}
