<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Turma;
use App\Models\Pessoa;
use App\Models\Aluno;
use App\Models\Coordenador;
use App\Models\Instrutor;
use App\Models\Disciplina;
use App\Models\Horario;
use App\Models\Aula;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Livewire\Attributes\On;

class TurmaDetail extends Component
{
    public $turma;
    public $alunos;
    public $turmaId;
    public $graduacoes = ['Cel PM','Ten Cel PM', 'Maj PM','Cap PM','1º Ten PM','2º Ten PM',
        'Asp PM','Cad PM','Al CHO PM','Al CFO PM','Sub Ten PM','1º Sgt PM','2º Sgt PM','3º Sgt PM','Al CFS PM',
        'Cb PM','Sd PM','Al CFP PM'];

    public $situacoes = ['Matriculado(a)','Desistente','Excluído(a)','Aprovado(a)'];
    
    //Variáveis do arquivo da lista de alunos
    public $openModalListaAlunos = false;

    //Variáveis para operações com alunos
    public $openModalAluno = false;
    public $isEditAluno = false;
    public $idAluno;
    public $graduacaoAluno;
    public $nomeAluno;
    public $matriculaAluno;
    public $situacao;

    //Variáveis para operações com Coordenador
    public $openModalCoordenador = false;
    public $isEditCoordenador = false;
    public $graduacaoCoordenador;
    public $nomeCoordenador;
    public $matriculaCoordenador;
    public $dataDesignacao;
    public $parecerTecnico;

    //Variáveis para operações com Instrutor
    public $openModalInstrutor = false;
    public $isEditInstrutor = false;
    public $idInstrutor;
    public $graduacaoInstrutor;
    public $nomeInstrutor;
    public $matriculaInstrutor;
    public $dataDesignacaoInstrutor;
    public $parecerTecnicoInstrutor;
    public $dataSubstituicaoInstrutor;
    public $disciplinaInstrutor;
    public $tipoInstrutor;

    //Variávies para operações com Horário
    public $openModalHorario = false;
    public $isEditHorario = false;
    public $idHorario;
    public $horaInicio;
    public $horaFim;

    // Variáveis para operações com Aula
    public $openModalAula = false;
    public $isEditAula = false;
    public $idAula;
    public $dataAula;
    public $horarioId;
    public $disciplinaId;

    public function mount(Turma $turma)
    {
        $this->turma = $turma;
    }

    public function render()
    {
        return view('livewire.turma-detail')->layout('layouts.app');
    }

    public function inserirCoordenador()
    {
        $this->isEditCoordenador = false;
        $this->openModalCoordenador = true;
    }

    public function alterarCoordenador()
    {
        $this->isEditCoordenador = true;
        $this->openModalCoordenador = true;
    }

    public function saveCoordenador()
    {
         $this->validate([
            'graduacaoCoordenador' => ['required','string',Rule::in($this->graduacoes)],
            'nomeCoordenador' => ['required','string'],
            'matriculaCoordenador' => ['required','integer'],
            'dataDesignacao' => ['required','date'],
        ],[
            'matricula.integer'=> "Só pode haver números na matrícula"
        ]);

        $pessoa = Pessoa::where('matricula', $this->matriculaCoordenador)->first();

        if(!$pessoa){
            $pessoa = Pessoa::create([
                'nome' => $this->nomeCoordenador,
                'matricula' => $this->matriculaCoordenador,
            ]);
        }
        Coordenador::create([
            'graduacao' => $this->graduacaoCoordenador,
            'pessoa_id' => $pessoa->id,
            'turma_id' => $this->turma->id,
            'parecer_tecnico' => $this->parecerTecnico,
            'data_designacao' => $this->dataDesignacao
        ]);
        session()->flash('message','Coordenador Cadastrado com sucesso!');
        $this->openModalCoordenador = false;
        $this->isEditCoordenador = false;
        $this->resetFieldsCoordenador();
    }

    #[On('carregarTurma')]
    public function carregarTurma($dados = [])
    {
        if (empty($dados) || !is_array($dados)) {
            session()->flash('message', 'Nenhum dado foi recebido do arquivo.');
            return;
        }

        $contador = 0;
        foreach ($dados as $linha) {
            if (!isset($linha['matricula'], $linha['nome'], $linha['graduacao'])) {
                continue;
            }

            $matricula = preg_replace("/[^0-9]/", "", $linha['matricula']);

            // Pula linhas sem matrícula válida
            if ($matricula === '') {
                continue;
            }

            $pessoa = Pessoa::firstOrCreate(
                ['matricula' => $matricula],
                ['nome' => $linha['nome']]
            );

            Aluno::firstOrCreate(
                [
                    'pessoa_id' => $pessoa->id,
                    'turma_id' => $this->turma->id,
                ],
                [
                    'graduacao' => $linha['graduacao'],
                    'situacao' => "Matriculado(a)",
                ]
            );

            $contador++;
        }

        session()->flash('message', "Arquivo carregado com êxito: {$contador} aluno(s) cadastrado(s).");
        $this->openModalListaAlunos = false;
    }

