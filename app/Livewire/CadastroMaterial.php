<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\TipoMaterial;

class CadastroMaterial extends Component
{
    public $tiposMateriais = [];
    public $isEditTipoMaterial = false;
    public $openModalTipoMaterial = false;
    public $descricao;
    public $material_belico;
    public $id;


    public function mount()
    {
        $this->tiposMateriais = TipoMaterial::all();
    }

    public function render()
    {
        return view('livewire.cadastro-material')->layout('layouts.app');
    }

    public function createTipoMaterial()
    {
        $this->openModalTipoMaterial = true;
        $this->isEditTipoMaterial = false;
        $this->reset(['descricao','material_belico']);

    }

    public function editTipoMaterial($id)
    {
         $tipo = TipoMaterial::findOrFail($id);
         $this->id = $tipo->id;
         $this->descricao = $tipo->descricao;
         $this->material_belico = $tipo->material_belico;

         $this->isEditTipoMaterial = true;
         $this->openModalTipoMaterial = true;
    }

    public function saveTipoMaterial()
    {
        $this->validate([
            'descricao' => 'required',
        ]);

        TipoMaterial::create([
            'descricao' => $this->descricao,
            'material_belico' => $this->material_belico ?? false
        ]);

        session()->flash('message', 'Tipo de Material Criado com Sucesso');

        $this->openModalTipoMaterial = false;
        $this->reset(['descricao','material_belico']);
    }

    public function updateTipoMaterial()
    {
        $this->validate([
            'descricao' => 'required',
        ]);
        
        $tipo = TipoMaterial::findOrFail($this->id);
        $tipo->update([
            'descricao' => $this->descricao,
            'material_belico' => $this->material_belico ?? false
        ]);

        session()->flash('message','Tipo de Material Atualizado');

        $this->openModalTipoMaterial = false;
        $this->reset(['descricao','material_belico']);
    }
}
