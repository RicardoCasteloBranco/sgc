<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function turmas()
    {
        $encerradas = \App\Models\Turma::whereNotNull('data_fim')->count();
        $andamento = \App\Models\Turma::whereNull('data_fim')->count();
        return response()->json([
            [
                'status' => 'Andamento',
                'total' => $andamento
            ],
            [
                'status' => 'Encerradas',
                'total' => $encerradas
            ]
        ]);
    }

    public function cursos()
    {
        $cursosPrevistos = \App\Models\Curso::whereHas('turmas', function ($query) {
            $query->whereNull('data_fim')
            ->whereYear('data_inicio', date('Y'));
        })->get();
        $cursosEncerrados = \App\Models\Curso::whereHas('turmas', function ($query) {
            $query->whereNotNull('data_fim')
            ->whereYear('data_inicio', date('Y'));
        })->get();
        return response()->json([
            [
                'status' => 'Previstos',
                'total' => $cursosPrevistos->count()
            ],
            [
                'status' => 'Encerrados',
                'total' => $cursosEncerrados->count()
            ]
        ]);
    }

    public function alunos()
    {
        $dados = array();
        $concluintes = \App\Models\Turma::selectRaw('
            MONTH(data_fim) as mes,
            SUM(quantidade_concluintes) as total
        ')
        ->whereNotNull('data_fim')
        ->groupByRaw('MONTH(data_fim)')
        ->orderByRaw('MONTH(data_fim)')
        ->get();
        foreach($concluintes as $concluinte){
            $dados[] = [
                'mes' => $this->getMes($concluinte->mes),
                'total' => $concluinte->total
            ];
        }
        return response()->json($dados);
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
}
