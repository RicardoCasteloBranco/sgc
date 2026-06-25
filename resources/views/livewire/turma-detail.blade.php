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
                        <button wire:click="editarAluno({{ $aluno->id }})" class="text-green-700">
                            Editar
                        </button>
                        <button wire:click="apagarAluno({{ $aluno->id }})" class="text-red-600">
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
                        <input type="hidden" name="turma_id" value="{{ $turma->id }}"/>

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
    <!-- Inicio do formulário para adicionar e editar um aluno -->
     <x-modal wire:model="openModalAluno">
        <x-form-section submit="{{ $isEditAluno ? 'updateAluno' : 'saveAluno' }}">
            <x-slot name="title">
                {{ $isEditAluno ? 'Editar Aluno' : 'Adicionar Aluno' }}
            </x-slot>
            <x-slot name="description">
                {{ $isEditAluno ? 'Edite os dados do Alunos.' : 'Adicione uma aluno à Turma.' }}
            </x-slot>
            <x-slot name="form">
                <x-input type="hidden" id="turmaId" value="{{$turma->id}}" />
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="graduacao" value="Graduação" />
                    <x-select id="graduacao" class="mt-1 block w-full" wire:model.defer="graduacao">
                        <option>Selecione a graduação</option>
                        @foreach($graduacoes as $key => $value)
                        <option value="{{ $value }}">{{ $value }}</option>
                        @endforeach
                    </x-select>
                    <x-input-error for="graduacao" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="nome" value="Nome" />
                    <x-input id="nome" type="text" class="mt-1 block w-full" wire:model.defer="nome" />
                    <x-input-error for="nome" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="matricula" value="Matrícula" />
                    <x-input id="matricula" type="text" class="mt-1 block w-full" wire:model.defer="matricula" />
                    <x-input-error for="matricula" class="mt-2" />
                </div>
                @if($isEditAluno)
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="situacao" value="Situação" />
                    <x-select id="situacao" class="mt-1 block w-full" wire:model.defer="situacao">
                        <option>Selecione a situação</option>
                        @foreach($situacoes as $key => $value)
                        <option value="{{ $value }}">{{ $value }}</option>
                        @endforeach
                    </x-select>
                    <x-input-error for="situacao" class="mt-2" />
                </div>
                @endif
            </x-slot>
            <x-slot name="actions">
                <x-secondary-button wire:click="$set('openModalAluno', false)">
                    Cancelar
                </x-secondary-button>
                <x-button class="ml-3" type="submit">
                    {{ $isEditAluno ? 'Atualizar' : 'Salvar' }}
                </x-button>
            </x-slot>
        </x-form-section>
     </x-modal>
    <!-- Fim do formulário para adicionar e editar um aluno -->
    <!-- Modal para apagar Aluno -->
     <x-dialog-modal wire:model="openModalDeletaAluno">
        <x-slot name="title">Apagar Aluno</x-slot>
        <x-slot name="content">
            <p>Você tem certeza que deseja apagar o aluno?</p>
            <x-input id="nomeDel" wire:model.defer="nomeDel" disabled class="border-none focus:border-none focus:ring-0 shadow-none w-full"/>
        </x-slot>
        <x-slot name="footer">
            <x-button wire:click="deleteAluno">Confirma</x-button>
            <x-secondary-button wire:click="$set('openModalDeletaAluno', false)" class="ml-4">Cancela</x-secondary-button>
        </x-slot>
     </x-dialog-modal>
     <!-- Fim do Modal para apagar material -->
</div>
