<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Turma;

class TurmaDetail extends Component
{
    public $turma;

    public function mount(Turma $turma)
    {
        $this->turma = $turma;
    }

    public function render()
    {
        return view('livewire.turma-detail')->layout('layouts.app');
    }
}
