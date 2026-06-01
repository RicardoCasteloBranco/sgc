<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function turmas()
    {
        $encerradas = \App\Models\Turma::with('encerradas')->count();
        $andamento = \App\Models\Turma::with('andamento')->count();
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
        $concluintes = \App\Models\Turma::selectRaw('
            MONTH(data_fim) as mes,
            SUM(quantidade_concluintes) as total
        ')
        ->whereNotNull('data_fim')
        ->groupByRaw('MONTH(data_fim)')
        ->orderByRaw('MONTH(data_fim)')
        ->get();
        
        return response()->json(
            [
                'mes' => $concluintes->pluck('mes'),
                'total' => $concluintes->pluck('total')
            ]
        );
    }
}
