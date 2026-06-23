<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Turma;
use App\Models\Pessoa;
use App\Models\Aluno;
use Livewire\WithFileUploads;
use Carbon\Carbon;

class TurmaDetail extends Component
{
    use WithFileUploads;

    public $turma;
    public $alunos;
    
    //Variáveis do arquivo da lista de alunos
    public $openModalListaAlunos = false;
    public $arquivo;

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
            $pessoa = Pessoa::where('matricula', $linha[1])->first();
            if(!$pessoa){
                $pessoa = Pessoa::create([
                    'matricula' => $linha[1],
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
        
    }

    public function carregarLista()
    {
        $this->openModalListaAlunos = true;
    }
}
