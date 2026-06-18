<div class="p-6">
    <div class="w-full">
        
        <h3 class="text-2xl font-bold mb-4">Gerenciar Turma</h3>
        <p><strong>Centro de Ensino:</strong> {{ $turma->projeto->centroEnsino->nome }}</p>
        <p><strong>Projeto:</strong> {{ $turma->projeto->numeroProjeto() }}</p>
        <p><strong>Turma:</strong> {{ $turma->numeroTurma() }}</p>
        <p><strong>Coordenador:</strong>{{ $turma->coordenador }}
    </div>
    <div>
        <x-button wire:click="{{ empty($turma->coordenador)? 'inserirCoordenador()' : 'alterarCoordenador()' }}"
         class="m-4">{{ empty($turma->coordenador) ? 'Inserir Coordenador' : 'Alterar Coordenador' }}</x-button>
        <x-button wire:click="carregarTurma()" class="m-4">Carrregar Turma</x-button>
        <x-button wire:click="adicionarAluno()" class="m-4">Adicionar Aluno</x-button>
    </div>
    <div>
        <x-table>
            <x-slot name="theaders">
                <th>Graduação</th>
                <th>Nome Completo</th>
                <th>CPF</th>
                <th>Situação</th>
                <th>Ações</th>
            </x-slot>
            <x-slot name="tbody">
                <tr>
                    <td></td>
                </tr>
            </x-slot>
        </x-table>
    </div>
</div>
