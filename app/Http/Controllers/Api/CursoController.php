<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CursoController extends Controller
{

    public function cursosEmAndamento()
    {
        $dados = array();
        $cursos = \App\Models\Curso::whereHas('turmas', function ($query) {
            $query->whereYear('data_inicio', date('Y'));
        })->get();
        foreach ($cursos as $curso) {
            foreach($curso->turmas as $turma) {
                $dados[] = [
                    'curso' => $curso->nome,
                    'sigla' => $curso->sigla,
                    'data_inicio' => date('d/m/Y', strtotime($turma->data_inicio)),
                    'status' => $turma->statusTurma(),
                    'link' => $turma->linkEdital()
                ];
            }
        }
        return response()->json($dados);
    }
}
