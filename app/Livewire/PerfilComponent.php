<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Perfil;
use App\Models\Menu;
use App\Models\Acesso;

class PerfilComponent extends Component
{
    public $perfis;
    public $menus;
    public $acessos;

    //Variáveis de Perfil
    public $isEditPerfil = false;
    public $openModalPerfil = false;
    public $perfil;
    public $descricao;

    //Variáveis de Menu
    public $isEditMenu = false;
    public $openModalMenu = false;
    public $menu;
    public $titulo;
    public $rota;

    //Variáveis de Acesso
    public $openModalAcesso = false;
    public $perfil_id;
    public $menu_id;

    public function render()
    {
        $this->perfis = Perfil::all();
        $this->menus = Menu::all();
        $this->acessos = Acesso::all();

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

    public function createMenu()
    {
        $this->openModalMenu = true;
        $this->reset([
            'titulo',
            'rota'
        ]);
    }

    public function editMenu($id)
    {
        $this->menu = Menu::findOrFail($id);
        $this->titulo = $this->menu->titulo;
        $this->rota = $this->menu->rota;
        $this->openModalMenu = true;
        $this->isEditMenu = true;
    }

    public function deleteMenu($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->delete();
        session()->flash('Menu apagado');
    }

    public function updateMenu()
    {
        $this->validate([
            'titulo' => 'required|string|max:50',
            'rota' => 'required|string|max:50'
        ]);
        $this->menu->update([
            'titulo' => $this->titulo,
            'rota' => $this->rota
        ]);
        session()->flash('Menu Atualizado');
        $this->openModalMenu = false;
        $this->reset(['titulo', 'rota']);
        $this->isEditMenu = false;
    }

    public function saveMenu()
    {
        $this->validate([
            'titulo' => 'required|string|max:50',
            'rota' => 'required|string|max:50'
        ]);
        Menu::create([
            'titulo' => $this->titulo,
            'rota' => $this->rota
        ]);

        session()->flash('Menu criado');
        $this->openModalMenu = false;
        $this->reset(['titulo', 'rota']);
        $this->isEditMenu = false;
    }

    public function createAcesso()
    {
        $this->openModalAcesso = true;
        $this->reset([
            'perfil_id',
            'menu_id'
        ]);
    }

    public function saveAcesso()
    {
        $this->validate([
            'perfil_id' => 'required|exists:perfils,id',
            'menu_id' => 'required|exists:menus,id'
        ]);

        Acesso::create([
            'perfil_id' => $this->perfil_id,
            'menu_id' => $this->menu_id
        ]);

        session()->flash('Acesso criado');
        $this->openModalAcesso = false;
        $this->reset(['perfil_id', 'menu_id']);
    }

    public function deleteAcesso($id)
    {
        $acesso = Acesso::findOrFail($id);
        $acesso->delete();
        session()->flash('Acesso apagado');
    }
}
