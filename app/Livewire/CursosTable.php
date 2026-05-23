<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Curso;
use App\Models\Projeto;

class CursosTable extends Component
{
    public $expanded = [];
    public $openModalCurso = false;
    public $openModalProjeto = false;
    public $isEditCurso = false;
    public $isEditProjeto = false;
    // Campos do Curso
    public $cursoId;
    public $nome;
    public $sigla;
    public $objetivo_geral;
    public $objetivos_especificos;
    public $publico_alvo;
    //campos do Projeto
    public $projetoId;
    public $data_aprovacao;
    public $parecer_tecnico;
    public $quantidade_turmas;
    public $curso_id;


    public function toggle($id)
    {
        $this->expanded[$id] = !($this->expanded[$id] ?? false);
    }

    public function createCurso()
    {
        $this->resetFieldsCurso();
        $this->isEditCurso = false;
        $this->openModalCurso = true;
    }

    public function createProjeto()
    {
        $this->resetFieldsProjeto();
        $this->isEditProjeto = false;
        $this->openModalProjeto=true;
    }

    public function editCurso($id)
    {
        $curso = Curso::findOrFail($id);
        $this->cursoId = $curso->id;
        $this->nome = $curso->nome;
        $this->sigla = $curso->sigla;
        $this->objetivo_geral = $curso->objetivo_geral;
        $this->objetivos_especificos = $curso->objetivos_especificos;
        $this->publico_alvo = $curso->publico_alvo;
        
        $this->isEditCurso = true;
        $this->openModalCurso = true;
    }
    public function editProjeto($id)
    {
        $projeto = Projeto::findOrFail($id);
        $this->curso_id = $projeto->curso_id;
        $this->data_aprovacao = $projeto->data_aprovacao;
        $this->parecer_tecnico = $projeto->parecer_tecnico;
        $this->quantidade_turmas = $projeto->quantidade_turmas;

        $this->isEditProjeto = true;
        $this->openModalProjeto = true;
    }

    public function saveCurso()
    {
        $data = [
            'nome' => $this->nome,
            'sigla' => $this->sigla,
            'objetivo_geral' => $this->objetivo_geral,
            'objetivos_especificos' => $this->objetivos_especificos,
            'publico_alvo' => $this->publico_alvo,
        ];

        Curso::create($data);

        session()->flash('message', 'Curso criado com sucesso.');

        $this->openModalCurso = false;
        $this->resetFieldscurso();
    }

    public function saveProjeto()
    {
        $data = [
            'curso_id' => $this->curso_id,
            'data_aprovacao' => $this->data_aprovacao,
            'parecer_tecnico' => $this->parecer_tecnico,
            'quantidade_turmas' => $this->quantidade_turmas,
        ];

        Projeto::create($data);

        session()->flash('message', 'Projeto criado com sucesso.');

        $this->openModalProjeto = false;
        $this->resetFieldsProjeto();
    }

    public function updateCurso()
    {
        $curso = Curso::findOrFail($this->cursoId);

        $data = [
            'nome' => $this->nome,
            'sigla' => $this->sigla,
            'objetivo_geral' => $this->objetivo_geral,
            'objetivos_especificos' => $this->objetivos_especificos,
            'publico_alvo' => $this->publico_alvo,
        ];

        $curso->update($data);

        session()->flash('message', 'Curso atualizado com sucesso.');

        $this->openModalCurso = false;
        $this->resetFieldsCurso();
    }

    public function updateProjeto()
    {
        $projeto = Projeto::findOrFail($this->projetoId);

        $data = [
            'curso_id' => $this->curso_id,
            'data_aprovacao' => $this->data_aprovacao,
            'parecer_tecnico' => $this->parecer_tecnico,
            'quantidade_turmas' => $this->quantidade_turmas,
        ];

        $projeto->update($data);

        session()->flash('message', 'Projeto atualizado com sucesso.');

        $this->openModalProjeto = false;
        $this->resetFieldsProjeto();
    }

    public function resetFieldsCurso()
    {
        $this->reset(['cursoId', 'nome', 'sigla', 'objetivo_geral', 'objetivos_especificos', 'publico_alvo']);
    }

    public function resetFieldsProjeto()
    {
        $this->reset(['projetoId', 'curso_id', 'data_aprovacao', 'parecer_tecnico', 'quantidade_turmas']);
    }

    public function render()
    {
        return view('livewire.cursos-table', [
            'cursos' => Curso::with('projetos')->get(),
        ])->layout('layouts.app');
    }
}