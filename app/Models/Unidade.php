<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unidade extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'sigla',
        'unidade_gestora',
    ];

    public function gestora()
    {
        return $this->belongsTo(Unidade::class, 'unidade_gestora');
    }

    public function subordinadas()
    {
        return $this->hasMany(Unidade::class, 'unidade_gestora');
    }

    public function diretorias()
    {
        return $this->whereNull('unidade_gestora')->get();
    }

    public function turmas()
    {
        return $this->hasMany(Turma::class);
    }
}