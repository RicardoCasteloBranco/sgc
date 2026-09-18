<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DateTime;
use DateInterval;

class Turma extends Model
{
    protected $fillable = [
        'data_inicio',
        'data_fim',
        'dias_de_aula_por_semana',
        'carga_horaria_diaria',
        'edital_docente',
        'edital_discente',
        'portaria_docente',
        'portaria_matricula',
        'portaria_conclusao',
        'unidade_id',
        'projeto_id'
    ];

    public function projeto()
    {
        return $this->belongsTo(Projeto::class);
    }

    public function unidade()
    {
        return $this->belongsTo(Unidade::class);
    }

    public function encerradas()
    {
        return $this->whereNotNull('data_fim')->whereYear('data_inicio', date('Y'))->exists();
    }

    public function andamento()
    {
        return $this->whereNull('data_fim')->whereYear('data_inicio', date('Y'))->exists();
    }

    public function coordenador()
    {
        return $this->hasOne(Coordenador::class)->latestOfMany('data_designacao');
    }

    public function alunos()
    {
        return $this->hasMany(Aluno::class);
    }

    public function instrutores()
    {
        return $this->hasMany(Instrutor::class);
    }

    public function statusTurma()
    {
        if(!is_null($this->portaria_conclusao)) {
            return 'Curso Concluído';
        }
        if(!is_null($this->portaria_matricula)) {
            return 'Curso Iniciado';
        }
        if(!is_null($this->edital_discente) or !is_null($this->edital_docente)) {
            return 'Fase de Seleção';
        }
        if(!is_null($this->data_inicio)
            && is_null($this->data_fim)
            && is_null($this->edital_discente)
            && is_null($this->edital_docente)
            && is_null($this->portaria_matricula)
            && is_null($this->portaria_conclusao)) {
            return 'Previsto';
        }
        return 'Sem Previsão para esse período';

    }

    public function linkEdital()
    {
        if(!is_null($this->edital_docente)) {
            return $this->edital_docente;
        }
        if(!is_null($this->edital_discente)) {
            return $this->edital_discente;
        }
        return null;
    }

    public function previsaoTermino(){
        if(!is_null($this->data_inicio) && is_null($this->data_fim)) {
            $date = new DateTime($this->data_inicio);
            $inicio = $date->getTimestamp();
            $dias_necessarios = ceil($this->projeto->cargaHorariaTotal() / $this->carga_horaria_diaria);
            $qtd_semanas = ceil($dias_necessarios / $this->dias_de_aula_por_semana);
            $dias_totais = new DateInterval('P' . ($qtd_semanas * 7) . 'D');
            return $date->add($dias_totais)->format('Y-m-d');
        }
        return null;
    }

    public function numeroTurma(){
        $ids = self::where('projeto_id', $this->projeto_id)
            ->orderBy('data_inicio')
            ->orderBy('id')
            ->pluck('id')
            ->values();
        return $ids->search($this->id) + 1;
    }

    public function quantidadeMatriculados()
    {
        return $this->alunos()->count();
    }

    public function quantidadeAprovados()
    {
        return $this->alunos->where('situacao','Aprovado(a)')->count();
    }

    public function quantidadeDesistentes()
    {
        return $this->alunos->where('situacao','Desistente')->count();
    }

    public function quantidadeExcluidos()
    {
        return $this->alunos->where('situacao','Excluído(a)')->count();
    }
}
