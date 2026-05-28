<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\Projeto;
use App\Models\Unidade;
use App\Models\Turma;
use App\Models\Disciplina;
use App\Models\ParecerTecnico;

class ProjetoDetail extends Component
{
    use WithFileUploads, WithPagination;

    public $isEditTurma = false;
    public $openModalTurma = false;
    public $openModalDisciplina = false;
    public $openModalParecer = false;
    public $isEditDisciplina = false;
    public $projetoId;
    public Projeto $projeto;
    public $unidades;
    public $diretorias;

    //campos do formulário de turma
    public $turmaId;
    public $dataInicio;
    public $dataFim;
    public $unidadeId;
    public $quantidadeMatriculados;
    public $quantidadeConcluintes;
    public $editalDocente;
    public $editalDiscente;
    public $portariaDocente;
    public $portariaMatricula;
    public $portariaConclusao;

    //campos do formulário de disciplina
    public $disciplinaId;
    public $nomeDisciplina;
    public $cargaHoraria;
    public $abreviacao;
    public $ementa;
    public $conhecimentos;
    public $habilidades;
    public $atitudes;
    public $referencias;

    //campos do parecerTécnico
    public $numero;
    public $validade;
    public $arquivo;

    
    public function mount(Projeto $projeto){
        $this->projeto = $projeto;
        $this->diretorias = Unidade::whereNull('unidade_gestora')->get();
        $this->projetoId = $projeto->id;
    }

    public function render()
    {
        $disciplinas = Disciplina::where('projeto_id', $this->projetoId)
        ->orderBy('nome')
        ->paginate(4);

        return view('livewire.projeto-detail',['disciplinas' => $disciplinas])->layout('layouts.app');
    }

    public function createDisciplina()
    {
        $this->openModalDisciplina = true;
        $this->isEditDisciplina = false;
        $this->resetFieldsDisciplina();
    }

    public function createTurma()
    {
        $this->openModalTurma = true;
        $this->isEditTurma = false;
        $this->resetFieldsTurma();
    }

    public function createParecerTecnico()
    {
        $this->openModalParecer = true;
        $this->resetFieldsParecer();
    }

    public function editDisciplina($id)
    {
        $disciplina = Disciplina::findOrFail($id);
        $this->disciplinaId = $disciplina->id;
        $this->nomeDisciplina = $disciplina->nome;
        $this->cargaHoraria = $disciplina->carga_horaria;
        $this->abreviacao = $disciplina->abreviacao;
        $this->ementa = $disciplina->ementa;
        $this->conhecimentos = $disciplina->conhecimentos;
        $this->habilidades = $disciplina->habilidades;
        $this->atitudes = $disciplina->atitudes;
        $this->referencias = $disciplina->referencias;

        $this->openModalDisciplina = true;
        $this->isEditDisciplina = true;
    }

    public function editTurma($id)
    {
        $turma = Turma::findOrFail($id);
        $this->turmaId = $turma->id;
        $this->dataInicio = $turma->data_inicio;
        $this->dataFim = $turma->data_fim;
        $this->unidadeId = $turma->unidade_id;
        $this->quantidadeMatriculados = $turma->quantidade_matriculados;
        $this->quantidadeConcluintes = $turma->quantidade_concluintes;
        $this->editalDocente = $turma->edital_docente;
        $this->editalDiscente = $turma->edital_discente;
        $this->portariaDocente = $turma->portaria_docente;
        $this->portariaMatricula = $turma->portaria_matricula;
        $this->portariaConclusao = $turma->portaria_conclusao;

        $this->openModalTurma = true;
        $this->isEditTurma = true;
    }

    public function saveDisciplina()
    {
        $this->validate([
            'nomeDisciplina' => 'required|string|max:255',
            'cargaHoraria' => 'required|integer|min:1',
            'abreviacao' => 'nullable|string|max:50',
            'ementa' => 'nullable|string',
            'conhecimentos' => 'nullable|string',
            'habilidades' => 'nullable|string',
            'atitudes' => 'nullable|string',
            'referencias' => 'nullable|string',
        ]);

        $disciplina = Disciplina::create([
            'nome' => $this->nomeDisciplina,
            'carga_horaria' => $this->cargaHoraria,
            'abreviacao' => $this->abreviacao,
            'ementa' => $this->ementa,
            'conhecimentos' => $this->conhecimentos,
            'habilidades' => $this->habilidades,
            'atitudes' => $this->atitudes,
            'referencias' => $this->referencias,
            'projeto_id' => $this->projetoId,
        ]);

        session()->flash('message', 'Disciplina criada com sucesso.');

        $this->openModalDisciplina = false;
        $this->resetFieldsDisciplina();
    }

