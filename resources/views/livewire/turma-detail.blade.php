<div class="p-6">
    <div class="container mx-auto">
        <div class="w-full ml-4">
            <!-- Detalhes do Projeto -->
            <h3 class="text-2xl font-bold mb-4 uppercase">Gerenciar Turma</h3>
            <p><strong>Centro de Ensino:</strong> {{ $turma->projeto->centroEnsino->nome }}</p>
            <p><strong>Projeto:</strong> <a href="{{ route('projeto',['projeto'=>$turma->projeto->id]) }}" >{{ $turma->projeto->numeroProjeto() }}</a></p>
            <p><strong>Turma:</strong> {{ $turma->numeroTurma() }}</p>
            <p><strong>Coordenador: </strong>@if($turma->coordenador){{ $turma->coordenador->graduacao }} {{ $turma->coordenador->pessoa->nome }}@endif
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
        <x-section-title title="Alunos" description=""></x-section-title>
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
                <tr class="{{$loop->even ? 'bg-blue-100' : 'bg-white' }}" wire:key="aluno-{{$aluno->id}}">
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
    <!-- Tabela de Instutores -->
    <div>
        <x-section-title title="Instrutores" description=""></x-section-title>
        <x-table>
            <x-slot name="theaders">
                <th>Posto/Graduação</th>
                <th>Nome</th>
                <th>Disciplina</th>
                <th>Instrutor</th>
                <th>Ações</th>
            </x-slot>
            <x-slot name="tbody">
            </x-slot>
        </x-table>
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
                    <form enctype="multipart/form-data">
                        <input type="hidden" name="turma_id" value="{{ $turma->id }}"/>

                        <div class="p-6 space-y-4">

                            <div>
                                <label for="arquivo" class="block text-sm font-medium text-gray-700">
                                    Arquivo CSV
                                </label>

                                <input id="arquivo" type="file"
                                    accept=".csv" class="mt-1 block w-full border border-gray-300 rounded-md p-2">

                                <p class="text-sm text-gray-500 mt-2">
                                    Selecione o arquivo CSV; os dados serão lidos no navegador e enviados ao servidor.
                                </p>
                            </div>

                        </div>

                        <!-- Rodapé -->
                        <div class="flex justify-end gap-3 border-t px-6 py-4 bg-gray-50">
                            <x-secondary-button wire:click="$set('openModalListaAlunos', false)">
                                Cancelar
                            </x-secondary-button>
                            <x-button type="button" wire:click="$set('openModalListaAlunos', false)">
                                Fechar
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
                    <x-label for="graduacaoAluno" value="Graduação" />
                    <x-select id="graduacaoAluno" class="mt-1 block w-full" wire:model.defer="graduacaoAluno">
                        <option>Selecione a graduação</option>
                        @foreach($graduacoes as $key => $value)
                        <option value="{{ $value }}">{{ $value }}</option>
                        @endforeach
                    </x-select>
                    <x-input-error for="graduacaoAluno" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="nomeAluno" value="Nome" />
                    <x-input id="nomeAluno" type="text" class="mt-1 block w-full" wire:model.defer="nomeAluno" />
                    <x-input-error for="nomeAluno" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="matriculaAluno" value="Matrícula" />
                    <x-input id="matriculaAluno" type="text" class="mt-1 block w-full" wire:model.defer="matriculaAluno" />
                    <x-input-error for="matriculaAluno" class="mt-2" />
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
    <!-- Inicio do formulário para adicionar e editar o Coordenador -->
     <x-modal wire:model="openModalCoordenador">
        <x-form-section submit="saveCoordenador">
            <x-slot name="title">
                {{ $isEditCoordenador ? 'Alterar Coordenador' : 'Adicionar Coordenador' }}
            </x-slot>
            <x-slot name="description">
                {{ $isEditCoordenador ? 'Alterar o Coordenador da Turma.' : 'Adicione o Coordenador da Turma.' }}
            </x-slot>
            <x-slot name="form">
                <x-input type="hidden" id="turmaId" value="{{$turma->id}}" />
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="graduacaoCoordenador" value="Graduação" />
                    <x-select id="graduacaoCoordenador" class="mt-1 block w-full" wire:model.defer="graduacaoCoordenador">
                        <option>Selecione a graduação</option>
                        @foreach($graduacoes as $key => $value)
                        <option value="{{ $value }}">{{ $value }}</option>
                        @endforeach
                    </x-select>
                    <x-input-error for="graduacaoCoordenador" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="nomeCoordenador" value="Nome" />
                    <x-input id="nomeCoordenador" type="text" class="mt-1 block w-full" wire:model.defer="nomeCoordenador" />
                    <x-input-error for="nomeCoodenador" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="matriculaCoordenador" value="Matrícula" />
                    <x-input id="matriculaCoordenador" type="text" class="mt-1 block w-full" wire:model.defer="matriculaCoordenador" />
                    <x-input-error for="matriculaCoordenador" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="dataDesignacao" value="Data de Designação" />
                    <x-input id="dataDesignacao" type="date" class="mt-1 block w-full" wire:model.defer="dataDesignacao" />
                    <x-input-error for="dataDesignacao" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="pareceTecnico" value="Parecer Técnico" />
                    <x-input id="parecerTecnico" type="text" class="mt-1 block w-full" wire:model.defer="parecerTecnico" />
                    <x-input-error for="parecerTecnico" class="mt-2" />
                </div>
            </x-slot>
            <x-slot name="actions">
                <x-secondary-button wire:click="$set('openModalCoordenador', false)">
                    Cancelar
                </x-secondary-button>
                <x-button class="ml-3" type="submit">
                    {{ $isEditCoordenador ? 'Atualizar' : 'Salvar' }}
                </x-button>
            </x-slot>
        </x-form-section>
     </x-modal>
    <!-- Fim do formulário para adicionar e editar um Coordenador -->
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
<!-- Script para carregar um arquivo com os alunos da turma -->
<script>
if (!window.__sgcHandleArquivoChange) {
    window.__sgcHandleArquivoChange = function (e) {

        const input = e.target;

        if (!input || input.id !== 'arquivo') return;

        const file = input.files[0];

        if (!file) return;

        const reader = new FileReader();

        reader.onload = function (event) {

            // Remove BOM se existir
            const texto = String(event.target.result).replace(/^\uFEFF/, '');

            const linhas = texto.trim().split(/\r?\n/).filter(l => l.trim() !== '');

            if (linhas.length < 2) {
                alert('O arquivo precisa ter um cabeçalho e pelo menos uma linha de dados.');
                return;
            }

            // Detecta o delimitador (vírgula ou ponto e vírgula)
            const primeiraLinha = linhas[0];
            const contagemVirgula = (primeiraLinha.match(/,/g) || []).length;
            const contagemPontoVirgula = (primeiraLinha.match(/;/g) || []).length;
            const delimitador = contagemPontoVirgula > contagemVirgula ? ';' : ',';

            const normalizar = s => String(s).toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '');

            const colunas = primeiraLinha.split(delimitador).map(c => c.trim());

            // Descobre os índices das colunas esperadas no cabeçalho (apenas como dica)
            let idxMatricula, idxNome, idxGraduacao;

            colunas.forEach((coluna, index) => {
                const n = normalizar(coluna);
                if (n.includes('matric')) idxMatricula = index;
                else if (n === 'nome' || n.includes('nome')) idxNome = index;
                else if (n.includes('graduac')) idxGraduacao = index;
            });

            let dados = [];

            for (let i = 1; i < linhas.length; i++) {

                const valores = linhas[i].split(delimitador).map(v => v.trim());

                if (valores.length < 3) continue;

                // SEMPRE detecta a coluna numérica (matrícula) por linha
                let idxNum = -1;
                for (let j = 0; j < valores.length; j++) {
                    if (/^\d+$/.test(valores[j])) { idxNum = j; break; }
                }

                if (idxNum === -1) continue; // linha sem matrícula válida

                const matricula = valores[idxNum];

                // Usa o cabeçalho se reconhecido, senão detecta por heurística
                let nome, graduacao;

                if (idxNome !== undefined && idxGraduacao !== undefined && idxNome !== idxNum && idxGraduacao !== idxNum) {
                    nome = valores[idxNome] !== undefined ? valores[idxNome] : '';
                    graduacao = valores[idxGraduacao] !== undefined ? valores[idxGraduacao] : '';
                } else {
                    // Heurística: entre as colunas não numéricas, a graduação contém "PM" ou é a mais curta
                    const restantes = valores.filter((_, j) => j !== idxNum);
                    let idxGrad = restantes.findIndex(v => /PM|Ten|Maj|Cap|Asp|Cad|Sgt|Cb|Sd|Al/i.test(v));
                    if (idxGrad === -1) {
                        let menor = 0;
                        for (let j = 1; j < restantes.length; j++) {
                            if (restantes[j].length < restantes[menor].length) menor = j;
                        }
                        idxGrad = menor;
                    }
                    graduacao = restantes[idxGrad] || '';
                    nome = restantes.filter((_, j) => j !== idxGrad)[0] || '';
                }

                if (matricula !== '' && nome !== '') {
                    dados.push({ matricula, nome, graduacao });
                }
            }

            if (dados.length === 0) {
                alert('Nenhuma linha válida encontrada. Verifique se o CSV possui cabeçalho com as colunas: graduacao, nome, matricula (separadas por vírgula ou ponto e vírgula).');
                return;
            }

            Livewire.dispatch('carregarTurma', { dados: dados });

        };

        reader.readAsText(file, 'UTF-8');
    };

    document.addEventListener('change', window.__sgcHandleArquivoChange);
}
</script>
