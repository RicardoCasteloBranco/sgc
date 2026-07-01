<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\PerfilUsuario;
use App\Models\User;
use App\Models\Perfil;

class PerfilUsuarioComponent extends Component
{
    public $openModalPerfilUsuario = false;
    public $perfil_id;
    public $user_id;
    public $perfisUsuarios;
    public $usuarios;
    public $perfis;

    public function mount()
    {
        $this->perfisUsuarios = PerfilUsuario::all();
        $this->usuarios = User::all();
        $this->perfis = Perfil::all();
    }

    public function render()
    {
        return view('livewire.perfil-usuario-component')->layout('layouts.app');
    }

    public function createAcesso()
    {
        $this->reset(['perfil_id', 'user_id']);
        $this->openModalPerfilUsuario = true;
    }
    public function savePerfilUsuario()
    {
        $this->validate([
            'perfil_id' => 'required|exists:perfils,id',
            'user_id' => 'required|exists:users,id',
        ]);

        PerfilUsuario::create([
            'perfil_id' => $this->perfil_id,
            'user_id' => $this->user_id,
        ]);

        $this->openModalPerfilUsuario = false;
        $this->perfisUsuarios = PerfilUsuario::all();
    }

    public function deletePerfilUsuario($id)
    {
        $perfilUsuario = PerfilUsuario::findOrFail($id);
        $perfilUsuario->delete();
        $this->perfisUsuarios = PerfilUsuario::all();
    }
}
