<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Turma;
use App\Models\Pessoa;
use App\Models\Aluno;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class TurmaDetail extends Component
{
    use WithFileUploads;

    public $turma;
    public $alunos;
    public $turmaId;
    public $graduacoes = ['Cel PM','Ten Cel PM', 'Maj PM','Cap PM','1º Ten PM','2º Ten PM',
        'Asp PM','Cad PM','Al CHO PM','Al CFO PM','Sub Ten PM','1º Sgt PM','2º Sgt PM','3º Sgt PM','Al CFS PM',
        'Cb PM','Sd PM','Al CFP PM'];

    public $situacoes = ['Matriculado(a)','Desistente','Excluído(a)','Aprovado(a)'];
    
    //Variáveis do arquivo da lista de alunos
    public $openModalListaAlunos = false;
    public $arquivo;

    //Variáveis para operações com alunos
    public $openModalAluno = false;
    public $isEditAluno = false;
    public $idAluno;
    public $graduacao;
    public $nome;
    public $matricula;
    public $situacao;

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

    }

    public function alterarCoordenador()
    {

    }

    public function carregarTurma()
    {
        $this->validate([
            'arquivo' => 'required|file|max:2048|mimes:csv',
        ]);

        $caminho = $this->arquivo->getRealPath();

        $arrayDados = array_map('str_getcsv', file($caminho));
        $cabecalhoArquivo = array_shift($arrayDados);
        foreach($arrayDados as $linha){
            $pessoa = Pessoa::where('matricula', preg_replace("/[^0-9]/","",$linha[1]))->first();
            if(!$pessoa){
                $pessoa = Pessoa::create([
                    'matricula' => preg_replace("/[^0-9]/", "", $linha[1]),
                    'nome' => $linha[2],
                ]);
            }
            Aluno::create([
                'graduacao' => $linha[0],
                'pessoa_id' => $pessoa->id,
                'turma_id' => $this->turma->id,
                'situacao' => "Matriculado(a)"
            ]);
        }
        session()->flash('message','Arquivo carregado com êxito');
        $this->openModalListaAlunos = false;
        $this->reset(['arquivo']);
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
        $this->graduacao = $aluno->graduacao;
        $this->nome = $aluno->pessoa->nome;
        $this->matricula = $aluno->pessoa->matricula;
        $this->situacao = $aluno->situacao;

        $this->isEditAluno = true;
        $this->openModalAluno = true;
    }

    public function carregarLista()
    {
        $this->openModalListaAlunos = true;
    }

    public function saveAluno()
    {
        $this->validate([
            'graduacao' => ['required','string',Rule::in($this->graduacoes)],
            'nome' => ['required','string'],
            'situacao' => ['required','string',Rule::in($this->situacoes)],
            'matricula' => ['required','integer']
        ]);
        $pessoa = Pessoa::where('matricula', preg_replace("/[^0-9]/","",$this->matricula))->first();
        if(!$pessoa){
            $pessoa = Pessoa::create([
                'nome' => $this->nome,
                'matricula' => $this->matricula,
            ]);
        }
        Aluno::create([
            'graduacao' => $this->graduacao,
            'pessoa_id' => $this->pessoa->id,
            'turma_id' => $this->turma->id,
            'situacao' => "Matriculado(a)",
        ]);
        session()->flash('message','Aluno Cadastrado com sucesso!');
        $this->openModalAluno = false;
        $this->isEditAluno = false;
        $this-resetFieldsAluno();
    }

    public function updateAluno()
    {
       $this->validate([
            'graduacao' => ['required','string',Rule::in($this->graduacoes)],
            'nome' => ['required','string'],
            'situacao' => ['required','string',Rule::in($this->situacoes)],
            'matricula' => ['required','integer']
        ]);

        $aluno = Aluno::findOrFail($this->idAluno);
        $aluno->update([
            'situacao' => $this->situacao,
            'graduacao' => $this->graduacao,
        ]);
        $pessoa = Pessoa::findOrFail($aluno->pessoa->id);
        $pessoa->update([
            'nome' => $this->nome,
            'matricula' => $this->matricula
        ]);

        session()->flash('message','Aluno Atualizado');

        $this->openModalAluno = false;
        $this->isEditAluno = false;
        $this->resetFieldsAluno();
    }

    public function resetFieldsAluno()
    {
        $this->reset([
            'graduacao',
            'situacao',
            'nome',
            'matricula'
        ]);
    }

}
