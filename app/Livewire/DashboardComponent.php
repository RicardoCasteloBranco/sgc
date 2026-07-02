<?php

namespace App\Livewire;

use Livewire\Component;

class DashboardComponent extends Component
{
    public $alunos;
    public $projetos;
    public $turmas;
    public $cursos;
    public $valorHoraAula;
    public $alunosFormados;

    public function mount()
    {
        $this->alunos = $this->getAlunos();
        $this->projetos = $this->getProjetos();
        $this->turmas = $this->getTurmas();
        $this->cursos = \App\Models\Curso::all()->count();
        $this->valorHoraAula = \App\Models\Projeto::selectRaw('SUM(custo_pessoal) as total')->first()->total;
        $this->alunosFormados = \App\Models\Aluno::where('situacao', 'Aprovado(a)')->count();
    }

    public function render()
    {
        return view('livewire.dashboard')->layout('layouts.app');
    }

    private function getAlunos()
    {
        $dados = array();
        $matriculados = \App\Models\Turma::selectRaw('
            MONTH(data_inicio) as mes,
            COUNT(alunos.id) as total
        ')
        ->join('alunos','alunos.turma_id','=','turmas.id')
        ->whereNotNull('data_inicio')
        ->groupByRaw('MONTH(data_inicio)')
        ->orderByRaw('MONTH(data_inicio)')
        ->get();

        $desistentes = \App\Models\Turma::selectRaw('
            MONTH(data_inicio) as mes,
            COUNT(alunos.id) as total
        ')
        ->join('alunos','alunos.turma_id','=','turmas.id')
        ->whereNotNull('data_inicio')
        ->where('alunos.situacao','Desistente')
        ->groupByRaw('MONTH(data_inicio)')
        ->orderByRaw('MONTH(data_inicio)')
        ->get();

        for($i = 0; $i < 12; $i++){
            $dados[$i] = [
                'mes' => $this->getMes($i + 1),
                'matriculado' => 0,
                'desistente' => 0
            ];
        }
        for($i = 0; $i < count($matriculados); $i++){
            $dados[$matriculados[$i]->mes - 1] = [
                'mes' => $this->getMes($matriculados[$i]->mes),
                'matriculado' => isset($matriculados[$i]) ? $matriculados[$i]->total : 0,
                'desistente' => isset($desistentes[$i]) ? $desistentes[$i]->total : 0,
            ];
        }
        return $dados;
    }

    private function getMes($mes){
        switch($mes){
            case 1: return 'Janeiro';
            case 2: return 'Fevereiro';
            case 3: return 'Março';
            case 4: return 'Abril';
            case 5: return 'Maio';
            case 6: return 'Junho';
            case 7: return 'Julho';
            case 8: return 'Agosto';
            case 9: return 'Setembro';
            case 10: return 'Outubro';
            case 11: return 'Novembro';
            case 12: return 'Dezembro';
        }
    }

     private function getProjetos()
    {
        $dentroDoPrazo = 0;
        $foraDoPrazo = 0;

        $projetosSemPT = \App\Models\Projeto::whereNotExists(function ($query) {
            $query->select(\DB::raw(1))
                  ->from('pareceres_tecnicos')
                  ->whereColumn('pareceres_tecnicos.projeto_id', 'projetos.id');
        })->get();
        $projetosComPT = \App\Models\Projeto::whereHas('pareceresTecnicos', function ($query) {
            $query->whereNotNull('validade')
            ->latest('created_at')
            ->limit(1);
        })->get();
        $projetosComPT->filter(function($projeto) use (&$dentroDoPrazo, &$foraDoPrazo) {
            $parecer = $projeto->pareceresTecnicos()->latest('created_at')->first();
            if ($parecer && $parecer->validade >= now()) {
                $dentroDoPrazo++;
            } else {
                $foraDoPrazo++;
            }
        });
    
        return [
            [
                'status' => 'sem parecer técnico',
                'total' => $projetosSemPT->count()
            ],
            [
                'status' => 'com parecer técnico',
                'total' => $dentroDoPrazo
            ],
            [
                'status' => 'fora de validade',
                'total' => $foraDoPrazo
            ]
        ];
    }

    private function getTurmas()
    {
        $encerradas = \App\Models\Turma::whereNotNull('data_fim')->count();
        $andamento = \App\Models\Turma::whereNull('data_fim')->count();
        return [
            [
                'status' => 'Andamento',
                'total' => $andamento
            ],
            [
                'status' => 'Encerradas',
                'total' => $encerradas
            ]
        ];
    }
}
