<div class="p-6">
    <div>
        <h3 class="text-2xl font-bold mb-4">Detalhes do Projeto</h3>
        <p><strong>Nome:</strong> {{ $projeto->curso->nome }}</p>
        <p><strong>Centro de Ensino:</strong> {{ $projeto->centroEnsino->nome }}</p>
        <p><strong>Quantidade de Turmas Previstas:</strong> {{ $projeto->quantidade_turmas }}</p>
        <p><strong>Custo com Pessoal:</strong> R$ {{ number_format($projeto->custo_pessoal, 2, ',', '.') }}</p>
        <p><strong>Custo com Material:</strong> R$ {{ number_format($projeto->custo_material, 2, ',', '.') }}</p>
        <p><strong>Custo com Serviços:</strong> R$ {{ number_format($projeto->custo_servico, 2, ',', '.') }}</p>

    </div>
    <!-- Tabela de Turmas -->
    <div>
        <x-section-title title="Turmas" description="Lista de turmas do projeto"/>
        <x-button class="mb-4" wire:click="createTurma">
            Nova Turma
        </x-button>
        <x-table>
            <x-slot name="theaders">
                <th>Data de Início</th>
                <th>Data de Fim</th>
                <th>Unidade</th>
                <th>Quantidade de Matriculados</th>
                <th>Quantidade de Concluintes</th>
                <th>Ações</th>
            </x-slot>
            <x-slot name="tbody">
                @foreach($projeto->turmas as $turma)
                    <tr>
                        <td>{{ date('d/m/Y', strtotime($turma->data_inicio)) }}</td>
                        <td>{{ date('d/m/Y', strtotime($turma->data_fim)) }}</td>
                        <td>{{ $turma->unidade->nome }}</td>
                        <td>{{ $turma->quantidade_matriculados }}</td>
                        <td>{{ $turma->quantidade_concluintes }}</td>
                        <td>
                            <x-secondary-button wire:click="editTurma({{ $turma->id }})">
                                Editar
                            </x-secondary-button>
                        </td>
                    </tr>
                @endforeach
            </x-slot>
        </x-table>
    </div>
    <!-- Modal de Cadastro/Edicação de Turma -->
     <x-modal wire:model="openModalTurma">
        <x-form-section submit=" {{ $isEditTurma ? 'updateTurma' : 'saveTurma' }}">
            <x-slot name="title">
                {{ $isEditTurma ? 'Editar Turma' : 'Nova Turma' }}
            </x-slot>
            <x-slot name="description">
                {{ $isEditTurma ? 'Edite os detalhes da turma.' : 'Preencha os detalhes da nova turma.' }}
            </x-slot>
            <x-slot name="form">
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="dataInicio" value="Data de Início" />
                    <x-input id="dataInicio" type="date" class="mt-1 block w-full" wire:model.defer="dataInicio" />
                    <x-input-error for="dataInicio" class="mt-2" />
                </div>
                <!-- Adicione os outros campos do formulário aqui -->
            </x-slot>
            <x-slot name="actions">
                <x-secondary-button wire:click="$set('openModalTurma', false)">
                    Cancelar
                </x-secondary-button>
                <x-button class="ml-3" type="submit">
                    {{ $isEditTurma ? 'Atualizar' : 'Salvar' }}
                </x-button>
            </x-slot>
        </x-form-section>
     </x-modal>
</div>
