<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Graduacao extends Model
{
    private $table = "graduacoes";
    private $primaryKey = "id";
    private $fillable = [
        'extenso',
        'abreviado'
    ];
}
