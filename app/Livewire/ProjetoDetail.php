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
use App\Models\Horario;
use App\Models\TipoMaterial;

class ProjetoDetail extends Component
{
    use WithPagination;

    public $isEditTurma = false;
    public $openModalTurma = false;
    public $openModalDisciplina = false;
    public $openModalParecer = false;
    public $openModalMaterial = false;
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
    public $valorHoraAulaCoordenador;
    public $valorHoraAulaInstrutorTitular;
    public $valorHoraAulaInstrutorSecundario;
    public $unidadeId;
    

    //campos do formulário de disciplina
    public $disciplinaId;
    public $nomeDisciplina;
    public $cargaHoraria;
    public $abreviacao;
    public $ementa;
    public $qtdInstrutoresTitulares;
    public $qtdInstrutoresSecundarios;
    public $referencias;
    public $conteudistaId;

    //campos do parecerTécnico
    public $parecerId;
    public $numero;
    public $validade;
    public $protocoloEletronico;

    //campos do formulário Material
    public $materialId;
    public $quantidadePorTurma;
    public $tipoMaterialId;

    //Variávies para operações com Horário
    public $openModalHorario = false;
    public $isEditHorario = false;
    public $idHorario;
    public $horaInicio;
    public $horaFim;


    
    public function mount(Projeto $projeto){
        $this->projeto = $projeto;
        $this->diretorias = Unidade::whereNull('unidade_gestora')->get();
        $this->tiposMateriais = TipoMaterial::all();
        $this->projetoId = $projeto->id;
    }

    public function render()
    {
        return view('livewire.projeto-detail', [
            'disciplinas' => $this->projeto->disciplinas,
            'materiais' => $this->projeto->material,
            'conteudistas' => $this->projeto->turmas->flatMap->conteudistas,
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
        $this->abreviacao = $disciplina->abreviacao;
        $this->ementa = $disciplina->ementa;
        $this->cargaHoraria = $disciplina->carga_horaria;
        $this->qtdInstrutoresTitulares = $disciplina->qtd_instrutores_titulares;
        $this->qtdInstrutoresSecundarios = $disciplina->qtd_instrutores_secundarios;
        $this->conteudistaId = $disciplina->conteudista_id;
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

        $this->openModalTurma = true;
        $this->isEditTurma = true;
    }

    public function editMaterial($id)
    {
        $material = Material::findOrFail($id);
        $this->materialId = $material->id;
        $this->quantidadePorTurma = $material->quantidade_por_turma;
        $this->projetoId = $material->projeto_id;
        $this->tipoMaterialId = $material->tipo_material_id;
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
            'abreviacao' => 'nullable|string|max:50',
            'ementa' => 'nullable|string',
            'cargaHoraria' => 'required|integer|min:1',
            'qtdInstrutoresTitulares' => 'nullable|integer|min:0',
            'qtdInstrutoresSecundarios' => 'nullable|integer|min:0',
            'conteudistaId' => 'nullable|exists:instrutores,id',
            'referencias' => 'nullable|string',
        ]);

        $disciplina = Disciplina::create([
            'nome' => $this->nomeDisciplina,
            'carga_horaria' => $this->cargaHoraria,
            'abreviacao' => $this->abreviacao,
            'ementa' => $this->ementa,
            'qtd_instrutores_titulares' => $this->qtdInstrutoresTitulares,
            'qtd_instrutores_secundarios' => $this->qtdInstrutoresSecundarios,
            'referencias' => $this->referencias,
            'projeto_id' => $this->projetoId,
            'conteudista_id' => $this->conteudistaId,
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
            'qtdInstrutoresTitulares' => 'nullable|integer|min:0',
            'qtdInstrutoresSecundarios' => 'nullable|integer|min:0',
            'conteudistaId' => 'nullable|exists:instrutores,id',
            'referencias' => 'nullable|string',
        ]);

        $disciplina = Disciplina::findOrFail($this->disciplinaId);
        $disciplina->update([
            'nome' => $this->nomeDisciplina,
            'carga_horaria' => $this->cargaHoraria,
            'abreviacao' => $this->abreviacao,
            'ementa' => $this->ementa,
            'qtd_instrutores_titulares' => $this->qtdInstrutoresTitulares,
            'qtd_instrutores_secundarios' => $this->qtdInstrutoresSecundarios,
            'referencias' => $this->referencias,
            'conteudista_id' => $this->conteudistaId
        ]);

        session()->flash('message', 'Disciplina atualizada com sucesso.');

        $this->openModalDisciplina = false;
        $this->resetFieldsDisciplina();
    }

