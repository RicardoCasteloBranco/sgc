<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Projeto;
use App\Models\Unidade;
use App\Models\Turma;
use App\Models\Disciplina;
use App\Models\ParecerTecnico;
use App\Models\Material;
use App\Models\TipoMaterial;

class ProjetoDetail extends Component
{
    use WithPagination;

    public $isEditTurma = false;
    public $openModalTurma = false;
    public $openModalDisciplina = false;
    public $openModalParecer = false;
    public $openModalMaterial = false;
    public $openModalDeletaMaterial = false;
    public $isEditDisciplina = false;
    public $isEditMaterial = false;
    public $isEditParecer = false;
    public $projetoId;
    public Projeto $projeto;
    public $unidades;
    public $diretorias;
    public $tiposMateriais;

    //campos do formulário de turma
    public $turmaId;
    public $dataInicio;
    public $dataFim;
    public $diasDeAulaPorSemana;
    public $cargaHorariaDiaria;
    public $unidadeId;
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
    public $parecerId;
    public $numero;
    public $validade;
    public $protocoloEletronico;

    //campos do formulário Material
    public $materialId;
    public $quantidadePorTurma;
    public $custoUnitario;
    public $tipoMaterialId;


    
    public function mount(Projeto $projeto){
        $this->projeto = $projeto;
        $this->diretorias = Unidade::whereNull('unidade_gestora')->get();
        $this->tiposMateriais = TipoMaterial::all();
        $this->projetoId = $projeto->id;
    }

    public function render()
    {
        return view('livewire.projeto-detail', [
            'disciplinas' => Disciplina::where('projeto_id', $this->projetoId)
                ->orderBy('nome')
                ->paginate(5),

            'materiais' => $this->projeto->material,
        ])->layout('layouts.app');
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

    public function createMaterial()
    {
        $this->openModalMaterial = true;
        $this->isEditMaterial = false;
        $this->resetFieldsMaterial();
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
        $this->diasDeAulaPorSemana = $turma->dias_de_aula_por_semana;
        $this->cargaHorariaDiaria = $turma->carga_horaria_diaria;
        $this->unidadeId = $turma->unidade_id;
        $this->editalDocente = $turma->edital_docente;
        $this->editalDiscente = $turma->edital_discente;
        $this->portariaDocente = $turma->portaria_docente;
        $this->portariaMatricula = $turma->portaria_matricula;
        $this->portariaConclusao = $turma->portaria_conclusao;

        $this->openModalTurma = true;
        $this->isEditTurma = true;
    }

    public function editMaterial($id)
    {
        $material = Material::findOrFail($id);
        $this->materialId = $material->id;
        $this->tipoMaterialId = $material->tipo_material_id;
        $this->projetoId = $material->projeto_id;
        $this->quantidadePorTurma = $material->quantidade_por_turma;
        $this->custoUnitario = $material->custo_unitario;
        $this->openModalMaterial = true;
        $this->isEditMaterial = true;
    }

    public function editParecer($id)
    {
        $parecer = ParecerTecnico::findOrFail($id);
        $this->numero = $parecer->numero;
        $this->validade = $parecer->validade;
        $this->protocoloEletronico = $parecer->protocolo_eletronico;
        $this->projetoId = $parecer->projeto_id;

        $this->openModalParecer = true;
        $this->isEditParecer = true;
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
            'diasDeAulaPorSemana' => 'required|integer|min:0|max:7',
            'cargaHorariaDiaria' => 'required|integer|min:0|max:10',
            'unidadeId' => 'required|exists:unidades,id',
            'editalDocente' => 'nullable|string|max:255',
            'editalDiscente' => 'nullable|string|max:255',
            'portariaDocente' => 'nullable|string|max:255',
            'portariaMatricula' => 'nullable|string|max:255',
            'portariaConclusao' => 'nullable|string|max:255',
        ]);

