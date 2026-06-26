<?php

namespace App\Livewire;

use Livewire\Component;

class DashboardComponent extends Component
{
    public $alunos;
    public $projetos;
    public $turmas;

    public function mount()
    {
        $this->alunos = $this->getAlunos();
        $this->projetos = $this->getProjetos();
        $this->turmas = $this->getTurmas();

    }

    public function render()
    {
        return view('livewire.dashboard')->layout('layouts.app');
    }

    private function getAlunos()
    {
        $dados = array();
        $concluintes = \App\Models\Turma::selectRaw('
            MONTH(data_inicio) as mes,
            COUNT(alunos.id) as total
        ')
        ->join('alunos','alunos.turma_id','=','turmas.id')
        ->whereNotNull('data_inicio')
        ->groupByRaw('MONTH(data_inicio)')
        ->orderByRaw('MONTH(data_inicio)')
        ->get();
        for($i = 0; $i < 12; $i++){
            $dados[$i] = [
                'mes' => $this->getMes($i + 1),
                'total' => 0
            ];
        }
        foreach($concluintes as $concluinte){
            $dados[$concluinte->mes - 1] = [
                'mes' => $this->getMes($concluinte->mes),
                'total' => $concluinte->total
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