    public function adicionarAluno()
    {
        $this->isEditAluno = false;
        $this->openModalAluno = true;
    }

    public function editarAluno($id)
    {
        $aluno = Aluno::findOrFail($id);
        $this->idAluno = $aluno->id;
        $this->graduacaoAluno = $aluno->graduacao;
        $this->nomeAluno = $aluno->pessoa->nome;
        $this->matriculaAluno = $aluno->pessoa->matricula;
        $this->situacao = $aluno->situacao;

        $this->isEditAluno = true;
        $this->openModalAluno = true;
    }

    public function apagarAluno($id)
    {
        $aluno = Aluno::findOrFail($id);
        $aluno->delete();
        session()->flash('message', 'Aluno Apagado');
    }

    public function carregarLista()
    {
        $this->openModalListaAlunos = true;
    }

    public function saveAluno()
    {
        $this->validate([
            'graduacaoAluno' => ['required','string'],
            'nomeAluno' => ['required','string'],
            'matriculaAluno' => ['required','integer']
        ],[
            'matricula.integer'=> "Só pode haver números na matrícula"
        ]);

        $pessoa = Pessoa::where('matricula', $this->matriculaAluno)->first();

        if(!$pessoa){
            $pessoa = Pessoa::create([
                'nome' => $this->nomeAluno,
                'matricula' => $this->matriculaAluno,
            ]);
        }
        Aluno::create([
            'graduacao' => $this->graduacaoAluno,
            'pessoa_id' => $pessoa->id,
            'turma_id' => $this->turma->id,
            'situacao' => "Matriculado(a)",
        ]);
        session()->flash('message','Aluno Cadastrado com sucesso!');
        $this->openModalAluno = false;
        $this->isEditAluno = false;
        $this->resetFieldsAluno();
    }

    public function updateAluno()
    {
       $this->validate([
            'graduacaoAluno' => ['required','string'],
            'nomeAluno' => ['required','string'],
            'situacao' => ['required','string',Rule::in($this->situacoes)],
            'matriculaAluno' => ['required','integer']
        ],[
            'matriculaAluno.integer'=> "Só pode haver números na matrícula"
        ]);

        $aluno = Aluno::findOrFail($this->idAluno);
        $aluno->update([
            'situacao' => $this->situacao,
            'graduacao' => $this->graduacaoAluno,
        ]);
        $pessoa = Pessoa::findOrFail($aluno->pessoa->id);
        $pessoa->update([
            'nome' => $this->nomeAluno,
            'matricula' => $this->matriculaAluno
        ]);

        session()->flash('message','Aluno Atualizado');

        $this->openModalAluno = false;
        $this->isEditAluno = false;
        $this->resetFieldsAluno();
    }

    public function adicionarInstrutor()
    {
        $this->isEditInstrutor = false;
        $this->openModalInstrutor = true;
    }

    public function editarInstrutor($id)
    {
        $instrutor = Instrutor::findOrFail($id);
        $this->graduacaoInstrutor = $instrutor->posto_graduacao;
        $this->tipoInstrutor = $instrutor->tipo_instrutor;
        $this->parecerTecnicoInstrutor = $instrutor->parecer_tecnico;
        $this->dataDesignacaoInstrutor = $instrutor->designacao;
        $this->nomeInstrutor = $instrutor->pessoa->nome;
        $this->matriculaInstrutor = $instrutor->pessoa->matricula;
        $this->dataSubstituicaoInstrutor = $instrutor->substituicao;
        $this->disciplinaInstrutor = $instrutor->disciplina->id;
        $this->idInstrutor = $instrutor->id;
        
        $this->isEditInstrutor = true;
        $this->openModalInstrutor = true;
    }

    public function saveInstrutor()
    {
         $this->validate([
            'graduacaoInstrutor' => ['required','string'],
            'nomeInstrutor' => ['required','string'],
            'matriculaInstrutor' => ['required','integer'],
            'dataDesignacaoInstrutor' => ['required','date'],
            'disciplinaInstrutor' => ['required'],
            'tipoInstrutor' => ['required']
        ],[
            'matricula.integer'=> "Só pode haver números na matrícula"
        ]);

        $pessoa = Pessoa::where('matricula', $this->matriculaInstrutor)->first();

        if(!$pessoa){
            $pessoa = Pessoa::create([
                'nome' => $this->nomeInstrutor,
                'matricula' => $this->matriculaInstrutor,
            ]);
        }
        Instrutor::create([
            'posto_graduacao' => $this->graduacaoInstrutor,
            'pessoa_id' => $pessoa->id,
            'turma_id' => $this->turma->id,
            'parecer_tecnico' => $this->parecerTecnicoInstrutor,
            'designacao' => $this->dataDesignacaoInstrutor,
            'disciplina_id' => $this->disciplinaInstrutor,
            'tipo_instrutor' => $this->tipoInstrutor
        ]);
        session()->flash('message','Coordenador Cadastrado com sucesso!');
        $this->openModalInstrutor = false;
        $this->isEditInstrutor = false;
        $this->resetFieldsInstrutor();
    }

