<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Curso;
use App\Models\Projeto;
use App\Models\CentroEnsino;

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
    public $processo_eletronico;
    public $objetivo_geral;
    public $objetivos_especificos;
    public $publico_alvo;
    //campos do Projeto
    public $projetoId;
    public $data_aprovacao;
    public $quantidade_turmas;
    public $custo_pessoal=0.00;
    public $custo_material=0.00;
    public $custo_servicos=0.00;
    public $centro_ensino_id;
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

    public function createProjeto($cursoId)
    {
        $this->resetFieldsProjeto();
        $this->isEditProjeto = false;
        $this->openModalProjeto=true;
        $this->curso_id = $cursoId;
    }

    public function editCurso($id)
    {
        $curso = Curso::findOrFail($id);
        $this->cursoId = $curso->id;
        $this->nome = $curso->nome;
        $this->sigla = $curso->sigla;
        $this->processo_eletronico = $curso->processo_eletronico;
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
        $this->quantidade_turmas = $projeto->quantidade_turmas;
        $this->custo_pessoal = $projeto->custo_pessoal;
        $this->custo_material = $projeto->custo_material;
        $this->custo_servicos = $projeto->custo_servicos;
        $this->centro_ensino_id = $projeto->centro_ensino_id;
        $this->projetoId = $projeto->id;
        
        $this->isEditProjeto = true;
        $this->openModalProjeto = true;
    }

    public function saveCurso()
    {
        $this->validate([
            'nome' => 'required|string|max:255',
            'sigla' => 'required|string|max:50',
            'processo_eletronico' => 'required|string|max:25',
            'objetivo_geral' => 'nullable|string',
            'objetivos_especificos' => 'nullable|string',
            'publico_alvo' => 'nullable|string',
        ]);

        $data = [
            'nome' => $this->nome,
            'sigla' => $this->sigla,
            'processo_eletronico' => $this->processo_eletronico,
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
        $this->validate([
            'curso_id' => 'required|exists:cursos,id',
            'data_aprovacao' => 'required|date',
            'quantidade_turmas' => 'required|integer|min:1',
            'custo_pessoal' => 'required|numeric|min:0',
            'custo_material' => 'required|numeric|min:0',
            'custo_servicos' => 'required|numeric|min:0',
            'centro_ensino_id' => 'required|exists:centro_ensinos,id',
        ]);
        
        $data = [
            'curso_id' => $this->curso_id,
            'data_aprovacao' => $this->data_aprovacao,
            'quantidade_turmas' => $this->quantidade_turmas,
            'custo_pessoal' => $this->custo_pessoal,
            'custo_material' => $this->custo_material,
            'custo_servicos' => $this->custo_servicos,
            'centro_ensino_id' => $this->centro_ensino_id,
        ];

        Projeto::create($data);

        session()->flash('message', 'Projeto criado com sucesso.');

        $this->openModalProjeto = false;
        $this->resetFieldsProjeto();
    }

    public function updateCurso()
    {
        $curso = Curso::findOrFail($this->cursoId);

        $this->validate([
            'nome' => 'required|string|max:255',
            'sigla' => 'required|string|max:50',
            'processo_eletronico' => 'required|string|max:25',
            'objetivo_geral' => 'nullable|string',
            'objetivos_especificos' => 'nullable|string',
            'publico_alvo' => 'nullable|string',
        ]);

        $data = [
            'nome' => $this->nome,
            'sigla' => $this->sigla,
            'processo_eletronico' => $this->processo_eletronico,
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
        $this->validate([
            'curso_id' => 'required|exists:cursos,id',
            'data_aprovacao' => 'required|date',
            'quantidade_turmas' => 'required|integer|min:1',
            'custo_pessoal' => 'required|numeric|min:0',
            'custo_material' => 'required|numeric|min:0',
            'custo_servicos' => 'required|numeric|min:0',
            'centro_ensino_id' => 'required|exists:centro_ensinos,id',
        ]);

        $data = [
            'curso_id' => $this->curso_id,
            'data_aprovacao' => $this->data_aprovacao,
            'quantidade_turmas' => $this->quantidade_turmas,
            'custo_pessoal' => $this->custo_pessoal,
            'custo_material' => $this->custo_material,
            'custo_servicos' => $this->custo_servicos,
            'centro_ensino_id' => $this->centro_ensino_id,
        ];
        $projeto = Projeto::findOrFail($this->projetoId);

        $projeto->update($data);

        session()->flash('message', 'Projeto atualizado com sucesso.');

        $this->openModalProjeto = false;
        $this->resetFieldsProjeto();
    }

    public function viewProjeto($id)
    {
        return redirect('/projetos/' . $id);
    }

    public function resetFieldsCurso()
    {
        $this->reset(['cursoId', 'nome', 'sigla', 'processo_eletronico', 'objetivo_geral', 'objetivos_especificos', 'publico_alvo']);
    }

    public function resetFieldsProjeto()
    {
        $this->reset(['projetoId', 'curso_id', 'data_aprovacao', 'quantidade_turmas', 'custo_pessoal', 'custo_material', 'custo_servicos', 'centro_ensino_id']);
    }

    public function render()
    {
        return view('livewire.cursos-table', [
            'cursos' => Curso::with('projetos')->get(), 'centrosEnsino' => CentroEnsino::all(),
        ])->layout('layouts.app');
    }
}