        Turma::create([
            'data_inicio' => $this->dataInicio,
            'data_fim' => $this->dataFim,
            'dias_de_aula_por_semana' => $this->diasDeAulaPorSemana,
            'carga_horaria_diaria' => $this->cargaHorariaDiaria,
            'unidade_id' => $this->unidadeId,
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
            'diasDeAulaPorSemana' => 'required|integer|min:0|max:7',
            'cargaHorariaDiaria' => 'required|integer|min:0|max:10',
            'unidadeId' => 'required|exists:unidades,id',
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
            'dias_de_aula_por_semana' => $this->diasDeAulaPorSemana,
            'carga_horaria_diaria' => $this->cargaHorariaDiaria,
            'unidade_id' => $this->unidadeId,
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
            'protocoloEletronico' => 'required',
            'validade' => 'required|date',
            'numero' => 'required'
        ]);

        ParecerTecnico::create([
            'numero' => $this->numero,
            'validade' => $this->validade,
            'projeto_id' => $this->projetoId,
            'protocolo_eletronico' => $this->protocoloEletronico,
        ]);

        session()->flash('message','Parecer registrado com sucesso');
        $this->resetFieldsParecer();
        $this->openModalParecer = false;
    }

    public function updateParecer()
    {
        $this->validate([
            'protocoloEletronico' => 'required',
            'validade' => 'required|date',
            'numero' => 'required'
        ]);

        $parecer = ParecerTecnico::findOrFail($this->parecerId);
        $parecer->update([
            'numero' => $this->numero,
            'validade' => $this->validade,
            'protocolo_eletronico' => $this->protocoloEletronico
        ]);

        session()->flash('message','Parecer Atualizado');
        $this->resetFieldsParecer();
        $this->openModalParecer = false;
        $this->isEditParecer = false;
    }

    public function deleteParecer($id)
    {
        $parecer = ParecerTecnico::findOrFail($id);
        $parecer->delete();

        session()->flash('message','Arquivo apagado com sucesso');
    }

    public function saveMaterial()
    {
        $this->validate([
            'quantidadePorTurma' => 'required|integer|min:1',
            'custoUnitario' => ['required', 'regex:/^\d+(,\d{1,2})?$/'],
            'tipoMaterialId' => 'required'
        ]);

        Material::create([
            'projeto_id' => $this->projetoId,
            'tipo_material_id' => $this->tipoMaterialId,
            'quantidade_por_turma' => $this->quantidadePorTurma,
            'custo_unitario' => str_replace(',', '.', $this->custoUnitario)
        ]);
        session()->flash('message', 'Material Cadastrado com Sucesso');

        $this->resetFieldsMaterial();
        $this->openModalMaterial = false;
    }

    public function updateMaterial()
    {
        $this->validate([
            'quantidadePorTurma' => 'required|integer|min:1',
            'custoUnitario' => ['required', 'regex:/^\d+(,\d{1,2})?$/'],
            'tipoMaterialId' => 'required'
        ]);

        $material = Material::findOrFail($this->materialId);
        $material->update([
            'tipo_material_id' => $this->tipoMaterialId,
            'quantidade_por_turma' => $this->quantidadePorTurma,
            'custo_unitario' => str_replace(',', '.', $this->custoUnitario),
        ]);
        $this->resetFieldsMaterial();
        $this->openModalMaterial = false;
    }

    public function apagaMaterial($id){
        $this->material = Material::findOrFail($id);
        $this->openModalDeletaMaterial = true;
    }

    public function deleteMaterial()
    {
        $this->material->delete();
        session()->flash('message','Material Apagado com Sucesso');
        $this->openModalDeletaMaterial = false;
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
            'diasDeAulaPorSemana',
            'cargaHorariaDiaria',
            'unidadeId',
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
            'protocoloEletronico',
            'validade',
            'numero',
        ]);
    }

    public function resetFieldsMaterial()
    {
        $this->reset([
            'quantidadePorTurma',
            'tipoMaterialId',
            'custoUnitario'
        ]);
    }

    public function viewTurma($id)
    {
        return redirect('/turma/'.$id);
    }
    
}