    public function updateInstrutor()
    {
        $this->validate([
            'graduacaoInstrutor' => ['required','string'],
            'nomeInstrutor' => ['required','string'],
            'matriculaInstrutor' => ['required','integer'],
            'dataDesignacaoInstrutor' => ['required','date'],
            'dataSubstituicaoInstrutor' => ['required','date'],
            'disciplinaInstrutor' => ['required'],
            'tipoInstrutor' => ['required']
        ],[
            'matricula.integer'=> "Só pode haver números na matrícula"
        ]);

        $pessoa = Pessoa::where('matricula', $this->matriculaInstrutor)->first();

        if(!$pessoa){
            $pessoa = Pessoa::create([
                'nome' => $this->nomeInstrutor,
                'matricula' => $this->matriculaInstrutor,
            ]);
        }
        $instrutor = findOfFail($this->idInstrutor);
        $instrutor::update([
            'posto_graduacao' => $this->graduacaoInstrutor,
            'pessoa_id' => $pessoa->id,
            'turma_id' => $this->turma->id,
            'parecer_tecnico' => $this->parecerTecnicoInstrutor,
            'designacao' => $this->dataDesignacaoInstrutor,
            'substituicao' => $this->dataSubstituicaoInstrutor,
            'disciplina_id' => $this->disciplinaInstrutor,
            'tipo_instrutor' => $this->tipoInstrutor
        ]);
        session()->flash('message','Coordenador Cadastrado com sucesso!');
        $this->openModalInstrutor = false;
        $this->isEditInstrutor = false;
        $this->resetFieldsInstrutor();
    }

    public function apagarInstrutor($id)
    {
        $instrutor = Instrutor::findOrFail($id);
        $instrutor->delete();
        session()->flash('message', 'Instrutor Apagado');
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
            'turma_id' => $this->turmaId,
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

    public function adicionarAula()
    {
        $this->isEditAula = false;
        $this->openModalAula = true;
    }

    public function editarAula($id)
    {
        $aula = Aula::findOrFail($id);
        $this->dataAula = $aula->data_aula;
        $this->horarioId = $aula->horario_id;
        $this->disciplinaId = $aula->disciplina_id;
        $this->idAula = $aula->id;

        $this->isEditAula = true;
        $this->openModalAula = true;
    }

    public function saveAula()
    {
        $this->validate([
            'dataAula' => ['required','date'],
            'horarioId' => ['required','integer'],
            'disciplinaId' => ['required','integer'],
        ]);

        Aula::create([
            'data_aula' => $this->dataAula,
            'horario_id' => $this->horarioId,
            'disciplina_id' => $this->disciplinaId,
        ]);
        session()->flash('message','Aula Cadastrada com sucesso!');
        $this->openModalAula = false;
        $this->isEditAula = false;
        $this->resetFieldsAula();
    }

    public function updateAula()
    {
        $this->validate([
            'dataAula' => ['required','date'],
            'horarioId' => ['required','integer'],
            'disciplinaId' => ['required','integer'],
        ]);

        $aula = Aula::findOrFail($this->idAula);
        $aula->update([
            'data_aula' => $this->dataAula,
            'horario_id' => $this->horarioId,
            'disciplina_id' => $this->disciplinaId,
        ]);
        session()->flash('message','Aula Atualizada com sucesso!');
        $this->openModalAula = false;
        $this->isEditAula = false;
        $this->resetFieldsAula();
    }

    public function deleteAula($id)
    {
        $aula = Aula::findOrFail($id);
        $aula->delete();
        session()->flash('message', 'Aula Apagada');
    }

    public function resetFieldsAula()
    {
        $this->reset([
            'dataAula',
            'horarioId',
            'disciplinaId'
        ]);
    }

    public function resetFieldsHorario()
    {
        $this->reset([
            'horaInicio',
            'horaFim'
        ]);
    }

    public function resetFieldsAluno()
    {
        $this->reset([
            'graduacaoAluno',
            'situacao',
            'nomeAluno',
            'matriculaAluno'
        ]);
    }
    
    public function resetFieldsCoordenador()
    {
        $this->reset([
            'graduacaoCoordenador',
            'nomeCoordenador',
            'matriculaCoordenador',
            'parecerTecnico',
            'dataDesignacao'
        ]);
    }

    public function resetFieldsInstrutor()
    {
        $this->reset([
            'graduacaoInstrutor',
            'nomeInstrutor',
            'matriculaInstrutor',
            'dataDesignacaoInstrutor',
            'parecerTecnicoInstrutor',
            'dataSubstituicaoInstrutor',
            'disciplinaInstrutor',
            'tipoInstrutor'
        ]);
    }
}