    public function apagaDisciplina($id)
    {
        $disciplina = Disciplina::findOrFail($id);
        $disciplina->delete();

        $this->dispatch('showAlert', message: 'Disciplina apagada com sucesso!');
    }

    public function saveTurma()
    {
        $this->valorHoraAulaCoordenador = str_replace(',', '.', $this->valorHoraAulaCoordenador);
        $this->valorHoraAulaInstrutorTitular = str_replace(',', '.', $this->valorHoraAulaInstrutorTitular);
        $this->valorHoraAulaInstrutorSecundario = str_replace(',', '.', $this->valorHoraAulaInstrutorSecundario);


        $this->validate([
            'dataInicio' => 'required|date',
            'dataFim' => 'nullable|date|after_or_equal:dataInicio',
            'diasDeAulaPorSemana' => 'required|integer|min:0|max:7',
            'cargaHorariaDiaria' => 'required|integer|min:0|max:12',
            'valorHoraAulaCoordenador' => 'nullable|decimal:2|min:0',
            'valorHoraAulaInstrutorTitular' => 'nullable|decimal:2|min:0',
            'valorHoraAulaInstrutorSecundario' => 'nullable|decimal:2|min:0',
            'unidadeId' => 'required|exists:unidades,id',
        ]);

        Turma::create([
            'data_inicio' => $this->dataInicio,
            'data_fim' => $this->dataFim,
            'dias_de_aula_por_semana' => $this->diasDeAulaPorSemana,
            'carga_horaria_diaria' => $this->cargaHorariaDiaria,
            'valor_hora_aula_coordenador' => $this->valorHoraAulaCoordenador,
            'valor_hora_aula_instrutor_titular' => $this->valorHoraAulaInstrutorTitular,
            'valor_hora_aula_instrutor_secundario' => $this->valorHoraAulaInstrutorSecundario,
            'unidade_id' => $this->unidadeId,
            'projeto_id' => $this->projetoId
        ]);

        session()->flash('message', 'Turma criada com sucesso.');

        $this->openModalTurma = false;
        $this->resetFieldsTurma();
    }

    public function updateTurma()
    {
        $this->valorHoraAulaCoordenador = str_replace(',', '.', $this->valorHoraAulaCoordenador);
        $this->valorHoraAulaInstrutorTitular = str_replace(',', '.', $this->valorHoraAulaInstrutorTitular);
        $this->valorHoraAulaInstrutorSecundario = str_replace(',', '.', $this->valorHoraAulaInstrutorSecundario);

        $this->validate([
            'dataInicio' => 'required|date',
            'dataFim' => 'nullable|date|after_or_equal:dataInicio',
            'diasDeAulaPorSemana' => 'required|integer|min:0|max:7',
            'cargaHorariaDiaria' => 'required|integer|min:0|max:12',
            'unidadeId' => 'required|exists:unidades,id',
            'valorHoraAulaCoordenador' => 'nullable|decimal:2|min:0',
            'valorHoraAulaInstrutorTitular' => 'nullable|decimal:2|min:0',
            'valorHoraAulaInstrutorSecundario' => 'nullable|decimal:2|min:0',
        ]);

        $turma = Turma::findOrFail($this->turmaId);
        $turma->update([
            'data_inicio' => $this->dataInicio,
            'data_fim' => $this->dataFim,
            'dias_de_aula_por_semana' => $this->diasDeAulaPorSemana,
            'carga_horaria_diaria' => $this->cargaHorariaDiaria,
            'unidade_id' => $this->unidadeId,
            'valor_hora_aula_coordenador' => $this->valorHoraAulaCoordenador,
            'valor_hora_aula_instrutor_titular' => $this->valorHoraAulaInstrutorTitular,
            'valor_hora_aula_instrutor_secundario' => $this->valorHoraAulaInstrutorSecundario
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
            'tipoMaterialId' => 'required'
        ]);

        Material::create([
            'projeto_id' => $this->projetoId,
            'tipo_material_id' => $this->tipoMaterialId,
            'quantidade_por_turma' => $this->quantidadePorTurma,
        ]);
        session()->flash('message', 'Material Cadastrado com Sucesso');

        $this->resetFieldsMaterial();
        $this->openModalMaterial = false;
    }

