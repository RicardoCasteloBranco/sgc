<div class="p-6">
    <div class="w-full">
        <div style="display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 1.5rem;">
            <!-- bloco de Detalhes do Projeto -->
            <div class="bg-white text-black shadow p-5 rounded-lg flex flex-col justify-between">
                    <h3 class="text-2xl font-bold mb-4 uppercase">Detalhes do Projeto</h3>
                    <p><strong>Nome:</strong> {{ $projeto->curso->nome }}</p>
                    <p><strong>Centro de Ensino:</strong> {{ $projeto->centroEnsino->nome }}</p>
                    <p><strong>Quantidade de Turmas Previstas:</strong> {{ $projeto->quantidade_turmas }}</p>
                    <p><strong>Carga Horária Total: </strong>{{ $projeto->cargaHorariaTotal() }} horas</p>
                    <p><strong>Modalidade: </strong>{{ $projeto->curso->modalidade }}</p>
                    <p><strong>Público Alvo: </strong>{{ $projeto->curso->publico_alvo }}</p>
                    <p><strong>Objetivo Geral: </strong>{{ $projeto->curso->objetivo_geral }}</p>
                    <p><strong>Data de Aprovação do Projeto: </strong>{{ date('d/m/Y', strtotime($projeto->data_aprovacao)) }}</p>
                    <p><strong>Parecer Técnico: </strong>{{ $projeto->parecerTecnico ? $projeto->parecerTecnico->numero : 'N/A' }}</p>
            </div>
            <!-- bloco com o horário do projeto -->
            <div class="bg-white text-black shadow p-5 rounded-lg flex flex-col justify-between">
                <h3 class="text-2xl font-bold mb-4 uppercase">Horário do Projeto</h3>
                    <div style="height: 280px; max-height: 280px; overflow-y: auto; position: relative;" class="border border-gray-100 rounded-lg">
                        <div style="min-height: 100%;">
                            <x-table>
                                <x-slot name="theaders">
                                    <tr>
                                        <th class="px-4 py-2 border-b">Horário de Início</th>
                                        <th class="px-4 py-2 border-b">Horário de Término</th>
                                        <th class="px-4 py-2 border-b">Ação</th>
                                    </tr>
                                </x-slot>
                                <x-slot name="tbody">
                                    @foreach($projeto->horarios as $horario)
                                        <tr class="text-center m-4">
                                            <td class="px-4 py-2 border-b">{{ date('H:i', strtotime($horario->hora_inicio)) }}</td>
                                            <td class="px-4 py-2 border-b">{{ date('H:i', strtotime($horario->hora_fim)) }}</td>
                                            <td class="px-4 py-2 border-b">
                                                <button wire:click="editarHorario({{ $horario->id }})" class="text-green-700">
                                                    Editar
                                                </button>
                                                <button wire:click="deleteHorario({{ $horario->id }})" 
                                                    wire:confirm="Tem certeza que deseja apagar o horário {{$horario->hora_inicio}} - {{$horario->hora_fim}}?" class="text-red-600">
                                                    Apagar
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </x-slot>
                            </x-table>
                        </div>
                    </div>
                    <div class="m-4 px-1">
                        <x-button
                            wire:click="adicionarHorario()"
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            Adicionar Horário
                        </x-button>
                    </div>
            </div>

            <!-- bloco de Materiais -->
            <div class="bg-white text-black shadow p-5 rounded-lg flex flex-col justify-between">
                <div>
                    <h1 class="ml-6 text-lg font-semibold uppercase">Custos</h1>
                    <h4 class="ml-6 mb-4 text-sm">Lista de Custos para o Projeto</h4>
                    
                    <!-- Container com altura estrita e scroll ativado por style -->
                    <div style="height: 280px; max-height: 280px; overflow-y: auto; position: relative;" class="border border-gray-100 rounded-lg">
                        <div style="min-height: 100%;">
                            <x-table>
                                <x-slot name="theaders">
                                    <tr class="bg-black text-white sticky top-0">
                                        <th class="p-3">Descrição</th>
                                        <th class="p-3">Unidade</th>
                                        <th class="p-3">Qtd/Turma</th>
                                        <th class="p-3">Ações</th>
                                    </tr>
                                </x-slot>
                                <x-slot name="tbody">
                                    @foreach($materiais as $material)
                                    <tr class="{{$loop->even ? 'bg-blue-100' : 'bg-white' }} transition" wire:key="material-{{ $material->id }}">
                                        <td class="p-3">{{ $material->tipoMaterial->descricao }}</td>
                                        <td class="p-3">{{ $material->tipoMaterial->unidade_medida }}</td>
                                        <td class="p-3">{{ $material->quantidade_por_turma }}</td>
                                        <td class="p-3">
                                            <button wire:click="editMaterial({{ $material->id }})" class="text-green-700">
                                                    Editar
                                            </button>
                                            <button wire:click="apagaMaterial({{ $material->id }})" 
                                                wire:confirm="Tem certeza que deseja apagar o material {{$material->tipoMaterial->descricao}}?" class="text-red-600">
                                                Apagar
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </x-slot>
                            </x-table>
                        </div>
                    </div>
                </div>

                <div class="m-4 px-1">
                    <x-button wire:click="createMaterial">
                        Inserir Custos
                    </x-button>
                </div>
            </div>

            <!-- bloco de Disciplinas -->
            <div class="bg-white text-black shadow p-5 rounded-lg flex flex-col justify-between">
                <div>
                    <h1 class="ml-4 text-lg font-semibold uppercase">Disciplinas</h1>
                    <h4 class="ml-4 mb-4 text-sm">Lista de Disciplinas do Projeto</h4>
                    
                    <!-- Container com altura estrita e scroll ativado por style -->
                    <div style="height: 280px; max-height: 280px; overflow-y: auto; position: relative;" class="border border-gray-100 rounded-lg">
                        <div style="min-height: 100%;">
                            <x-table>
                                <x-slot name="theaders">
                                    <tr class="bg-black text-white sticky top-0">
                                        <th class="p-3">Nome</th>
                                        <th class="p-3">Abreviação</th>
                                        <th class="p-3">Carga Horária</th>
                                        <th class="p-3">Instrutores Titulares</th>
                                        <th class="p-3">Instrutores Secundários</th>
                                        <th class="p-3">Ação</th>
                                    </tr>
                                </x-slot>
                                <x-slot name="tbody">
                                    @foreach($disciplinas as $disciplina)
                                        <tr class="{{$loop->even ? 'bg-blue-100' : 'bg-white' }} transition" wire:key="disciplina-{{ $disciplina->id }}">
                                            <td class="text-center p-2">{{ $disciplina->nome }}</td>
                                            <td class="text-center p-2">{{ $disciplina->abreviacao }}</td>
                                            <td class="text-center p-2">{{ $disciplina->carga_horaria }}</td>
                                            <td class="text-center p-2">{{ $disciplina->qtd_instrutores_titulares }}</td>
                                            <td class="text-center p-2">{{ $disciplina->qtd_instrutores_secundarios }}</td>
                                            <td class="text-center p-2">
                                                <button wire:click="editDisciplina({{ $disciplina->id }})" class="text-green-700">
                                                Editar
                                                </button>
                                                <button wire:click="apagaDisciplina({{ $disciplina->id }})"
                                                wire:confirm="Tem certeza que deseja apagar a disciplina {{$disciplina->nome}}?" class="text-red-600">
                                                    Apagar
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </x-slot>
                            </x-table>
                        </div>
                    </div>
                    <!-- Fim da Tabela de Disciplinas -->
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
                    <tr class="{{$loop->even ? 'bg-blue-100' : 'bg-white' }}" wire:key="turma-{{ $turma->id }}">
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
                    <tr class="{{$loop->even ? 'bg-blue-100' : 'bg-white' }}" wire:key="parecer-tecnico-{{ $parecer->id }}">
                        <td class="text-center p-2">{{ $parecer->numero }}</td>
                        <td class="text-center p-2">{{ date('d/m/Y', strtotime($parecer->validade)) }}</td>
                        <td class="text-center p-2">
                            <a href="{{ route('parecer.visualizar',$parecer->id) }}" target="_blank">
                                <button class="text-green-600">
                                    Visualizar
                                </button>
                            </a>
                            <button wire:click="deleteParecer({{ $parecer->id }})"
                             wire:confirm="Tem certeza que deseja deletar o parecer {{$parecer->numero}}?" class="text-red-600">
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
                    <x-label for="diasDeAulaPorSemana" value="Dias de Aula por Semana" />
                    <x-input id="diasDeAulaPorSemana" type="number" class="mt-1 block w-full" wire:model.defer="diasDeAulaPorSemana" />
                    <x-input-error for="diasDeAulaPorSemana" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="cargaHorariaDiaria" value="Carga Horária Diária" />
                    <x-input id="cargaHorariaDiaria" type="number" class="mt-1 block w-full" wire:model.defer="cargaHorariaDiaria" />
                    <x-input-error for="cargaHorariaDiaria" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="valorHoraAulaCoordenador" value="Valor Hora-aula do Coordenador" />
                    <x-input id="valorHoraAulaCoordenador" type="text" class="mt-1 block w-full" wire:model.defer="valorHoraAulaCoordenador" />
                    <x-input-error for="valorHoraAulaCoordenador" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="valorHoraAulaInstrutorTitular" value="Valor Hora-aula do Instrutor Titular" />
                    <x-input id="valorHoraAulaInstrutorTitular" type="text" class="mt-1 block w-full" wire:model.defer="valorHoraAulaInstrutorTitular" />
                    <x-input-error for="valorHoraAulaInstrutorTitular" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="valorHoraAulaInstrutorSecundario" value="Valor Hora-aula do Instrutor Secundário" />
                    <x-input id="valorHoraAulaInstrutorSecundario" type="text" class="mt-1 block w-full" wire:model.defer="valorHoraAulaInstrutorSecundario" />
                    <x-input-error for="valorHoraAulaInstrutorSecundario" class="mt-2" />
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
                    <x-label for="ementa" value="Ementa" />
                    <x-textarea id="ementa" class="mt-1 block w-full" wire:model.defer="ementa" />
                    <x-input-error for="ementa" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="cargaHoraria" value="Carga Horária" />
                    <x-input id="cargaHoraria" type="number" class="mt-1 block w-full" wire:model.defer="cargaHoraria" />
                    <x-input-error for="cargaHoraria" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="qtdInstrutoresTitulares" value="Quantidade de Instrutores Titulares" />
                    <x-input id="qtdInstrutoresTitulares" type="number" class="mt-1 block w-full" wire:model.defer="qtdInstrutoresTitulares" />
                    <x-input-error for="qtdInstrutoresTitulares" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="qtdInstrutoresSecundarios" value="Quantidade de Instrutores Secundários" />
                    <x-input id="qtdInstrutoresSecundarios" type="number" class="mt-1 block w-full" wire:model.defer="qtdInstrutoresSecundarios" />
                    <x-input-error for="qtdInstrutoresSecundarios" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="conteudistaId" value="Conteudista" />
                    <x-select id="conteudistaId" class="mt-1 block w-full" wire:model.defer="conteudistaId">
                        <option value="">Selecione um Conteudista</option>
                        @foreach($conteudistas as $conteudista)
                            <option value="{{ $conteudista->id }}">{{ $conteudista->posto_graduacao}} {{ $conteudista->pessoa->nome }}</option>
                        @endforeach
                    </x-select>
                    <x-input-error for="conteudistaId" class="mt-2" />
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
        <x-form-section submit="{{ $isEditMaterial ? 'updateMaterial' : 'saveMaterial' }}">
            <x-slot name="title">
                {{ $isEditMaterial ? 'Editar Custo' : 'Adicionar Custo' }}
            </x-slot>
            <x-slot name="description">
                {{ $isEditMaterial ? 'Edite os custos por Turma.' : 'Preencha os custos por turma.' }}
            </x-slot>
            <x-slot name="form">
                <x-input type="hidden" id="projetoID" wire:model="projetoId" />
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="tipoMaterialId" value="Tipo de Custo" />
                    <x-select id="tipoMaterialId" type="text" class="mt-1 block w-full" wire:model.defer="tipoMaterialId">
                        <option>Selecione um dos Tipos de Custo</option>
                        @foreach($tiposMateriais as $tipo)
                        <option value="{{ $tipo->id }}">{{ $tipo->descricao }}</option>
                        @endforeach
                    </x-select>
                    <x-input-error for="tipoMaterialId" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="quantidadePorTurma" value="Quantidade Por Turma" />
                    <x-input id="quantidadePorTurma" type="text" class="mt-1 block w-full" wire:model.defer="quantidadePorTurma" />
                    <x-input-error for="quantidadePorTurma" class="mt-2" />
                </div>
            </x-slot>
            <x-slot name="actions">
                <x-button wire:click="$set('openModalMaterial', false)">
                    Cancelar
                </x-button>
                <x-button class="ml-3" type="submit">
                    {{ $isEditMaterial ? 'Atualizar' : 'Salvar' }}
                </x-button>
            </x-slot>
        </x-form-section>
     </x-modal>
     <!-- Fim do Modal de Cadastro/Edicação de Material -->
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
    <!-- Modal de Cadastro de Parecer Técnico -->
    <x-modal wire:model="openModalParecer">
        <x-form-section submit="{{ $isEditParecer ? 'updateParecer' : 'saveParecer' }}">
            <x-slot name="title">
                {{ $isEditParecer ? 'Editar Parecer' : 'Adicionar Parecer' }}
            </x-slot>
            <x-slot name="description">
                {{ $isEditParecer ? 'Edite o Parecer Técnico da Turma.' : 'Preencha os dados do Parecer Técnico da turma.' }}
            </x-slot>
            <x-slot name="form">
                <x-input type="hidden" id="projetoID" wire:model="projetoId" />
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="numero" value="Número do PT" />
                    <x-input id="numero" type="text" class="mt-1 block w-full" wire:model.defer="numero" />
                    <x-input-error for="numero" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="validade" value="Validade" />
                    <x-input id="validade" type="date" class="mt-1 block w-full" wire:model.defer="validade" />
                    <x-input-error for="validade" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="protocoloEletronico" value="Número do Protocolo Eletrônico" />
                    <x-input id="protocoloEletronico" type="text" class="mt-1 block w-full" wire:model.defer="protocoloEletronico"  />
                    <x-input-error for="protocoloEletronico" class="mt-2" />
                </div>
            </x-slot>
            <x-slot name="actions">
                <x-secondary-button wire:click="$set('openModalParecer', false)">
                    Cancelar
                </x-secondary-button>
                <x-button class="ml-3" type="submit">
                    {{ $isEditParecer ? 'Atualizar' : 'Salvar' }}
                </x-button>
            </x-slot>
        </x-form-section>
     </x-modal>
    <!-- Fim do Modal de Cadastro de Parecer Técnico -->
</div>
