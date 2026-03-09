<div>
    <h1 class="text-2xl font-bold mb-4">Detalhes do Projeto</h1>
    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-4">{{ $projeto->curso->nome ?? 'Curso Não Disponível' }}</h2>
        <p><strong>Público Alvo:</strong> {{ $projeto->curso->publico_alvo ?? 'Não Disponível' }}</p>
        <p><strong>Objetivo Geral:</strong> {{ $projeto->curso->objetivo_geral ?? 'Não Disponível' }}</p>
        <p class="max-w-full overflow-x-auto whitespace-pre-wrap break-all"><strong>Objetivos Específicos:</strong> {{ $projeto->curso->objetivos_especificos ?? 'Não Disponível' }}</p>
        <p><strong>Ano:</strong> {{ $projeto->ano ?? 'Não Disponível' }}</p>
    </div>
    <div class="mt-4">
        <h3 class="text-lg font-semibold mb-2">Disciplinas Associadas</h3>
        <x-table>
            <x-slot name="theaders">
                <x-table.heading>Disciplina</x-table.heading>
                <x-table.heading>Carga Horária</x-table.heading>
                <x-table.heading>Ações</x-table.heading>
            </x-slot>
            <x-slot name="tbody">
            </x-slot>
        </x-table>
    </div>
    <div class="mt-4">
        <h3 class="text-lg font-semibold mb-2">Turmas Associados</h3>
        <x-table>
            <x-slot name="theaders">
                <x-table.heading>Turma</x-table.heading>
                <x-table.heading>Data de Início</x-table.heading>
                <x-table.heading>Alunos</x-table.heading>
                <x-table.heading>Ações</x-table.heading>
            </x-slot>
            <x-slot name="tbody">
            </x-slot>
        </x-table>
</div>
