<div>
    <h1 class="text-2xl font-bold mb-4">Detalhes do Projeto</h1>
    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-4">{{ $projeto->curso->nome ?? 'Curso Não Disponível' }}</h2>
        <p><strong>Público Alvo:</strong> {{ $projeto->curso->publico_alvo ?? 'Não Disponível' }}</p>
        <p><strong>Objetivo Geral:</strong> {{ $projeto->curso->objetivo_geral ?? 'Não Disponível' }}</p>
        <p class="max-w-full overflow-x-auto whitespace-pre-wrap break-all"><strong>Objetivos Específicos:</strong> {{ $projeto->curso->objetivos_especificos ?? 'Não Disponível' }}</p>
        <p><strong>Ano:</strong> {{ $projeto->ano ?? 'Não Disponível' }}</p>
</div>
