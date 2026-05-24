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
        <x-table>
            <x-slot name="theaders">
                <th>Turma</th>
                <th>Data de Início</th>
                <th>Data de Término</th>
                <th>Matriculados</th>
                <th>Concluintes</th>
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
</div>
