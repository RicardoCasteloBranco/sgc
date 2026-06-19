<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\TipoMaterialBelico;

class CadastroMaterialBelico extends Component
{
    public $tiposMateriais = [];
    public $isEditTipoMaterialBelico = false;
    public $openModalTipoMaterialBelico = false;
    public $descricao;
    public $projetoId;
    public $id;

    public function render()
    {
        $this->tiposMateriais = TipoMaterialBelico::all();
        return view('livewire.cadastro-material-belico')->layout('layouts.app');
    }

    public function createTipoMaterialBelico()
    {
        $this->openModalTipoMaterialBelico = true;
        $this->isEditTipoMaterialBelico = false;
        $this->reset(['descricao']);

    }

    public function editTipoMaterialBelico($id)
    {
         $tipo = TipoMaterialBelico::findOrFail($id);
         $this->id = $tipo->id;
         $this->descricao = $tipo->descricao;

         $this->isEditTipoMaterialBelico = true;
         $this->openModalTipoMaterialBelico = true;
    }

    public function saveTipoMaterialBelico()
    {
        $this->validate([
            'descricao' => 'required'
        ]);

        TipoMaterialBelico::create([
            'descricao' => $this->descricao
        ]);

        session()->flash('message', 'Tipo de Material Bélico Criado com Sucesso');

        $this->openModalTipoMaterialBelico = false;
        $this->reset(['descricao']);
    }

    public function updateTipoMaterialBelico()
    {
        $this->validate([
            'descricao' => 'required'
        ]);
        
        $tipo = TipoMaterialBelico::findOrFail($this->id);
        $tipo->update([
            'descricao' => $this->descricao
        ]);

        session()->flash('message','Tipo de Material Bélico Atualizado');

        $this->openModalTipoMaterialBelico = false;
        $this->reset(['descricao']);
    }
}
