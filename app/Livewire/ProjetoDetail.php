<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Projeto;
use App\Models\Unidade;
use App\Models\Turma;

class ProjetoDetail extends Component
{
    public $isEditTurma = false;
    public $openModalTurma = false;
    public $projetoId;
    public Projeto $projeto;
    public $unidades;

    //campos do formulário de turma
    public $dataInicio;

    
    public function mount(Projeto $projeto){
        $this->projeto = $projeto;
        $this->unidades = Unidade::all();
    }

    public function render()
    {
        return view('livewire.projeto-detail')->layout('layouts.app');
    }

    public function createTurma()
    {
        $this->openModalTurma = true;
    }
    
}
