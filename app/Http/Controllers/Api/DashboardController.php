<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function turmasEncerradas()
    {
        $encerradas = \App\Models\Turma::whereNotNull('data_fim')->get();
        return response()->json($encerradas);
    }

    public function turmasAndamento()
    {
        $andamento = \App\Models\Turma::whereNull('data_fim')->get();
        return response()->json($andamento);
    }

    public function projetos()
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
    
        return response()->json([
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
        ]);
    }

    public function alunos()
    {
        $dados = [];

        // ============================
        // MATRICULADOS
        // ============================
        $matriculados = \App\Models\Turma::selectRaw('
            YEAR(data_inicio) as ano,
            MONTH(data_inicio) as mes,
            COUNT(alunos.id) as total
        ')
        ->join('alunos', 'alunos.turma_id', '=', 'turmas.id')
        ->whereNotNull('data_inicio')
        ->groupByRaw('YEAR(data_inicio), MONTH(data_inicio)')
        ->orderByRaw('YEAR(data_inicio), MONTH(data_inicio)')
        ->get();


        // ============================
        // DESISTENTES
        // ============================
        $desistentes = \App\Models\Turma::selectRaw('
            YEAR(data_inicio) as ano,
            MONTH(data_inicio) as mes,
            COUNT(alunos.id) as total
        ')
        ->join('alunos', 'alunos.turma_id', '=', 'turmas.id')
        ->whereNotNull('data_inicio')
        ->where('alunos.situacao', 'Desistente')
        ->groupByRaw('YEAR(data_inicio), MONTH(data_inicio)')
        ->orderByRaw('YEAR(data_inicio), MONTH(data_inicio)')
        ->get();


        // ============================
        // EXCLUÍDOS
        // ============================
        $excluidos = \App\Models\Turma::selectRaw('
            YEAR(data_inicio) as ano,
            MONTH(data_inicio) as mes,
            COUNT(alunos.id) as total
        ')
        ->join('alunos', 'alunos.turma_id', '=', 'turmas.id')
        ->whereNotNull('data_inicio')
        ->where('alunos.situacao', 'Excluido(a)')
        ->groupByRaw('YEAR(data_inicio), MONTH(data_inicio)')
        ->orderByRaw('YEAR(data_inicio), MONTH(data_inicio)')
        ->get();


        // ============================
        // APROVADOS
        // ============================
        $aprovados = \App\Models\Turma::selectRaw('
            YEAR(data_fim) as ano,
            MONTH(data_fim) as mes,
            COUNT(alunos.id) as total
        ')
        ->join('alunos', 'alunos.turma_id', '=', 'turmas.id')
        ->whereNotNull('data_fim')
        ->where('alunos.situacao', 'Aprovado(a)')
        ->groupByRaw('YEAR(data_fim), MONTH(data_fim)')
        ->orderByRaw('YEAR(data_fim), MONTH(data_fim)')
        ->get();


        // ============================
        // IDENTIFICAR TODOS OS ANOS
        // ============================
        $anos = collect([
            ...$matriculados->pluck('ano'),
            ...$desistentes->pluck('ano'),
            ...$excluidos->pluck('ano'),
            ...$aprovados->pluck('ano'),
        ])
        ->filter()
        ->unique()
        ->sort()
        ->values();


        // ============================
        // INDEXAR POR ANO + MÊS
        // ============================

        $matriculados = $matriculados->keyBy(function ($item) {
            return $item->ano . '-' . $item->mes;
        });

        $desistentes = $desistentes->keyBy(function ($item) {
            return $item->ano . '-' . $item->mes;
        });

        $excluidos = $excluidos->keyBy(function ($item) {
            return $item->ano . '-' . $item->mes;
        });

        $aprovados = $aprovados->keyBy(function ($item) {
            return $item->ano . '-' . $item->mes;
        });


        // ============================
        // MONTAR OS DADOS
        // ============================

        foreach ($anos as $ano) {

            for ($mes = 1; $mes <= 12; $mes++) {

                $chave = $ano . '-' . $mes;

                $dados[] = [
                    'ano' => $ano,

                    'mes' => $this->getMes($mes),

                    'matriculado' =>
                        $matriculados->get($chave)?->total ?? 0,

                    'desistente' =>
                        $desistentes->get($chave)?->total ?? 0,

                    'excluido' =>
                        $excluidos->get($chave)?->total ?? 0,

                    'aprovado' =>
                        $aprovados->get($chave)?->total ?? 0,
                ];
            }
        }


        // ============================
        // RETORNO
        // ============================

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
