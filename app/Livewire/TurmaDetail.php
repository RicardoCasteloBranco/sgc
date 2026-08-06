<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Turma;
use App\Models\Pessoa;
use App\Models\Aluno;
use App\Models\Coordenador;
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
    public $openModalDeletaAluno = false;
    public $isEditAluno = false;
    public $idAluno;
    public $graduacaoAluno;
    public $nomeAluno;
    public $matriculaAluno;
    public $situacao;
    public $nomeDel;
    public $idDel;

    //Variáveis para operações com Coordenador
    public $openModalCoordenador = false;
    public $isEditCoordenador = false;
    public $graduacaoCoordenador;
    public $nomeCoordenador;
    public $matriculaCoordenador;
    public $dataDesignacao;
    public $parecerTecnico;

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
        $this->idAluno = $id;
        $aluno = Aluno::findOrFail($id);
        $this->idDel = $id;
        $this->nomeDel = $aluno->pessoa->nome;
        $this->openModalDeletaAluno = true;
    }

    public function carregarLista()
    {
        $this->openModalListaAlunos = true;
    }

    public function saveAluno()
    {
        $this->validate([
            'graduacaoAluno' => ['required','string',Rule::in($this->graduacoes)],
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
            'graduacaoAluno' => ['required','string',Rule::in($this->graduacoes)],
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

    public function deleteAluno()
    {
        $aluno = Aluno::findOrFail($this->idDel);
        $aluno->delete();
        session()->flash('message', 'Aluno Apagado');
        $this->openModalDeletaAluno = false;
        $this->reset(['nomeDel']);
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

}
