<div>
    <h1 class="text-2xl font-bold mb-4">Detalhes do Projeto</h1>
    <p>Exibindo detalhes para o Projeto: {{ $projetoId }}</p>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
        <div class="bg-white p-4 rounded shadow">
            <h2 class="text-xl font-semibold mb-2">Informações do Projeto</h2>
            <p><strong>ID:</strong> {{ $projetoId }}</p>
            <!-- Adicione mais detalhes do projeto aqui -->
             <p><strong>Curso:</strong> {{ $projeto->curso->nome }}</p>
             <p><strong>Centro de Ensino:</strong> {{ $projeto->centroEnsino->nome }}</p>
             <p><strong>Data de Aprovação:</strong> {{ date('d/m/Y', strtotime($projeto->data_aprovacao)) }}</p>
             <p><strong>Quantidade de Turmas:</strong> {{ $projeto->quantidade_turmas }}</p>
             <p><strong>Custo Pessoal:</strong> R$ {{ number_format($projeto->custo_pessoal, 2, ',', '.') }}</p>
             <p><strong>Custo Material:</strong> R$ {{ number_format($projeto->custo_material, 2, ',', '.') }}</p>
             <p><strong>Custo Serviços:</strong> R$ {{ number_format($projeto->custo_servicos, 2, ',', '.') }}</p>
        </div>
        <div class="bg-white p-4 rounded shadow">
            <h2 class="text-xl font-semibold mb-2">Parecer Técnico</h2>
        </div>
    </div>
    <!-- Exibe as turmas associadas ao projeto -->
    <div>
        <h2 class="text-xl font-semibold mb-2 mt-4">Turmas</h2>
        <button class="mb-2 px-4 py-2 bg-blue-500 rounded" wire:click="createTurma">Criar Nova Turma</button>
        <x-table>
            <x-slot name="theaders">
                <th>Turma</th>
                <th>Data de Início</th>
                <th>Data de Término</th>
                <th>Matriculados</th>
                <th>Concluintes</th>
                <th>Unidade</th>
                <th>Ações</th>
            </x-slot>
            <x-slot name="tbody">
                @foreach($projeto->turmas as $turma)
                    <tr>
                        <td class="border px-4 py-2">{{ $turma->nome }}</td>
                        <td class="border px-4 py-2">{{ $turma->data_inicio }}</td>
                        <td class="border px-4 py-2">{{ $turma->data_fim }}</td>
                        <td class="border px-4 py-2">{{ $turma->quantidade_matriculados }}</td>
                        <td class="border px-4 py-2">{{ $turma->quantidade_concluintes }}</td>
                        <td class="border px-4 py-2">{{ $turma->unidade->sigla }}</td>
                        <td class="border px-4 py-2">
                            <!-- Adicione ações para cada turma aqui -->
                            <button class="text-blue-500 hover:underline">Ver Detalhes</button>
                        </td>
                    </tr>
                @endforeach
            </x-slot>
        </x-table>
    </div>
    <!-- Fim das turmas associadas ao projeto -->
    <div>
        <h2 class="text-xl font-semibold mb-2 mt-4">Disciplinas</h2>
        <x-table>
            <x-slot name="theaders">
                <th>Sel</th>
                <th>Disciplina</th>
                <th>Abreviação</th>
                <th>Carga Horária</th>
                <th>Ações</th>
            </x-slot>
            <x-slot name="tbody">
                @foreach($projeto->disciplinas as $disciplina)
                    <tr>
                        <td class="border px-4 py-2">
                            <input type="checkbox" name="disciplinas[]" value="{{ $disciplina->id }}">
                        </td>
                        <td class="border px-4 py-2">{{ $disciplina->nome }}</td>
                        <td class="border px-4 py-2">{{ $disciplina->abreviacao }}</td>
                        <td class="border px-4 py-2">{{ $disciplina->carga_horaria }}</td>
                        <td class="border px-4 py-2">
                            <!-- Adicione ações para cada disciplina aqui -->
                            <button>Ver Detalhes</button>
                        </td>
                    </tr>
                @endforeach
            </x-slot>
        </x-table>
    </div>

    <!-- Modal para criar nova turma -->
    <x-modal maxWidth="xl" wire:model="openModalTurma">
        <x-form-section submit="{{ $isEditTurma ? 'updateTurma' : 'saveTurma' }}">
            <x-slot name="title">
                {{ $isEditTurma ? 'Editar Turma' : 'Criar Nova Turma' }}
            </x-slot>
            <x-slot name="description">
                {{ $isEditTurma ? 'Edite os detalhes da turma.' : 'Preencha os detalhes para criar uma nova turma.' }}
            </x-slot>
            <x-slot name="form">
                <div class="mb-4">
                    <label for="nome" class="block text-gray-700">Nome da Turma:</label>
                    <input type="text" id="nome" wire:model="nome" class="w-full border rounded px-3 py-2">
                </div>
                <div class="mb-4">
                    <label for="data_inicio" class="block text-gray-700">Data de Início:</label>
                    <input type="date" id="data_inicio" wire:model="data_inicio" class="w-full border rounded px-3 py-2">
                </div>
                <div class="mb-4">
                    <label for="data_fim" class="block text-gray-700">Data de Término:</label>
                    <input type="date" id="data_fim" wire:model="data_fim" class="w-full border rounded px-3 py-2">
                </div>
                <div class="mb-4">
                    <label for="quantidade_matriculados" class="block text-gray-700">Quantidade de Matriculados:</label>
                    <input type="number" id="quantidade_matriculados" wire:model="quantidade_matriculados" class="w-full border rounded px-3 py-2">
                </div>
                <div class="mb-4">
                    <label for="quantidade_concluintes" class="block text-gray-700">Quantidade de Concluintes:</label>
                    <input type="number" id="quantidade_concluintes" wire:model="quantidade_concluintes" class="w-full border rounded px-3 py-2">
                </div>
                <div class="mb-4">
                    <label for="unidade_id" class="block text-gray-700">Unidade:</label>
                    <select id="unidade_id" wire:model="unidade_id" class="w-full border rounded px-3 py-2">
                        <option value="">Selecione uma unidade</option>
                        @foreach($unidades as $unidade)
                            <option value="{{ $unidade->id }}">{{ $unidade->sigla }}</option>
                        @endforeach
                    </select>
                </div>
            </x-slot>
            <x-slot name="actions">
                <x-button type="submit">
                    {{ $isEditTurma ? 'Atualizar' : 'Criar' }}
                </x-button>
                @if ($isEditTurma)
                    <x-secondary-button type="reset" wire:click="$set('openModalTurma', false)">Cancelar</x-secondary-button>
                @endif
            </x-slot>
        </x-form-section>
    </x-modal>
    <!-- Fim do modal para criação de turmas -->
</div>
