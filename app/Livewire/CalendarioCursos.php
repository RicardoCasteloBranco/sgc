<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Turma;
use Illuminate\Support\Collection;

class CalendarioCursos extends Component
{
    public $events = [];

    public function mount()
    {
        $this->events = Turma::with('projeto.curso')->get()->map(function ($turma) {
            return [
                'id' => $turma->id,
                'title' => $turma->projeto->curso->sigla,
                'start' => $turma->data_inicio,
                'end' => is_null($turma->data_fim)
                    ? $turma->previsaoTermino()
                    : $turma->data_fim,
            ];
        })->toArray();
    }

    public function render()
    {
        return view('livewire.calendario-cursos')
            ->layout('layouts.app');
    }
}