<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Perfil;
use App\Models\Menu;

class PerfilComponent extends Component
{
    public $perfis;
    public $menus;

    //Variáveis de Perfil
    public $isEditPerfil = false;
    public $openModalPerfil = false;
    public $perfil;
    public $descricao;

    public function render()
    {
        $this->perfis = Perfil::all();
        $this->menus = Menu::all();

        return view('livewire.perfil-component')->layout('layouts.app');
    }

    public function createPerfil()
    {
        $this->openModalPerfil = true;
        $this->reset([
            'descricao'
        ]);
    }

    public function editPerfil($id)
    {
        $this->perfil = Perfil::findOrFail($id);
        $this->descricao = $this->perfil->descricao;
        $this->openModalPerfil = true;
        $this->isEditPerfil = true;
    }

    public function deletePerfil($id)
    {
        $perfil = Perfil::findOrFail($id);
        $perfil->delete();
        session()->flash('Perfil apagado');
    }

    public function updatePerfil()
    {
        $this->validate([
            'descricao' => 'required|string|max:50'
        ]);
        $this->perfil->update([
            'descricao' => $this->descricao
        ]);
        session()->flash('Perfil Atualizado');
        $this->openModalPerfil = false;
        $this->reset(['descricao']);
        $this->isEditPerfil = false;
    }

    public function savePerfil()
    {
        $this->validate([
            'descricao' => 'required|string|max:50'
        ]);
        Perfil::create([
            'descricao' => $this->descricao
        ]);

        session()->flash('Perfil criado');
        $this->openModalPerfil = false;
        $this->reset(['descricao']);
        $this->isEditPerfil = false;
    }
}
