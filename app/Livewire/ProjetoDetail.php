<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Projeto;

class ProjetoDetail extends Component
{
    public $projetoId;
    public $projeto;

    public function render()
    {
        $this->projetoId = request()->route('id');
        $this->projeto = Projeto::findOrFail($this->projetoId); // Verifica se o projeto existe, caso contrário lança um erro 404
        return view('livewire.projeto-detail')->layout('layouts.app');
    }
}