    public function updateDisciplina()
    {
        $this->validate([
            'nomeDisciplina' => 'required|string|max:255',
            'cargaHoraria' => 'required|integer|min:1',
            'abreviacao' => 'nullable|string|max:50',
            'ementa' => 'nullable|string',
            'conhecimentos' => 'nullable|string',
            'habilidades' => 'nullable|string',
            'atitudes' => 'nullable|string',
            'referencias' => 'nullable|string',
        ]);

        $disciplina = Disciplina::findOrFail($this->disciplinaId);
        $disciplina->update([
            'nome' => $this->nomeDisciplina,
            'carga_horaria' => $this->cargaHoraria,
            'abreviacao' => $this->abreviacao,
            'ementa' => $this->ementa,
            'conhecimentos' => $this->conhecimentos,
            'habilidades' => $this->habilidades,
            'atitudes' => $this->atitudes,
            'referencias' => $this->referencias
        ]);

        session()->flash('message', 'Disciplina atualizada com sucesso.');

        $this->openModalDisciplina = false;
        $this->resetFieldsDisciplina();
    }

    public function saveTurma()
    {
        $this->validate([
            'dataInicio' => 'required|date',
            'dataFim' => 'nullable|date|after_or_equal:dataInicio',
            'unidadeId' => 'required|exists:unidades,id',
            'quantidadeMatriculados' => 'required|integer|min:0',
            'quantidadeConcluintes' => 'nullable|integer|min:0|max:quantidadeMatriculados',
            'editalDocente' => 'nullable|string|max:255',
            'editalDiscente' => 'nullable|string|max:255',
            'portariaDocente' => 'nullable|string|max:255',
            'portariaMatricula' => 'nullable|string|max:255',
            'portariaConclusao' => 'nullable|string|max:255',
        ]);

        Turma::create([
            'data_inicio' => $this->dataInicio,
            'data_fim' => $this->dataFim,
            'unidade_id' => $this->unidadeId,
            'quantidade_matriculados' => $this->quantidadeMatriculados,
            'quantidade_concluintes' => $this->quantidadeConcluintes,
            'edital_docente' => $this->editalDocente,
            'edital_discente' => $this->editalDiscente,
            'portaria_docente' => $this->portariaDocente,
            'portaria_matricula' => $this->portariaMatricula,
            'portaria_conclusao' => $this->portariaConclusao,
            'projeto_id' => $this->projetoId
        ]);

        session()->flash('message', 'Turma criada com sucesso.');

        $this->openModalTurma = false;
        $this->resetFieldsTurma();
    }

    public function updateTurma()
    {
        $this->validate([
            'dataInicio' => 'required|date',
            'dataFim' => 'nullable|date|after_or_equal:dataInicio',
            'unidadeId' => 'required|exists:unidades,id',
            'quantidadeMatriculados' => 'required|integer|min:0',
            'quantidadeConcluintes' => 'nullable|integer|min:0|max:quantidadeMatriculados',
            'editalDocente' => 'nullable|string|max:255',
            'editalDiscente' => 'nullable|string|max:255',
            'portariaDocente' => 'nullable|string|max:255',
            'portariaMatricula' => 'nullable|string|max:255',
            'portariaConclusao' => 'nullable|string|max:255',
        ]);

        $turma = Turma::findOrFail($this->turmaId);
        $turma->update([
            'data_inicio' => $this->dataInicio,
            'data_fim' => $this->dataFim,
            'unidade_id' => $this->unidadeId,
            'quantidade_matriculados' => $this->quantidadeMatriculados,
            'quantidade_concluintes' => $this->quantidadeConcluintes,
            'edital_docente' => $this->editalDocente,
            'edital_discente' => $this->editalDiscente,
            'portaria_docente' => $this->portariaDocente,
            'portaria_matricula' => $this->portariaMatricula,
            'portaria_conclusao' => $this->portariaConclusao
        ]);

        session()->flash('message', 'Turma atualizada com sucesso.');

        $this->openModalTurma = false;
        $this->resetFieldsTurma();
    }

    public function saveParecer()
    {
        $this->validate([
            'arquivo' => 'required|file|max:2048|mimes:pdf',
            'validade' => 'required|date',
            'numero' => 'required'
        ]);

        ParecerTecnico::create([
            'numero' => $this->numero,
            'validade' => $this->validade,
            'projeto_id' => $this->projetoId,
            'name' => $this->arquivo->getClientOriginalName(),
            'mime_type' => $this->arquivo->getMimeType(),
            'file_data' => file_get_contents($this->arquivo->getRealPath()),
        ]);

        session()->flash('message','Arquivo criado com sucesso');
        $this->resetFieldsParecer();
        $this->openModalParecer = false;
    }

    public function deleteParecer($id)
    {
        $parecer = ParecerTecnico::findOrFail($id);
        $parecer->delete();

        session()->flash('message','Arquivo apagado com sucesso');
    }

    public function resetFieldsDisciplina()
    {
        $this->reset([
            'disciplinaId',
            'nomeDisciplina',
            'cargaHoraria',
            'abreviacao',
            'ementa',
            'conhecimentos',
            'habilidades',
            'atitudes',
            'referencias'
        ]);
    }

    public function resetFieldsTurma()
    {
        $this->reset([
            'turmaId',
            'dataInicio',
            'dataFim',
            'unidadeId',
            'quantidadeMatriculados',
            'quantidadeConcluintes',
            'editalDocente',
            'editalDiscente',
            'portariaDocente',
            'portariaMatricula',
            'portariaConclusao'
        ]);
    }

    public function resetFieldsParecer()
    {
        $this->reset([
            'arquivo',
            'validade',
            'numero'
        ]);
    }
    
}
