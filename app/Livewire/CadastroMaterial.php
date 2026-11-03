<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\TipoMaterial;

class CadastroMaterial extends Component
{
    public $isEditTipoMaterial = false;
    public $openModalTipoMaterial = false;
    public $descricao;
    public $unidadeMedida;
    public $tipoMaterialId;
    public $naturezaMaterialId;


    public function render()
    {
        return view('livewire.cadastro-material',
         ['tiposMateriais' => TipoMaterial::orderBy('descricao')->get(),
         'naturezasMateriais' => \App\Models\NaturezaMaterial::orderBy('descricao')->get()])
         ->layout('layouts.app');
    }

    public function createTipoMaterial()
    {
        $this->openModalTipoMaterial = true;
        $this->isEditTipoMaterial = false;
        $this->reset(['descricao', 'unidadeMedida', 'naturezaMaterialId']);

    }

    public function editTipoMaterial($tipoMaterialId)
    {
         $tipo = TipoMaterial::findOrFail($tipoMaterialId);
         $this->tipoMaterialId = $tipo->id;
         $this->descricao = $tipo->descricao;
         $this->unidadeMedida = $tipo->unidade_medida;
         $this->naturezaMaterialId = $tipo->natureza_material_id;

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
            'natureza_material_id' => $this->naturezaMaterialId ?? null,
            'unidade_medida' => $this->unidadeMedida ?? null
        ]);

        session()->flash('message', 'Tipo de Material Criado com Sucesso');

        $this->openModalTipoMaterial = false;
        $this->reset(['descricao', 'unidadeMedida', 'naturezaMaterialId']);
    }

    public function updateTipoMaterial()
    {
        $this->validate([
            'descricao' => 'required',
        ]);
        
        $tipo = TipoMaterial::findOrFail($this->tipoMaterialId);
        $tipo->update([
            'descricao' => $this->descricao,
            'natureza_material_id' => $this->naturezaMaterialId ?? null,
            'unidade_medida' => $this->unidadeMedida ?? null,
        ]);

        session()->flash('message','Tipo de Material Atualizado');

        $this->openModalTipoMaterial = false;
        $this->reset(['descricao', 'unidadeMedida', 'naturezaMaterialId']);
    }
}
