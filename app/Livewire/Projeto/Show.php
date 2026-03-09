<?php

namespace App\Livewire\Projeto;

use Livewire\Component;
use App\Models\Projeto as ProjetoModel;
use App\Models\Curso as CursoModel;

class Show extends Component
{
    public $projeto;
    public $id;

     public function mount($id)
    {
        $this->id = $id;
        $this->projeto = ProjetoModel::findOrFail($this->id);
    }

    public function render()
    {
        return view('livewire.projeto.show')->layout('layouts.app');
    }
}
