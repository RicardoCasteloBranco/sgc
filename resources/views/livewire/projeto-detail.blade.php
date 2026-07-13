<div class="p-6">
    <div class="w-full">
        <div class="flex flex-col lg:flex-row gap-6 items-stretch h-auto">
            <div class="w-full lg:w-1/2 bg-white text-black shadow p-5 rounded-lg">
                <div class="ml-4">
                    <h3 class="text-2xl font-bold mb-4 uppercase">Detalhes do Projeto</h3>
                    <p><strong>Nome:</strong> {{ $projeto->curso->nome }}</p>
                    <p><strong>Centro de Ensino:</strong> {{ $projeto->centroEnsino->nome }}</p>
                    <p><strong>Quantidade de Turmas Previstas:</strong> {{ $projeto->quantidade_turmas }}</p>
                    <p><strong>Carga Horária Total: </strong>{{ $projeto->cargaHorariaTotal() }} horas</p>
                    <p><strong>Custo com Hora-aula:</strong> R$ {{ number_format($projeto->custo_pessoal, 2, ',', '.') }}</p>
                    <p><strong>Custo com Material:</strong> R$ {{ number_format($projeto->custo_material, 2, ',', '.') }}</p>
                    <p><strong>Custo com Serviços:</strong> R$ {{ number_format($projeto->custo_servico, 2, ',', '.') }}</p>
                    <p><strong>Material Bélico:</strong></p>
                </div>
                <div class="mt-4">
                    <x-table>
                        <x-slot name="theaders">
                            <th class="p=3">Descrição</th>
                            <th class="p-3">Qtd/Aluno</th>
                            <th class="p-3">Ações</th>
                        </x-slot>
                        <x-slot name="tbody">
                            @foreach($materialBelico as $material)
                            <tr class="{{$loop->even ? 'bg-blue-100' : 'bg-white' }} transition">
                                <td class="p-3">{{ $material->tipoMaterialBelico->descricao }}</td>
                                <td class="p-3">{{ $material->quantidade_por_aluno }}</td>
                                <td class="p-3">
                                    <button wire:click="editMaterial({{ $material->id }})" class="text-green-700">
                                            Editar
                                    </button>
                                    <button wire:click="apagaMaterial({{ $material->id }})" class="text-red-600">
                                        Apagar
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </x-slot>
                    </x-table>
                    <div class="m-4 px-1">
                    <x-button wire:click="createMaterialBelico">
                        Inserir Material
                    </x-button>
                </div>
                </div>
            </div>
            <div class="w-full lg:w-1/2 bg-white p-5 rounded-lg shadow flex flex-col">
                <!-- Tabela de Disciplinas -->
                <div class="flex-1 overflow-y-auto mt-4">
                    <h1 class="ml-4 text-lg font-semibold uppercase">Disciplinas</h1>
                    <h4 class="ml-4 mb-4 text-sm">Lista de Disciplinas do Projeto</h4>
                    <x-table>
                        <x-slot name="theaders">
                            <th class="p-3">Nome</th>
                            <th class="p-3">Abreviação</th>
                            <th class="p-3">Carga Horária</th>
                            <th class="p-3">Ação</th>
                        </x-slot>
                        <x-slot name="tbody">
                            @foreach($disciplinas as $disciplina)
                                <tr class="{{$loop->even ? 'bg-blue-100' : 'bg-white' }} transition">
                                    <td class="text-center p-2">{{ $disciplina->nome }}</td>
                                    <td class="text-center p-2">{{ $disciplina->abreviacao }}</td>
                                    <td class="text-center p-2">{{ $disciplina->carga_horaria }}</td>
                                    <td class="text-center p-2">
                                        <button wire:click="editDisciplina({{ $disciplina->id }})" class="text-green-700">
                                        Editar
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </x-slot>
                    </x-table>
                    <!-- Fim da Tabela de Disciplinas -->
                </div>
                <div class="m-4 px-1">
                    {{ $disciplinas->links() }}
                </div>
                <div class="m-4 px-1">
                    <x-button wire:click="createDisciplina">
                        Inserir Disciplina
                    </x-button>
                </div>
            </div>
        </div>
    </div>
    <!-- Tabela de Turmas -->
    <div>
        <div class="container mx-auto px-4 mt-8 mb-2 flex flex-col lg:flex-row gap-6">
            <div class="lg:w-1/2 w-full flex flex-col">
                <h1 class="text-lg font-semibold uppercase">Turma</h1>
                <h4 class="text-sm mb-2">Lista turmas do Projeto</h4>
            </div>
            <div class="lg:w-1/2 w-full items-end justify-end flex p-2">
                <x-button wire:click="createTurma">
                    Nova Turma
                </x-button>
            </div>
        </div>
        <x-table>
            <x-slot name="theaders">
                <th class="p-3">Início</th>
                <th class="p-3">Término</th>
                <th class="p-3">CH Diária</th>
                <th class="p-3">Dias Letivos na Semana</th>
                <th class="p-3">Unidade</th>
                <th class="p-3">Qtd de Matriculados</th>
                <th class="p-3">Qtd de Concluintes</th>
                <th class="p-3">Qtd de Desistentes</th>
                <th class="p-3">Qtd de Excluídos</th>
                <th class="p-3">Ações</th>
            </x-slot>
            <x-slot name="tbody">
                @foreach($projeto->turmas as $turma)
                    <tr class="{{$loop->even ? 'bg-blue-100' : 'bg-white' }}">
                        <td class="text-center p-2">{{ date('d/m/Y', strtotime($turma->data_inicio)) }}</td>
                        <td class="text-center p-2">{{ is_null($turma->data_fim) ? 'N/A' : date('d/m/Y', strtotime($turma->data_fim)) }}</td>
                        <td class="text-center p-2">{{ $turma->carga_horaria_diaria }}</td>
                        <td class="text-center p-2">{{ $turma->dias_de_aula_por_semana }}</td>
                        <td class="text-center p-2">{{ $turma->unidade->sigla }}</td>
                        <td class="text-center p-2">{{ $turma->quantidadeMatriculados() }}</td>
                        <td class="text-center p-2">{{ $turma->quantidadeAprovados() }}</td>
                        <td class="text-center p-2">{{ $turma->quantidadeDesistentes() }}</td>
                        <td class="text-center p-2">{{ $turma->quantidadeExcluidos() }}</td>

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
        <div class="container mx-auto px-4 mt-8 mb-2 flex flex-col lg:flex-row gap-6">
            <div class="lg:w-1/2 w-full flex flex-col">
                <h1 class="text-lg font-semibold uppercase">Parecer Técnico</h1>
                <h4 class="text-sm mb-2">Lista os Pareceres Técnicos do Projeto</h4>
            </div>
            <div class="lg:w-1/2 w-full items-end justify-end flex p-2">
                <x-button wire:click="createParecerTecnico">
                    Adicionar Parecer
                </x-button>
            </div>
        </div>
        <x-table>
            <x-slot name="theaders">
                <th class="p-3">Número</th>
                <th class="p-3">Validade</th>
                <th class="p-3">Ação</th>
            </x-slot>
            <x-slot name="tbody">
                @foreach($projeto->pareceresTecnicos as $parecer)
                    <tr class="{{$loop->even ? 'bg-blue-100' : 'bg-white' }}">
                        <td class="text-center p-2">{{ $parecer->numero }}</td>
                        <td class="text-center p-2">{{ date('d/m/Y', strtotime($parecer->validade)) }}</td>
                        <td class="text-center p-2">
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
    <!-- Modal de Cadastro/Edição de Material -->
     <x-modal wire:model="openModalMaterial">
        <x-form-section submit="{{ $isEditMaterial ? 'updateMaterialBelico' : 'saveMaterialBelico' }}">
            <x-slot name="title">
                {{ $isEditMaterial ? 'Editar Material' : 'Adicionar Material' }}
            </x-slot>
            <x-slot name="description">
                {{ $isEditMaterial ? 'Edite a quantidade de Material por Alunos.' : 'Preencha a quantidade de materiais por aluno.' }}
            </x-slot>
            <x-slot name="form">
                <x-input type="hidden" id="projetoID" wire:model="projetoId" />
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="tipoMaterialId" value="Tipo de Material Bélico" />
                    <x-select id="tipoMaterialId" type="text" class="mt-1 block w-full" wire:model.defer="tipoMaterialId">
                        <option>Selecione um dos Materiais</option>
                        @foreach($tiposMateriais as $tipo)
                        <option value="{{ $tipo->id }}">{{ $tipo->descricao }}</option>
                        @endforeach
                    </x-select>
                    <x-input-error for="tipoMaterialId" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="quantidadePorAluno" value="Quantidade Por Aluno" />
                    <x-input id="quantidadePorAluno" type="text" class="mt-1 block w-full" wire:model.defer="quantidadePorAluno" />
                    <x-input-error for="quantidadePorAluno" class="mt-2" />
                </div>
            </x-slot>
            <x-slot name="actions">
                <x-secondary-button wire:click="$set('openModalMaterial', false)">
                    Cancelar
                </x-secondary-button>
                <x-button class="ml-3" type="submit">
                    {{ $isEditMaterial ? 'Atualizar' : 'Salvar' }}
                </x-button>
            </x-slot>
        </x-form-section>
     </x-modal>
     <!-- Fim do Modal de Cadastro/Edicação de Material -->
    <!-- Modal para apagar Material -->
     <x-dialog-modal wire:model="openModalDeletaMaterial">
        <x-slot name="title">Apagar Material</x-slot>
        <x-slot name="content">Você tem certeza que deseja apagar o material ?</x-slot>
        <x-slot name="footer">
            <x-button wire:click="deleteMaterial">Confirma</x-button>
            <x-secondary-button wire:click="$set('openModalDeletaMaterial', false)" class="ml-4">Cancela</x-secondary-button>
        </x-slot>
     </x-dialog-modal>
     <!-- Fim do Modal para apagar material -->
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
