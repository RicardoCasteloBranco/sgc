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
}
