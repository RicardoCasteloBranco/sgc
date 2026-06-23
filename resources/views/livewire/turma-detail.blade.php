<div class="p-6">
    <div class="container mx-auto">
        <div class="w-full ml-4">
            <!-- Detalhes do Projeto -->
            <h3 class="text-2xl font-bold mb-4 uppercase">Gerenciar Turma</h3>
            <p><strong>Centro de Ensino:</strong> {{ $turma->projeto->centroEnsino->nome }}</p>
            <p><strong>Projeto:</strong> {{ $turma->projeto->numeroProjeto() }}</p>
            <p><strong>Turma:</strong> {{ $turma->numeroTurma() }}</p>
            <p><strong>Coordenador:</strong>{{ $turma->coordenador }}
            <!-- Fim dos detalhes do Projeto -->
        </div>
        <div>
            <!-- Botões de Ação -->
            <x-button wire:click="{{ empty($turma->coordenador)? 'inserirCoordenador()' : 'alterarCoordenador()' }}"
            class="m-4">{{ empty($turma->coordenador) ? 'Inserir Coordenador' : 'Alterar Coordenador' }}</x-button>
            <x-button wire:click="carregarLista()" class="m-4">Carrregar Turma</x-button>
            <x-button wire:click="adicionarAluno()" class="m-4">Adicionar Aluno</x-button>
            <!-- Fim dos botões de ações --->
        </div>
    </div>
    <div>
        <!-- Tabela com os alunos -->
        <x-table>
            <x-slot name="theaders">
                <th class="p-3">Graduação</th>
                <th class="p-3">Nome Completo</th>
                <th class="p-3">Matricula</th>
                <th class="p-3">Situação</th>
                <th class="p-3">Ações</th>
            </x-slot>
            <x-slot name="tbody">
                @foreach($turma->alunos as $aluno)
                <tr class="{{$loop->even ? 'bg-blue-100' : 'bg-white' }}">
                    <td>{{ $aluno->graduacao }}</td>
                    <td>{{ $aluno->pessoa->nome }}</td>
                    <td>{{ $aluno->pessoa->matricula }}
                    <td>{{ $aluno->situacao }}</td>
                    <td>
                        <button wire:click="editAluno({{ $aluno->id }})" class="text-green-700">
                            Editar
                        </button>
                        <button wire:click="apagaAluno({{ $aluno->id }})" class="text-red-600">
                            Apagar
                        </button>
                    </td>
                </tr>
                @endforeach
            </x-slot>
        </x-table>
        <!-- Fim da tabela com os alunos -->
    </div>
    <!-- Formulário para carregar lista de alunos -->
      @if($openModalListaAlunos)
        <div class="fixed inset-0 z-50 overflow-y-auto">
            
            <!-- Fundo escuro -->
            <div class="fixed inset-0 bg-black opacity-50"></div>

            <!-- Modal -->
            <div class="flex items-center justify-center min-h-screen p-4">
                
                <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl relative z-50">
                    
                    <!-- Cabeçalho -->
                    <div class="flex items-center justify-between border-b px-6 py-4">
                        <h2 class="text-xl font-semibold">
                            Carregar Lista de Alunos
                        </h2>

                        <button type="button" wire:click="$set('openModalListaAlunos', false)"
                            class="text-gray-500 hover:text-gray-700 text-2xl">
                            &times;
                        </button>
                    </div>

                    <!-- Formulário -->
                    <form wire:submit.prevent="carregarTurma" enctype="multipart/form-data">
                        <input type="hidden" name="turma_id" wire:model="{{ $turma->id }}"/>

                        <div class="p-6 space-y-4">

                            <div>
                                <label for="arquivo" class="block text-sm font-medium text-gray-700">
                                    Arquivo CSV
                                </label>

                                <input id="arquivo" type="file" wire:model="arquivo"
                                    accept=".csv" class="mt-1 block w-full border border-gray-300 rounded-md p-2" >

                                <div wire:loading wire:target="arquivo" class="text-blue-500 text-sm mt-2">
                                    Enviando arquivo...
                                </div>

                                @error('arquivo')
                                    <span class="text-red-500 text-sm">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                        </div>

                        <!-- Rodapé -->
                        <div class="flex justify-end gap-3 border-t px-6 py-4 bg-gray-50">
                            <x-secondary-button wire:click="$set('openModalListaAlunos', false)">
                                Cancelar
                            </x-secondary-button>
                            <x-button type="submit" wire:loading.attr="disabled" wire:target="arquivo">
                                Salvar
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
    <!-- Fim do formulário para carregar lista de alunos -->
</div>
