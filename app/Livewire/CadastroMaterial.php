<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\TipoMaterial;

class CadastroMaterial extends Component
{
    public $isEditTipoMaterial = false;
    public $openModalTipoMaterial = false;
    public $descricao;
    public $material_belico;
    public $unidade_medida;
    public $tipoMaterialId;


    public function render()
    {
        return view('livewire.cadastro-material', ['tiposMateriais' => TipoMaterial::orderBy('descricao')->get()])->layout('layouts.app');
    }

    public function createTipoMaterial()
    {
        $this->openModalTipoMaterial = true;
        $this->isEditTipoMaterial = false;
        $this->reset(['descricao','material_belico', 'unidade_medida']);

    }

    public function editTipoMaterial($tipoMaterialId)
    {
         $tipo = TipoMaterial::findOrFail($tipoMaterialId);
         $this->tipoMaterialId = $tipo->id;
         $this->descricao = $tipo->descricao;
         $this->material_belico = $tipo->material_belico;
         $this->unidade_medida = $tipo->unidade_medida;

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
            'material_belico' => $this->material_belico ?? false,
            'unidade_medida' => $this->unidade_medida ?? null
        ]);

        session()->flash('message', 'Tipo de Material Criado com Sucesso');

        $this->openModalTipoMaterial = false;
        $this->reset(['descricao','material_belico','unidade_medida']);
    }

    public function updateTipoMaterial()
    {
        $this->validate([
            'descricao' => 'required',
        ]);
        
        $tipo = TipoMaterial::findOrFail($this->id);
        $tipo->update([
            'descricao' => $this->descricao,
            'material_belico' => $this->material_belico ?? false,
            'unidade_medida' => $this->unidade_medida ?? null,
        ]);

        session()->flash('message','Tipo de Material Atualizado');

        $this->openModalTipoMaterial = false;
        $this->reset(['descricao','material_belico','unidade_medida']);
    }
}