    public function updateMaterial()
    {
        $this->validate([
            'quantidadePorTurma' => 'required|integer|min:1',
            'tipoMaterialId' => 'required'
        ]);

        $material = Material::findOrFail($this->materialId);
        $material->update([
            'tipo_material_id' => $this->tipoMaterialId,
            'quantidade_por_turma' => $this->quantidadePorTurma,
        ]);
        $this->resetFieldsMaterial();
        $this->openModalMaterial = false;
    }

    public function apagaMaterial($id){
        $material = Material::findOrFail($id);
        $material->delete();
        session()->flash('message','Material Apagado com Sucesso');
    }

    public function adicionarHorario()
    {
        $this->isEditHorario = false;
        $this->openModalHorario = true;
    }

    public function editarHorario($id)
    {
        $horario = Horario::findOrFail($id);
        $this->horaInicio = $horario->hora_inicio;
        $this->horaFim = $horario->hora_fim;
        $this->idHorario = $horario->id;

        $this->isEditHorario = true;
        $this->openModalHorario = true;
    }

    public function saveHorario()
    {
        $this->validate([
            'horaInicio' => ['required','date_format:H:i'],
            'horaFim' => ['required','date_format:H:i'],
        ]);

        Horario::create([
            'hora_inicio' => $this->horaInicio,
            'hora_fim' => $this->horaFim,
            'projeto_id' => $this->projetoId,
        ]);
        session()->flash('message','Horário Cadastrado com sucesso!');
        $this->openModalHorario = false;
        $this->isEditHorario = false;
        $this->resetFieldsHorario();
    }

    public function updateHorario()
    {
        $this->validate([
            'horaInicio' => ['required','date_format:H:i'],
            'horaFim' => ['required','date_format:H:i'],
        ]);

        $horario = Horario::findOrFail($this->idHorario);
        $horario->update([
            'hora_inicio' => $this->horaInicio,
            'hora_fim' => $this->horaFim,
        ]);
        session()->flash('message','Horário Atualizado com sucesso!');
        $this->openModalHorario = false;
        $this->isEditHorario = false;
        $this->resetFieldsHorario();
    }

    public function deleteHorario($id)
    {
        $horario = Horario::findOrFail($id);
        $horario->delete();
        session()->flash('message', 'Horário Apagado');
    }

    public function resetFieldsDisciplina()
    {
        $this->reset([
            'disciplinaId',
            'nomeDisciplina',
            'cargaHoraria',
            'abreviacao',
            'ementa',
            'qtdInstrutoresTitulares',
            'qtdInstrutoresSecundarios',
            'conteudistaId',
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
            'valorHoraAulaCoordenador',
            'valorHoraAulaInstrutorTitular',
            'valorHoraAulaInstrutorSecundario'
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
        ]);
    }

    public function resetFieldsHorario()
    {
        $this->reset([
            'horaInicio',
            'horaFim'
        ]);
    }

    public function viewTurma($id)
    {
        return redirect('/turma/'.$id);
    }
    
}
