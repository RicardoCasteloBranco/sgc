<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\CentroEnsino as CentroEnsinoModel;


class CentroEnsino extends Component
{
    public $centros = [];
    public $isEditMode = false;
    public $isOpenModal = false;
    public $id;
    public $nome;
    public $sigla;
    public $centro_ensino_id;

    protected $rules = [
        'nome' => 'required|string|max:255',
        'sigla' => 'required|string|max:10',
        'centro_ensino_id' => 'nullable|exists:centros_ensino,id',
    ];


    public function render()
    {
        $this->centros = CentroEnsinoModel::all();
        return view('livewire.centro-ensino')->layout('layouts.app');
    }

    public function store()
    {
        $this->validate();

        CentroEnsinoModel::create(
            [
                'nome' => $this->nome,
                'sigla' => $this->sigla,
                'centro_ensino_id' => $this->centro_ensino_id,
            ]);

        session()->flash('message','Centro de Ensino criado com sucesso.');

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
        $centro = CentroEnsinoModel::findOrFail($id);
        $this->id = $centro->id;
        $this->nome = $centro->nome;
        $this->sigla = $centro->sigla;
        $this->centro_ensino_id = $centro->centro_ensino_id;
        $this->isEditMode = true;
        $this->openModal();
    }

    public function update()
    {
        $this->validate();
        $centro = CentroEnsinoModel::findOrFail($this->id);

        $centro->update(
            [
                'nome' => $this->nome,
                'sigla' => $this->sigla,
                'centro_ensino_id' => $this->centro_ensino_id,
            ]
        );

        session()->flash('message', 'Centro de Ensino atualizado com sucesso.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function delete($id)
    {
        CentroEnsinoModel::findOrFail($id)->delete();
        session()->flash('message', 'Centro de Ensino deletado com sucesso.');
    }

    private function resetInputFields()
    {
        $this->nome = '';
        $this->sigla = '';
        $this->centro_ensino_id = null;
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
