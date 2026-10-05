<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Turma;
use App\Models\Pessoa;
use App\Models\Aluno;
use App\Models\Coordenador;
use App\Models\Instrutor;
use App\Models\Disciplina;
use App\Models\Aula;
use App\Models\PerfilUsuario;
use App\Models\User;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Livewire\Attributes\On;

class TurmaDetail extends Component
{
    public $turma;
    public $alunos;
    public $turmaId;
    public $abaAtiva;
    public $graduacoes = ['Cel PM','Ten Cel PM', 'Maj PM','Cap PM','1º Ten PM','2º Ten PM',
        'Asp PM','Cad PM','Al CHO PM','Al CFO PM','Sub Ten PM','1º Sgt PM','2º Sgt PM','3º Sgt PM','Al CFS PM',
        'Cb PM','Sd PM','Al CFP PM'];
    public $usuarios;

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


    // Variáveis para operações com Aula
    public $openModalAula = false;
    public $isEditAula = false;
    public $idAula;
    public $dataAula;
    public $horarioAula;
    public $disciplinaAula;
    public $horarios;
    public $disciplinas;
    public $aulasPorDataHorario;
    public $datasAulas;
    public $aulas;


    public function mount(Turma $turma)
    {
        $this->turma = $turma;
    }

    public function render()
    {
        $this->horarios = $this->turma->horarios()
            ->orderBy('hora_inicio')
            ->get();

        $this->disciplinas = $this->turma->projeto->disciplinas()->get();

        $this->usuarios = User::all();

        $this->aulas = Aula::with('disciplina')
            ->whereIn('horario_id', $this->horarios->pluck('id'))
            ->orderBy('data_aula')
            ->get();

        // Datas únicas das aulas, em ordem cronológica
        $this->datasAulas = $this->aulas
            ->sortBy('data_aula')
            ->pluck('data_aula')
            ->unique()
            ->values();

        // Organiza:
        // data -> horario_id -> aula
        $this->aulasPorDataHorario = $this->aulas
            ->groupBy(function ($aula) {
                return $aula->data_aula;
            })
            ->map(function ($aulasDoDia) {
                return $aulasDoDia->keyBy('horario_id');
            });

        return view('livewire.turma-detail')
            ->layout('layouts.app');
    }

    public function selecionarAba($aba)
    {
        $this->abaAtiva = $aba;
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

    public function updatedMatriculaCoordenador()
    {
        $usuario = User::where('matricula', $this->matriculaCoordenador)->first();
        
        $this->nomeCoordenador = $usuario ? $usuario->name : '';
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
        $user = User::where('matricula', $this->matriculaCoordenador)->first();

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
            'tipoInstrutor' => ['required'],
            'parecerTecnicoInstrutor' => ['required','string']
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
        session()->flash('message','Instrutor Cadastrado com sucesso!');
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
            'disciplinaInstrutor' => ['required'],
            'tipoInstrutor' => ['required'],
            'parecerTecnicoInstrutor' => ['required','string']
        ],[
            'matricula.integer'=> "Só pode haver números na matrícula"
        ]);

        $pessoa = Pessoa::where('matricula', $this->matriculaInstrutor)->first();

        if(!$pessoa){
            $pessoa = Pessoa::create([
                'nome' => $this->nomeInstrutor,
                'matricula' => $this->matriculaInstrutor,
            ]);
        }else{
            $pessoa->update([
                'nome' => $this->nomeInstrutor,
                'matricula' => $this->matriculaInstrutor
            ]);
        }
        $instrutor = Instrutor::findOrFail($this->idInstrutor);
        $instrutor->update([
            'posto_graduacao' => $this->graduacaoInstrutor,
            'pessoa_id' => $pessoa->id,
            'turma_id' => $this->turma->id,
            'parecer_tecnico' => $this->parecerTecnicoInstrutor,
            'designacao' => $this->dataDesignacaoInstrutor,
            'substituicao' => $this->dataSubstituicaoInstrutor,
            'disciplina_id' => $this->disciplinaInstrutor,
            'tipo_instrutor' => $this->tipoInstrutor
        ]);
        session()->flash('message','Instrutor Atualizado com sucesso!');
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


    public function adicionarAula()
    {
        $this->isEditAula = false;
        $this->openModalAula = true;
    }

    public function editarAula($id)
    {
        $aula = Aula::findOrFail($id);
        $this->dataAula = $aula->data_aula;
        $this->horarioAula = $aula->horario_id;
        $this->disciplinaAula = $aula->disciplina_id;
        $this->idAula = $aula->id;

        $this->isEditAula = true;
        $this->openModalAula = true;
    }

    public function saveAula()
    {
        $this->validate([
            'dataAula' => ['required','date'],
            'horarioAula' => ['required','integer'],
            'disciplinaAula' => ['required','integer'],
        ]);
        try{
            Aula::create([
                'data_aula' => $this->dataAula,
                'horario_id' => $this->horarioAula,
                'disciplina_id' => $this->disciplinaAula,
            ]);
            session()->flash('message','Aula Cadastrada com sucesso!');
            $this->openModalAula = false;
            $this->isEditAula = false;
            $this->resetFieldsAula();
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() === '23000') { // Código de erro para violação de chave única
                $this->addError('errorAula', 'Já existe uma aula cadastrada para esta data e horário. Por favor, escolha outro horário ou data.');
            } else {
                $this->addError('errorAula', 'Ocorreu um erro ao cadastrar a aula. Por favor, tente novamente.');
            }
        }
    }

    public function updateAula()
    {
        $this->validate([
            'dataAula' => ['required','date'],
            'horarioAula' => ['required','integer'],
            'disciplinaAula' => ['required','integer'],
        ]);

        $aula = Aula::findOrFail($this->idAula);
        $aula->update([
            'data_aula' => $this->dataAula,
            'horario_id' => $this->horarioAula,
            'disciplina_id' => $this->disciplinaAula,
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
            'horarioAula',
            'disciplinaAula'
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
