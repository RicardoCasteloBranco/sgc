<div class="p-6">
    <div class="w-full">
        <div class="flex flex-col lg:flex-row gap-6 items-start">
            <div class="w-full lg:w-1/2 bg-gray-200 text-black p-5 rounded-lg h-[600px]">
                <h3 class="text-2xl font-bold mb-4">Detalhes do Projeto</h3>
                <p><strong>Centro de Ensino:</strong> {{ $turma->projeto->centroEnsino->nome }}</p>
                <p><strong>Projeto:</strong> {{ $turma->projeto->numeroProjeto() }}</p>
                <p><strong>Turma:</strong> {{ $turma->numeroTurma() }}</p>
            </div>
            <div class="w-full lg:w-1/2 bg-white p-5 rounded-lg shadow h-[600px] flex flex-col">
            </div>
        </div>
    </div>
</div>
