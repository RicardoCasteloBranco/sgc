<div class="p-6">
    <div class="w-full">
        <div class="flex flex-col lg:flex-row gap-6 items-start">
            <div class="w-full lg:w-1/2 bg-gray-200 text-black p-5 rounded-lg h-[480px]">
                <h3 class="text-2xl font-bold mb-4">Detalhes do Projeto</h3>
                <p><strong>Nome:</strong> {{ $projeto->curso->nome }}</p>
                <p><strong>Centro de Ensino:</strong> {{ $projeto->centroEnsino->nome }}</p>
                <p><strong>Quantidade de Turmas Previstas:</strong> {{ $projeto->quantidade_turmas }}</p>
                <p><strong>Carga Horária Total: </strong>{{ $projeto->cargaHorariaTotal() }} horas</p>
                <p><strong>Custo com Pessoal:</strong> R$ {{ number_format($projeto->custo_pessoal, 2, ',', '.') }}</p>
                <p><strong>Custo com Material:</strong> R$ {{ number_format($projeto->custo_material, 2, ',', '.') }}</p>
                <p><strong>Custo com Serviços:</strong> R$ {{ number_format($projeto->custo_servico, 2, ',', '.') }}</p>
            </div>
            <div class="w-full lg:w-1/2 bg-white p-5 rounded-lg shadow h-[400px] flex flex-col">
                <!-- Tabela de Disciplinas -->
                <x-section-title title="Disciplinas" description="Lista de disciplinas do projeto" />
                <div class="flex-1 overflow-y-auto mt-4">
                    <x-table>
                        <x-slot name="theaders">
                            <th>Nome</th>
                            <th>Abreviação</th>
                            <th>Carga Horária</th>
                            <th>Ação</th>
                        </x-slot>
                        <x-slot name="tbody">
                            @foreach($disciplinas as $disciplina)
                                <tr>
                                    <td class="text-center">{{ $disciplina->nome }}</td>
                                    <td class="text-center">{{ $disciplina->abreviacao }}</td>
                                    <td class="text-center">{{ $disciplina->carga_horaria }}</td>
                                    <td class="text-center">
                                        <button wire:click="editDisciplina({{ $disciplina->id }})" class="text-green-300">
                                        Editar
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </x-slot>
                    </x-table>
                    <!-- Fim da Tabela de Disciplinas -->
                </div>
                <div class="mt-4">
                    {{ $disciplinas->links() }}
                </div>
                <div>
                    <x-button class="mt-4" wire:click="createDisciplina">
                        Inserir Disciplina
                    </x-button>
                </div>
            </div>
        </div>
    </div>
    <!-- Tabela de Turmas -->
    <div>
        <x-section-title title="Turmas" description="Lista de turmas do projeto"/>
        <x-button class="m-4" wire:click="createTurma">
            Nova Turma
        </x-button>
        <x-table>
            <x-slot name="theaders">
                <th>Início</th>
                <th>Término</th>
                <th>CH Diária</th>
                <th>Dias Letivos na Semana</th>
                <th>Unidade</th>
                <th>Qtd de Matriculados</th>
                <th>Qtd de Concluintes</th>
                <th>Editais de Docente</th>
                <th>Editais de Discente</th>
                <th>Port. de Docente</th>
                <th>Port. de Matrícula</th>
                <th>Port. de Conclusão</th>
                <th>Ações</th>
            </x-slot>
            <x-slot name="tbody">
                @foreach($projeto->turmas as $turma)
                    <tr class="{{$loop->even ? 'bg-blue-100' : 'bg-white' }}">
                        <td class="text-center">{{ date('d/m/Y', strtotime($turma->data_inicio)) }}</td>
                        <td class="text-center">{{ is_null($turma->data_fim) ? 'N/A' : date('d/m/Y', strtotime($turma->data_fim)) }}</td>
                        <td class="text-center">{{ $turma->carga_horaria_diaria }}</td>
                        <td class="text-center">{{ $turma->dias_de_aula_por_semana }}</td>
                        <td class="text-center">{{ $turma->unidade->sigla }}</td>
                        <td class="text-center">{{ $turma->quantidade_matriculados }}</td>
                        <td class="text-center">{{ $turma->quantidade_concluintes }}</td>
                        <td class="text-center">{{ $turma->edital_docente }}</td>
                        <td class="text-center">{{ $turma->edital_discente }}</td>
                        <td class="text-center">{{ $turma->portaria_docente }}</td>
                        <td class="text-center">{{ $turma->portaria_matricula }}</td>
                        <td class="text-center">{{ $turma->portaria_conclusao }}</td>
                        <td class="text-center">
                            <button wire:click="editTurma({{ $turma->id }})" class="text-gray-600">
                                Editar
                            </button>
                            <button wire:click="viewTurma({{ $turma->id }})" class="text-green-600">
                                Detalhes
                            </button>
                        </td>
                    </tr>
                @endforeach
            </x-slot>
        </x-table>
    </div>
    <!-- Fim da Tabela de Turmas -->
    <!-- Tabela de Pareceres Técnicos -->
    <div class="mt-8">
        <x-section-title title="Pareceres Técnicos" description="Lista de pareceres técnicos do projeto"/>
        <x-button wire:click="createParecerTecnico" class="m-4">Adicionar Parecer Tecnico</x-button>
        <x-table>
            <x-slot name="theaders">
                <th>Número</th>
                <th>Validade</th>
                <th>Ação</th>
            </x-slot>
            <x-slot name="tbody">
                @foreach($projeto->pareceresTecnicos as $parecer)
                    <tr class="{{$loop->even ? 'bg-blue-100' : 'bg-white' }}">
                        <td class="text-center">{{ $parecer->numero }}</td>
                        <td class="text-center">{{ date('d/m/Y', strtotime($parecer->validade)) }}</td>
                        <td class="text-center">
                            <a href="{{ route('parecer.visualizar',$parecer->id) }}" target="_blank">
                                <button class="text-green-600">
                                    Visualizar
                                </button>
                            </a>
                            <button wire:click="deleteParecer({{ $parecer->id }})" class="text-red-600">
                                Apagar
                            </button>
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
                <x-input type="hidden" wire:model="projetoId" />
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="dataInicio" value="Data de Início" />
                    <x-input id="dataInicio" type="date" class="mt-1 block w-full" wire:model.defer="dataInicio" />
                    <x-input-error for="dataInicio" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="dataFim" value="Data de Fim" />
                    <x-input id="dataFim" type="date" class="mt-1 block w-full" wire:model.defer="dataFim" />
                    <x-input-error for="dataFim" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="cargaHorariaDiaria" value="Carga Horária Diária" />
                    <x-input id="cargaHorariaDiaria" type="number" class="mt-1 block w-full" wire:model.defer="cargaHorariaDiaria" />
                    <x-input-error for="cargaHorariaDiaria" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="diasDeAulaPorSemana" value="Dias de Aula por Semana" />
                    <x-input id="diasDeAulaPorSemana" type="number" class="mt-1 block w-full" wire:model.defer="diasDeAulaPorSemana" />
                    <x-input-error for="diasDeAulaPorSemana" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="unidadeId" value="Unidade" />
                    <x-select id="unidadeId" class="mt-1 block w-full" wire:model.defer="unidadeId">
                        <option value="">Selecione uma unidade</option>
                        @foreach($diretorias as $diretoria)
                            <optgroup label="{{ $diretoria->nome }}">
                                @foreach($diretoria->subordinadas as $unidade)
                                    <option value="{{ $unidade->id }}">{{ $unidade->nome }}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </x-select>
                    <x-input-error for="unidadeId" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="quantidadeMatriculados" value="Quantidade de Matriculados" />
                    <x-input id="quantidadeMatriculados" type="number" class="mt-1 block w-full" wire:model.defer="quantidadeMatriculados" />
                    <x-input-error for="quantidadeMatriculados" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="quantidadeConcluintes" value="Quantidade de Concluintes" />
                    <x-input id="quantidadeConcluintes" type="number" class="mt-1 block w-full" wire:model.defer="quantidadeConcluintes" />
                    <x-input-error for="quantidadeConcluintes" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="editalDiscente" value="Edital de Discente" />
                    <x-input id="editalDiscente" type="text" class="mt-1 block w-full" wire:model.defer="editalDiscente" />
                    <x-input-error for="editalDiscente" class="mt-2" />
                </div>
                 <div class="col-span-6 sm:col-span-4">
                    <x-label for="editalDocente" value="Edital de Docente" />
                    <x-input id="editalDocente" type="text" class="mt-1 block w-full" wire:model.defer="editalDocente" />
                    <x-input-error for="editalDocente" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="portariaDocente" value="Portaria de Docente" />
                    <x-input id="portariaDocente" type="text" class="mt-1 block w-full" wire:model.defer="portariaDocente" />
                    <x-input-error for="portariaDocente" class="mt-2" />
                </div>
                 <div class="col-span-6 sm:col-span-4">
                    <x-label for="portariaMatricula" value="Portaria de Matrícula" />
                    <x-input id="portariaMatricula" type="text" class="mt-1 block w-full" wire:model.defer="portariaMatricula" />
                    <x-input-error for="portariaMatricula" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="portariaConclusao" value="Portaria de Conclusão" />
                    <x-input id="portariaConclusao" type="text" class="mt-1 block w-full" wire:model.defer="portariaConclusao" />
                    <x-input-error for="portariaConclusao" class="mt-2" />
                </div>
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
     <!-- Fim do Modal de Cadastro/Edição de Turma -->
     <!-- Modal de Cadastro/Edição de Disciplina -->
     <x-modal wire:model="openModalDisciplina">
        <x-form-section submit="{{ $isEditDisciplina ? 'updateDisciplina' : 'saveDisciplina' }}">
            <x-slot name="title">
                {{ $isEditDisciplina ? 'Editar Disciplina' : 'Nova Disciplina' }}
            </x-slot>
            <x-slot name="description">
                {{ $isEditDisciplina ? 'Edite os detalhes da disciplina.' : 'Preencha os detalhes da nova disciplina.' }}
            </x-slot>
            <x-slot name="form">
                <x-input type="hidden" id="projetoID" wire:model="projetoId" />
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="nomeDisciplina" value="Nome da Disciplina" />
                    <x-input id="nomeDisciplina" type="text" class="mt-1 block w-full" wire:model.defer="nomeDisciplina" />
                    <x-input-error for="nomeDisciplina" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="abreviacao" value="Abreviação" />
                    <x-input id="abreviacao" type="text" class="mt-1 block w-full" wire:model.defer="abreviacao" />
                    <x-input-error for="abreviacao" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="cargaHoraria" value="Carga Horária" />
                    <x-input id="cargaHoraria" type="number" class="mt-1 block w-full" wire:model.defer="cargaHoraria" />
                    <x-input-error for="cargaHoraria" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="ementa" value="Ementa" />
                    <x-textarea id="ementa" class="mt-1 block w-full" wire:model.defer="ementa" />
                    <x-input-error for="ementa" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="conhecimentos" value="Conhecimentos" />
                    <x-textarea id="conhecimentos" class="mt-1 block w-full" wire:model.defer="conhecimentos" />
                    <x-input-error for="conhecimentos" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="habilidades" value="Habilidades" />
                    <x-textarea id="habilidades" class="mt-1 block w-full" wire:model.defer="habilidades" />
                    <x-input-error for="habilidades" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="atitudes" value="Atitudes" />
                    <x-textarea id="atitudes" class="mt-1 block w-full" wire:model.defer="atitudes" />
                    <x-input-error for="atitudes" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="referencias" value="Referências" />
                    <x-textarea id="referencias" class="mt-1 block w-full" wire:model.defer="referencias" />
                    <x-input-error for="referencias" class="mt-2" />
                </div>
            </x-slot>
            <x-slot name="actions">
                <x-secondary-button wire:click="$set('openModalDisciplina', false)">
                    Cancelar
                </x-secondary-button>
                <x-button class="ml-3" type="submit">
                    {{ $isEditDisciplina ? 'Atualizar' : 'Salvar' }}
                </x-button>
            </x-slot>
        </x-form-section>
     </x-modal>
     <!-- Fim do Modal de Cadastro/Edicação de Disciplina -->
    <!-- Modal de Cadastro de Parecer Técnico -->
    @if($openModalParecer)
        <div class="fixed inset-0 z-50 overflow-y-auto">
            
            <!-- Fundo escuro -->
            <div class="fixed inset-0 bg-black opacity-50"></div>

            <!-- Modal -->
            <div class="flex items-center justify-center min-h-screen p-4">
                
                <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl relative z-50">
                    
                    <!-- Cabeçalho -->
                    <div class="flex items-center justify-between border-b px-6 py-4">
                        <h2 class="text-xl font-semibold">
                            Adicionar Parecer Técnico
                        </h2>

                        <button
                            type="button"
                            wire:click="$set('openModalParecer', false)"
                            class="text-gray-500 hover:text-gray-700 text-2xl"
                        >
                            &times;
                        </button>
                    </div>

                    <!-- Formulário -->
                    <form wire:submit.prevent="saveParecer" enctype="multipart/form-data">

                        <div class="p-6 space-y-4">

                            <div>
                                <label for="numero" class="block text-sm font-medium text-gray-700">
                                    Número
                                </label>

                                <input
                                    id="numero"
                                    type="text"
                                    wire:model="numero"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                >

                                @error('numero')
                                    <span class="text-red-500 text-sm">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div>
                                <label for="validade" class="block text-sm font-medium text-gray-700">
                                    Validade
                                </label>

                                <input
                                    id="validade"
                                    type="date"
                                    wire:model="validade"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                >

                                @error('validade')
                                    <span class="text-red-500 text-sm">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div>
                                <label for="arquivo" class="block text-sm font-medium text-gray-700">
                                    Arquivo PDF
                                </label>

                                <input
                                    id="arquivo"
                                    type="file"
                                    wire:model="arquivo"
                                    accept=".pdf"
                                    class="mt-1 block w-full border border-gray-300 rounded-md p-2"
                                >

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
                            <x-secondary-button wire:click="$set('openModalParecer', false)">
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
    <!-- Fim do Modal de Cadastro de Parecer Técnico -->
</div>
