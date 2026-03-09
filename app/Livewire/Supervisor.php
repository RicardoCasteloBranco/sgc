<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\CentroEnsino as CentroEnsinoModel;
use App\Models\Supervisor as SupervisorModel;
use App\Models\User;

class Supervisor extends Component
{
    public $centros = [];
    public $users = [];
    public $supervisores = [];
    public $isEditMode = false;
    public $isOpenModal = false;
    public $id;
    public $centro_ensino_id;
    public $user_id;

    protected $rules = [
        'centro_ensino_id' => 'nullable|exists:centro_ensinos,id',
        'user_id' => 'nullable|exists:users,id',
    ];

    public function render()
    {
        $this->centros = CentroEnsinoModel::all();
        $this->users = User::all();
        $this->supervisores = SupervisorModel::all();
        return view('livewire.supervisor')->layout('layouts.app');
    }

    public function store()
    {
        $this->validate();

        SupervisorModel::create(
            [
                'centro_ensino_id' => $this->centro_ensino_id,
                'user_id' => $this->user_id,
            ]);

        session()->flash('message','Supervisor atribuído com sucesso.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function create()
    {
        $this->isEditMode = false;
        $this->resetInputFields();
        $this->openModal();
    }

    public function edit($id)
    {
        $supervisor = SupervisorModel::findOrFail($id);
        $this->id = $supervisor->id;
        $this->centro_ensino_id = $supervisor->centro_ensino_id;
        $this->user_id = $supervisor->user_id;
        $this->isEditMode = true;
        $this->openModal();
    }

    public function update()
    {
        $this->validate();
        $supervisor = SupervisorModel::findOrFail($this->id);

        $supervisor->update(
            [
                'centro_ensino_id' => $this->centro_ensino_id,
                'user_id' => $this->user_id,
            ]
        );

        session()->flash('message', 'Supervisor atualizado com sucesso.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function delete($id)
    {
        SupervisorModel::findOrFail($id)->delete();
        session()->flash('message', 'Supervisor deletado com sucesso.');
    }

    private function resetInputFields()
    {
        $this->centro_ensino_id = null;
        $this->user_id = null;
    }

    public function openModal()
    {
        $this->isOpenModal = true;
    }

    public function closeModal()
    {
        $this->isOpenModal = false;
    }
}
