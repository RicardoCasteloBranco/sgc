<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Projeto;
use App\Models\Unidade;

class ProjetoDetail extends Component
{
    
    public $projetoId;
    public $projeto;
    public $turmas;
    public $disciplinas;
    public $unidades;
    public $openModalTurma = false;
    public $isEditTurma = false;
    // Campo para turmas
    public $turmaId;
    public $turmaNome;
    public $dataInicio;
    public $dataFim;
    public $editalDocente;
    public $editalDiscente;
    public $portariaDocente;
    public $portariaMatricula;
    public $quantidadeMatriculados;
    public $portariaConclusao;
    public $quantidadeConcluintes;
    public $unidadeId;

    public function render()
    {
        $this->projetoId = request()->route('id');
        $this->projeto = Projeto::findOrFail($this->projetoId); // Verifica se o projeto existe, caso contrário lança um erro 404
        $this->unidades = Unidade::all();
        return view('livewire.projeto-detail')->layout('layouts.app');
    }

    public function createTurma()
    {
        $this->resetFieldsTurma();
        $this->isEditTurma = false;
        $this->openModalTurma = true;
    }

    public function editTurma($id)
    {
        $turma = \App\Models\Turma::findOrFail($id);
        $this->turmaId = $turma->id;
        $this->turmaNome = $turma->nome;
        $this->dataInicio = $turma->data_inicio;
        $this->dataFim = $turma->data_fim;
        $this->editalDocente = $turma->edital_docente;
        $this->editalDiscente = $turma->edital_discente;
        $this->portariaDocente = $turma->portaria_docente;
        $this->portariaMatricula = $turma->portaria_matricula;
        $this->quantidadeMatriculados = $turma->quantidade_matriculados;
        $this->portariaConclusao = $turma->portaria_conclusao;
        $this->quantidadeConcluintes = $turma->quantidade_concluintes;
        $this->unidadeId = $turma->unidade_id;
        $this->isEditTurma = true;
        $this->openModalTurma = true;
    }

    public function resetFieldsTurma()
    {
       $this->reset(['turmaId', 'turmaNome', 'dataInicio', 'dataFim', 'editalDocente', 'editalDiscente', 'portariaDocente', 'portariaMatricula', 'quantidadeMatriculados', 'portariaConclusao', 'quantidadeConcluintes', 'unidadeId']);
    }

    public function saveTurma()
    {
        $this->validate([
            'turmaNome' => 'required|string|max:255',
            'dataInicio' => 'required|date',
            'dataFim' => 'required|date|after_or_equal:dataInicio',
            // Adicione outras validações conforme necessário
        ]);

        $data = [
            'nome' => $this->turmaNome,
            'data_inicio' => $this->dataInicio,
            'data_fim' => $this->dataFim,
            'edital_docente' => $this->editalDocente,
            'edital_discente' => $this->editalDiscente,
            'portaria_docente' => $this->portariaDocente,
            'portaria_matricula' => $this->portariaMatricula,
            'quantidade_matriculados' => $this->quantidadeMatriculados,
            'portaria_conclusao' => $this->portariaConclusao,
            'quantidade_concluintes' => $this->quantidadeConcluintes,
            'unidade_id' => $this->unidadeId,
            'projeto_id' => $this->projetoId, // Associa a turma ao projeto atual
        ];

        $turma = new \App\Models\Turma();
        $turma->create($data);

        session()->flash('message', 'Turma criada com sucesso!');
        $this->openModalTurma = false;
    }

    public function updateTurma()
    {
        $this->validate([
            'turmaNome' => 'required|string|max:255',
            'dataInicio' => 'required|date',
            'dataFim' => 'required|date|after_or_equal:dataInicio',
            // Adicione outras validações conforme necessário
        ]);

        $data = [
            'nome' => $this->turmaNome,
            'data_inicio' => $this->dataInicio,
            'data_fim' => $this->dataFim,
            'edital_docente' => $this->editalDocente,
            'edital_discente' => $this->editalDiscente,
            'portaria_docente' => $this->portariaDocente,
            'portaria_matricula' => $this->portariaMatricula,
            'quantidade_matriculados' => $this->quantidadeMatriculados,
            'portaria_conclusao' => $this->portariaConclusao,
            'quantidade_concluintes' => $this->quantidadeConcluintes,
            'unidade_id' => $this->unidadeId,
        ];

        $turma = \App\Models\Turma::findOrFail($this->turmaId);
        $turma->update($data);

        session()->flash('message', 'Turma atualizada com sucesso!');
        $this->openModalTurma = false;
    }
    
}
