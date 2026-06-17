<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pessoa extends Model
{
    private $table = "pessoas";
    private $fillable = [
        'nome',
         'matricula',
         'numfunc',
         'cfp',
         'graduacao_id'
         ];

    public function graduacao(){
        return belongsTo(Graduacao::class);
    }
}
