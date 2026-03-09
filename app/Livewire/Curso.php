<?php

namespace App\Livewire;

use Livewire\Component;

class Curso extends Component
{
    public $cursos = [];
    public $isEditMode = false;
    public $isOpenModal = false;
    public $id;
    public $centro_ensino_id;
    public $nome, $objetivo_geral, $objetivos_especificos, $publico_alvo;

    protected $rules = [
        'centro_ensino_id' => 'nullable|exists:centro_ensinos,id',
        'nome' => 'required|string|max:255',
        'objetivo_geral' => 'required|string',
        'objetivos_especificos' => 'required|string',
        'publico_alvo' => 'required|string',
    ];

    public function render()
    {
        $this->centro_ensino_id = auth()->user()->centroEnsino->id;
        $this->cursos = \App\Models\Curso::where('centro_ensino_id', $this->centro_ensino_id)->get();
        return view('livewire.curso')->layout('layouts.app');
    }

    public function store()
    {
        $this->validate();

        \App\Models\Curso::create(
            [
                'centro_ensino_id' => $this->centro_ensino_id,
                'nome' => $this->nome,
                'objetivo_geral' => $this->objetivo_geral,
                'objetivos_especificos' => $this->objetivos_especificos,
                'publico_alvo' => $this->publico_alvo,
            ]);

        session()->flash('message','Curso criado com sucesso.');

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
        $curso = \App\Models\Curso::findOrFail($id);
        $this->id = $curso->id;
        $this->centro_ensino_id = $curso->centro_ensino_id;
        $this->nome = $curso->nome;
        $this->objetivo_geral = $curso->objetivo_geral;
        $this->objetivos_especificos = $curso->objetivos_especificos;
        $this->publico_alvo = $curso->publico_alvo;
        $this->isEditMode = true;
        $this->openModal();
    }

    public function update()
    {
        $this->validate();
        $curso = \App\Models\Curso::findOrFail($this->id);

        $curso->update(
            [
                'centro_ensino_id' => $this->centro_ensino_id,
                'nome' => $this->nome,
                'objetivo_geral' => $this->objetivo_geral,
                'objetivos_especificos' => $this->objetivos_especificos,
                'publico_alvo' => $this->publico_alvo,
            ]
        );

        session()->flash('message', 'Curso atualizado com sucesso.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function delete($id)
    {
        \App\Models\Curso::findOrFail($id)->delete();
        session()->flash('message', 'Curso deletado com sucesso.');
    }

    private function resetInputFields()
    {
        $this->nome = null;
        $this->objetivo_geral = null;
        $this->objetivos_especificos = null;
        $this->publico_alvo = null;
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
