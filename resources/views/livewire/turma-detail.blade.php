<div class="p-6">
    <div class="container mx-auto">
        <div class="w-full ml-4">
            <!-- Detalhes do Projeto -->
            <h3 class="text-2xl font-bold mb-4 uppercase">Gerenciar Turma</h3>
            <p><strong>Centro de Ensino:</strong> {{ $turma->projeto->centroEnsino->nome }}</p>
            <p><strong>Projeto:</strong> <a href="{{ route('projeto',['projeto'=>$turma->projeto->id]) }}" >{{ $turma->projeto->numeroProjeto() }}</a></p>
            <p><strong>Turma:</strong> {{ $turma->numeroTurma() }}</p>
            <p><strong>Coordenador: </strong>@if($turma->coordenador){{ $turma->coordenador->graduacao }} {{ $turma->coordenador->pessoa->nome }}@endif</p>
            <!-- Fim dos detalhes do Projeto -->
        </div>
        <div>
            <!-- Botões de Ação -->
            <x-button wire:click="{{ empty($turma->coordenador)? 'inserirCoordenador()' : 'alterarCoordenador()' }}"
            class="m-4">{{ empty($turma->coordenador) ? 'Inserir Coordenador' : 'Alterar Coordenador' }}</x-button>
            <!-- Fim dos botões de ações --->
        </div>
    </div>
    <div class="w-full border border-gray-300 rounded-lg shadow-sm bg-white p-6 mt-6">

        <!-- ABAS -->
        <div class="border-b border-gray-200 mb-6">

            <nav class="flex gap-1" aria-label="Abas">

                <!-- Aba Alunos -->
                <button
                    type="button"
                    wire:click="selecionarAba('alunos')"
                    class="px-5 py-3 text-sm font-medium border-b-2 transition
                        {{ $abaAtiva === 'alunos'
                            ? 'border-blue-600 text-blue-600'
                            : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'
                        }}"
                >
                    Alunos
                </button>

                <!-- Aba Instrutores -->
                <button
                    type="button"
                    wire:click="selecionarAba('instrutores')"
                    class="px-5 py-3 text-sm font-medium border-b-2 transition
                        {{ $abaAtiva === 'instrutores'
                            ? 'border-blue-600 text-blue-600'
                            : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'
                        }}"
                >
                    Instrutores
                </button>

                <!-- Aba Horários -->
                <button
                    type="button"
                    wire:click="selecionarAba('horarios')"
                    class="px-5 py-3 text-sm font-medium border-b-2 transition
                        {{ $abaAtiva === 'horarios'
                            ? 'border-blue-600 text-blue-600'
                            : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'
                        }}"
                >
                    Horários
                </button>

            </nav>

        </div>


        <!-- ====================================================== -->
        <!-- ABA ALUNOS                                             -->
        <!-- ====================================================== -->

        @if($abaAtiva === 'alunos')

            <div>
                <div class="flex items-center justify-between mb-4">

                    <x-section-title
                    title="Alunos"
                    description="">
                    </x-section-title>
                    <div class="flex items-center gap-2">
                        <x-button wire:click="carregarLista()" class="m-4">Carrregar Turma</x-button>

                        <button
                            wire:click="adicionarAluno()"
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Adicionar Aluno
                        </button>
                    </div>
                </div>
                

                <x-table>

                    <x-slot name="theaders">
                        <th class="p-3">Graduação</th>
                        <th class="p-3">Nome Completo</th>
                        <th class="p-3">Matrícula</th>
                        <th class="p-3">Situação</th>
                        <th class="p-3">Ações</th>
                    </x-slot>

                    <x-slot name="tbody">

                        @foreach($turma->alunos as $aluno)

                            <tr
                                class="{{ $loop->even ? 'bg-blue-100' : 'bg-white' }}"
                                wire:key="aluno-{{ $aluno->id }}"
                            >

                                <td>{{ $aluno->graduacao }}</td>

                                <td>{{ $aluno->pessoa->nome }}</td>

                                <td>{{ $aluno->pessoa->matricula }}</td>

                                <td>{{ $aluno->situacao }}</td>

                                <td class="space-x-3">

                                    <button
                                        wire:click="editarAluno({{ $aluno->id }})"
                                        class="text-green-700 hover:text-green-900"
                                    >
                                        Editar
                                    </button>

                                    <button
                                        wire:click="apagarAluno({{ $aluno->id }})"
                                        wire:confirm="Deseja apagar o aluno {{ $aluno->pessoa->nome }}?"
                                        class="text-red-600 hover:text-red-800"
                                    >
                                        Apagar
                                    </button>

                                </td>

                            </tr>

                        @endforeach

                    </x-slot>

                </x-table>

            </div>

        @endif


        <!-- ====================================================== -->
        <!-- ABA INSTRUTORES                                        -->
        <!-- ====================================================== -->

        @if($abaAtiva === 'instrutores')

            <div>
                <div class="flex items-center justify-between mb-4">

                    <x-section-title
                    title="Instrutores"
                    description="">
                </x-section-title>

                    <button
                        wire:click="adicionarInstrutor()"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700"
                    >
                        Adicionar Instrutor
                    </button>

                </div>

                <x-table>

                    <x-slot name="theaders">
                        <th class="p-3">Posto/Graduação</th>
                        <th class="p-3">Nome</th>
                        <th class="p-3">Disciplina</th>
                        <th class="p-3">Instrutor</th>
                        <th class="p-3">Data de Designação</th>
                        <th class="p-3">Ações</th>
                    </x-slot>

                    <x-slot name="tbody">

                        @foreach($turma->instrutores as $instrutor)

                            <tr
                                class="{{ $loop->even ? 'bg-blue-100' : 'bg-white' }}"
                                wire:key="instrutor-{{ $instrutor->id }}"
                            >

                                <td>{{ $instrutor->posto_graduacao }}</td>

                                <td>{{ $instrutor->pessoa->nome }}</td>

                                <td>{{ $instrutor->disciplina->nome }}</td>

                                <td>{{ $instrutor->tipo_instrutor }}</td>

                                <td>
                                    {{ date('d/m/Y', strtotime($instrutor->designacao)) }}
                                </td>

                                <td class="space-x-3">

                                    <button
                                        wire:click="editarInstrutor({{ $instrutor->id }})"
                                        class="text-green-700 hover:text-green-900"
                                    >
                                        Editar
                                    </button>

                                    <button
                                        wire:click="apagarInstrutor({{ $instrutor->id }})"
                                        wire:confirm="Deseja apagar o instrutor {{ $instrutor->pessoa->nome }}?"
                                        class="text-red-600 hover:text-red-800"
                                    >
                                        Apagar
                                    </button>

                                </td>

                            </tr>
                        @endforeach
                    </x-slot>
                </x-table>
            </div>

        @endif


        <!-- ====================================================== -->
        <!-- ABA HORÁRIOS                                           -->
        <!-- ====================================================== -->

        @if($abaAtiva === 'horarios')
            <div>

                <div class="flex items-center justify-between mb-4">

                    <x-section-title
                        title="Horários"
                        description="">
                    </x-section-title>

                    <div class="flex items-center gap-2">
                        <button
                            wire:click="adicionarHorario()"
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            Adicionar Horário
                        </button>
                        <x-button wire:click="adicionarAula()" class="m-4">Adicionar Aula</x-button>
                    </div>
                </div>


                <x-table>

                    <x-slot name="theaders">

                        <th class="p-3">Data</th>

                        @foreach($horarios as $horario)
                            <th class="p-3">
                                <div class="flex items-center justify-center gap-2">

                                    <span>
                                        {{ date('H:i', strtotime($horario->hora_inicio)) }}
                                        -
                                        {{ date('H:i', strtotime($horario->hora_fim)) }}
                                    </span>

                                    <!-- Editar -->
                                    <a
                                        href="#"
                                        wire:click="editarHorario({{ $horario->id }})"
                                        class="text-gray-500 hover:text-blue-600"
                                        title="Editar horário">
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            width="12"
                                            height="12"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2"
                                            stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/>
                                            <path d="m15 5 4 4"/>
                                        </svg>
                                    </a>

                                    <!-- Apagar -->
                                    <a
                                        href="#"
                                        wire:click="apagarHorario({{ $horario->id }})"
                                        wire:confirm="Deseja apagar o horário?"
                                        class="text-gray-500 hover:text-red-600"
                                        title="Apagar horário">
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            width="12"
                                            height="12"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2"
                                            stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <polyline points="3 6 5 6 21 6"/>
                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3-3h8l1 1H6l1-1Z"/>
                                        </svg>
                                    </a>
                                </div>
                            </th>
                        @endforeach
                    </x-slot>


                    <x-slot name="tbody">
                        @foreach($datasAulas as $data)
                            <tr
                                class="{{ $loop->even ? 'bg-blue-100' : 'bg-white' }}"
                                wire:key="data-{{ $data }}">

                                <!-- DATA -->
                                <td class="p-3 text-center font-medium">
                                    {{ date('d/m/Y', strtotime($data)) }}
                                </td>
                                <!-- HORÁRIOS -->
                                @foreach($horarios as $horario)
                                    <td class="p-3 text-center">
                                        @php
                                            $aula = $aulasPorDataHorario[$data][$horario->id] ?? null;
                                        @endphp

                                        @if($aula)
                                            <div class="flex items-center justify-center gap-2">

                                                <span>
                                                    {{ $aula->disciplina->abreviacao }}
                                                    </br>
                                                    {{$aula->aulasMinistradas()}} de {{$aula->disciplina->carga_horaria}}
                                                </span>

                                                <!-- Editar -->
                                                <a
                                                    href="#"
                                                    wire:click="editarAula({{ $aula->id }})"
                                                    class="text-gray-500 hover:text-blue-600"
                                                    title="Editar aula">
                                                    <svg
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        width="12"
                                                        height="12"
                                                        viewBox="0 0 24 24"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        stroke-width="2"
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/>
                                                        <path d="m15 5 4 4"/>
                                                    </svg>
                                                </a>

                                                <!-- Apagar -->
                                                <a
                                                    href="#"
                                                    wire:click="apagarAula({{ $aula->id }})"
                                                    wire:confirm="Deseja apagar a aula?"
                                                    class="text-gray-500 hover:text-red-600"
                                                    title="Apagar aula">
                                                    <svg
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        width="12"
                                                        height="12"
                                                        viewBox="0 0 24 24"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        stroke-width="2"
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <polyline points="3 6 5 6 21 6"/>
                                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3-3h8l1 1H6l1-1Z"/>
                                                    </svg>
                                                </a>
                                            </div>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </x-slot>
                </x-table>
            </div>
        @endif
    </div>
    <!-- Fim da tabela de Horários --> 
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
                    <x-input id="graduacaoAluno" type="text" class="mt-1 block w-full" wire:model.defer="graduacaoAluno" />
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
    <!-- Inicio do formulário para adicionar e editar Instrutor -->
     <x-modal wire:model="openModalInstrutor">
        <x-form-section submit="{{ $isEditInstrutor ? 'updateInstrutor' : 'saveInstrutor' }}">
            <x-slot name="title">
                {{ $isEditInstrutor ? 'Alterar Instrutor' : 'Adicionar Instrutor' }}
            </x-slot>
            <x-slot name="description">
                {{ $isEditInstrutor ? 'Alterar um Instrutor para a Turma.' : 'Adicione um Instrutor para a Turma.' }}
            </x-slot>
            <x-slot name="form">
                <x-input type="hidden" id="turmaId" value="{{$turma->id}}" />
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="graduacaoInstrutor" value="Grduação" />
                    <x-input  type="text" id="graduacaoInstrutor" class="mt-1 block w-full" wire:model.defer="graduacaoInstrutor" />
                    <x-input-error for="graduacaoInstrutor" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="nomeInstrutor" value="Nome" />
                    <x-input id="nomeInstrutor" type="text" class="mt-1 block w-full" wire:model.defer="nomeInstrutor" />
                    <x-input-error for="nomeInstrutor" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="matriculaInstrutor" value="Matrícula" />
                    <x-input id="matriculaInstrutor" type="text" class="mt-1 block w-full" wire:model.defer="matriculaInstrutor" />
                    <x-input-error for="matriculaInstrutor" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="dataDesignacaoInstrutor" value="Data de Designação" />
                    <x-input id="dataDesignacaoInstrutor" type="date" class="mt-1 block w-full" wire:model.defer="dataDesignacaoInstrutor" />
                    <x-input-error for="dataDesignacaoInstrutor" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="parecerTecnicoInstrutor" value="Parecer Técnico" />
                    <x-input id="parecerTecnicoInstrutor" type="text" class="mt-1 block w-full" wire:model.defer="parecerTecnicoInstrutor" />
                    <x-input-error for="parecerTecnicoInstrutor" class="mt-2" />
                </div>
                @if($isEditInstrutor)
                    <div class="col-span-6 sm:col-span-4">
                        <x-label for="dataSubstituicaoInstrutor" value="Data de Substituição" />
                        <x-input id="dataSubstituicaoInstrutor" type="date" class="mt-1 block w-full" wire:model.defer="dataSubstituicaoInstrutor" />
                        <x-input-error for="dataSubstituicaoInstrutor" class="mt-2" />
                    </div>
                @endif
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="disciplinaInstrutor" value="Disciplina" />
                    <x-select id="disciplinaInstrutor" type="text" class="mt-1 block w-full" wire:model.defer="disciplinaInstrutor">
                        <option>Selecione uma disciplina:</option>
                        @foreach($turma->projeto->disciplinas as $disciplina)
                        <option value="{{$disciplina->id}}">{{$disciplina->nome}}</option>
                        @endforeach
                    </x-select> 
                    <x-input-error for="disciplinaInstrutor" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="tipoInstrutor" value="Titular" />
                    <x-input id="tipoInstrutor" type="radio" class="mt-1" wire:model.defer="tipoInstrutor" value="Titular"/>
                    <x-label for="tipoInstrutor" value="Secundário" />
                    <x-input id="tipoInstrutor" type="radio" class="mt-1" wire:model.defer="tipoInstrutor" value="Secundário"/>
                    <x-input-error for="tipoInstrutor" class="mt-2" />
                </div>
            </x-slot>
            <x-slot name="actions">
                <x-secondary-button wire:click="$set('openModalInstrutor', false)">
                    Cancelar
                </x-secondary-button>
                <x-button class="ml-3" type="submit">
                    {{ $isEditInstrutor ? 'Atualizar' : 'Salvar' }}
                </x-button>
            </x-slot>
        </x-form-section>
     </x-modal>
    <!-- Fim do formulário para adicionar e editar instrutores -->
    <!-- Início do formulário para adicionar o horário das aulas -->
    <x-modal wire:model="openModalHorario">
        <x-form-section submit="{{ $isEditHorario ? 'updateHorario' : 'saveHorario' }}">
            <x-slot name="title">
                {{ $isEditHorario ? 'Editar Horário das Aulas' : 'Adicionar Horário das Aulas' }}
            </x-slot>
            <x-slot name="description">
                {{ $isEditHorario ? 'Edite o horário das aulas da Turma.' : 'Adicione o horário das aulas da Turma.' }}
            </x-slot>
            <x-slot name="form">
                <x-input type="hidden" id="turmaId" value="{{$turma->id}}" />
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="horaInicio" value="Horário de Início da Aula" />
                    <x-input id="horaInicio" type="time" class="mt-1 block w-full" wire:model.defer="horaInicio" />
                    <x-input-error for="horaInicio" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="horaFim" value="Horário de Fim da Aula" />
                    <x-input id="horaFim" type="time" class="mt-1 block w-full" wire:model.defer="horaFim" />
                    <x-input-error for="horaFim" class="mt-2" />
                </div>
            </x-slot>
            <x-slot name="actions">
                <x-secondary-button wire:click="$set('openModalHorario', false)">
                    Cancelar
                </x-secondary-button>
                <x-button class="ml-3" type="submit">
                    {{ $isEditHorario ? 'Atualizar' : 'Salvar' }}
                </x-button>
            </x-slot>
        </x-form-section>
     </x-modal>
    <!-- Fim do formulário para adicionar o horário das aulas -->
    <!-- Início do formulário para adicionar as aulas -->
    <x-modal wire:model="openModalAula">
        <x-form-section submit="{{ $isEditAula ? 'updateAula' : 'saveAula' }}">
            <x-slot name="title">
                {{ $isEditAula ? 'Editar Aula' : 'Adicionar Aula' }}
            </x-slot>
            <x-slot name="description">
                {{ $isEditAula ? 'Edite a aula da Turma.' : 'Adicione uma aula da Turma.' }}
            </x-slot>
            <x-slot name="form">
                <x-input type="hidden" id="turmaId" value="{{$turma->id}}" />
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="dataAula" value="Data da Aula" />
                    <x-input id="dataAula" type="date" class="mt-1 block w-full" wire:model.defer="dataAula" />
                    <x-input-error for="dataAula" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="disciplinaAula" value="Disciplina" />
                    <x-select id="disciplinaAula" type="text" class="mt-1 block w-full" wire:model.defer="disciplinaAula">
                        <option>Selecione uma disciplina:</option>
                        @foreach($turma->projeto->disciplinas as $disciplina)
                        <option value="{{$disciplina->id}}">{{$disciplina->nome}}</option>
                        @endforeach
                    </x-select>
                    <x-input-error for="disciplinaAula" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="horarioAula" value="Horário" />
                    <x-select id="horarioAula" type="text" class="mt-1 block w-full" wire:model.defer="horarioAula">
                        <option>Selecione um horário:</option>
                        @foreach($turma->horarios as $horario)
                        <option value="{{$horario->id}}">{{$horario->hora_inicio}} - {{$horario->hora_fim}}</option>
                        @endforeach
                    </x-select>
                    <x-input-error for="horarioAula" class="mt-2" />
                </div>
            </x-slot>
            <x-slot name="actions">
                <x-secondary-button wire:click="$set('openModalAula', false)">
                    Cancelar
                </x-secondary-button>
                <x-button class="ml-3" type="submit">
                    {{ $isEditAula ? 'Atualizar' : 'Salvar' }}
                </x-button>
            </x-slot>
        </x-form-section>
     </x-modal>
    <!-- Fim do formulário para adicionar as aulas -->
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
