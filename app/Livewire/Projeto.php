<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Curso as CursoModel;
use App\Models\Projeto as ProjetoModel;

class Projeto extends Component
{
    public $projetos;
    public $cursos;
    public $isEditMode = false;
    public $isOpenModal = false;
    public $id;
    public $curso_id, $ano;

    protected $rules = [
        'curso_id' => 'required|exists:cursos,id',
        'ano' => 'required|size:4',
    ];


    public function render()
    {
        $this->projetos = ProjetoModel::all();
        $this->cursos = CursoModel::all();
        return view('livewire.projeto')->layout('layouts.app');
    }

    public function store()
    {
        $this->validate();

        ProjetoModel::create(
            [
                'curso_id' => $this->curso_id,
                'data_aprovacao' => $this->data_aprovacao,
            ]);

        session()->flash('message','Projeto criado com sucesso.');

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
        $projeto = ProjetoModel::findOrFail($id);
        $this->id = $projeto->id;
        $this->curso_id = $projeto->curso_id;
        $this->data_aprovacao = $projeto->data_aprovacao;
        $this->isEditMode = true;
        $this->openModal();
    }

    public function update()
    {
        $this->validate();
        $projeto = ProjetoModel::findOrFail($this->id);

        $projeto->update(
            [
                'curso_id' => $this->curso_id,
                'data_aprovacao' => $this->data_aprovacao,
            ]
        );

        session()->flash('message', 'Projeto atualizado com sucesso.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function delete($id)
    {
        ProjetoModel::findOrFail($id)->delete();
        session()->flash('message', 'Projeto deletado com sucesso.');
    }

    public function view($id)
    {
        return redirect()->route('projeto.show', ['id' => $id]);
    }

    private function resetInputFields()
    {
        $this->curso_id = null;
        $this->data_aprovacao = null;
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
