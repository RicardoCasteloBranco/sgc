<div class="p-6">
    <div class="w-full">
        
        <h3 class="text-2xl font-bold mb-4">Detalhes do Projeto</h3>
        <p><strong>Centro de Ensino:</strong> {{ $turma->projeto->centroEnsino->nome }}</p>
        <p><strong>Projeto:</strong> {{ $turma->projeto->numeroProjeto() }}</p>
        <p><strong>Turma:</strong> {{ $turma->numeroTurma() }}</p>
    </div>
</div>
