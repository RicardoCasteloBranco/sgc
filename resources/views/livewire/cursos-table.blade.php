<div class="p-6 w-full">
    <div class="container mx-auto px-4 h-full">
        <x-button wire:click="createCurso" class="m-4">Novo Curso</x-button>
    </div>    
    <!-- Tabela de Cursos -->
    <x-table>
        <x-slot name="theaders">
            <th class="p-3 text-left">Curso</th>
            <th>Sigla</th>
            <th>Processo Eletrônico</th>
            <th>Turmas Previstas</th>
            <th>Turmas em Andamento</th>
            <th>Turmas Encerradas</th>
            <th>Ações</th> 
        </x-slot>
        <!-- Corpo da tabela Cursos -->
        <x-slot name="tbody">
            <!-- Loop de Cursos -->
            @foreach($cursos as $curso)
                <tr class="{{$loop->even ? 'bg-blue-100' : 'bg-white' }} transition" wire:key="curso-{{ $curso->id }}">
                    <td class="p-3 cursor-pointer" wire:click="toggle({{ $curso->id }})">{{ $curso->nome }}</td>
                    <td class="text-center">{{ $curso->sigla }}</td>
                    <td class="text-center">{{ $curso->processo_eletronico }}</td>
                    <td class="text-center">{{ $curso->projetos->filter(fn($p) => $p->turmas()->whereNull('data_fim')->exists())->sum('quantidade_turmas') }}</td>
                    <td class="text-center">{{ $curso->projetos->filter(fn($p) => $p->turmas()->whereNull('data_fim')->exists())->count() }}</td>
                    <td class="text-center">{{ $curso->projetos->filter(fn($p) => $p->turmas()->whereNotNull('data_fim')->exists())->count() }}</td>
                    <td class="text-center">
                        <button wire:click="editCurso({{ $curso->id }})" class="text-blue-600">Editar</button>
                        <button wire:click="toggle({{ $curso->id }})" class="ml-2 text-green-600">
                            {{ ($expanded[$curso->id] ?? false) ? 'Fechar' : 'Detalhes' }}
                        </button>
                    </td>
                </tr>
                <!-- Relação dos projetos por curso -->
                @if($expanded[$curso->id] ?? false)
                    <tr>
                        <td colspan="7" class="{{$loop->even ? 'bg-blue-100' : 'bg-white' }} p-4">
                        <x-success-button wire:model="openModalProjeto" 
                            wire:click="createProjeto({{ $curso->id }})" >Novo Projeto</x-success-button>
                            <h4 class="font-bold mt-6 mb-2">Projetos em andamento</h4>
                            <div>
                                <table class="w-full border-collapse border border-gray-50">
                                   <thead> 
                                    <tr class="bg-gray-500 text-white uppercase">
                                        <th class="border border-black p-3" rowspan="2">Projeto</th>
                                        <th class="border border-black" rowspan="2">Data de Aprovação</th>
                                        <th class="border border-black" rowspan="2">Turmas Previstas</th>
                                        <th class="border border-black" rowspan="2">Carga Horária</th>
                                        <th class="border border-black p-3" colspan="4">Custos</th>
                                        <th class="border border-black" rowspan="2">Centro de Ensino</th>
                                        <th class="border border-black" rowspan="2">Ações</th>
                                    </tr>
                                    <tr class="bg-gray-500 text-white uppercase">
                                        <th class="border border-black p-2">Hora-aula</th>
                                        <th class="border border-black">Serviços</th>
                                        <th class="border border-black">Bolsa Formação</th>
                                        <th class="border border-black">Material</th>
                                    <tr>
                                    </thead>
                                    <tbody>
                                    @foreach($curso->projetos->filter(fn($p)=>$p->projetoNaoEncerrado() == true) as $projeto)
                                        <tr wire:key="projeto-andamento-{{ $projeto->id }}">
                                            <td class="border border-black p-2">
                                                {{ $projeto->numeroProjeto() }}
                                            </td>
                                            <td class="text-center border border-black p-2">
                                                @if(!is_null($projeto->data_aprovacao))
                                                    {{ date('d/m/Y', strtotime($projeto->data_aprovacao)) }}
                                                @endif
                                            </td>
                                            <td class="text-center border border-black p-2">
                                                {{ $projeto->quantidade_turmas }}
                                            </td>
                                            <td class="text-center border border-black p-2">
                                                {{ $projeto->cargaHorariaTotal() }}
                                            </td>
                                            <td class="text-right border border-black p-2">
                                                R$ {{ number_format($projeto->custo_hora_aula_por_turma, 2, ',', '.') }}
                                            </td>
                                            <td class="text-right border border-black p-2">
                                                R$ {{ number_format($projeto->custo_material_por_turma, 2, ',', '.') }}
                                            </td>
                                            <td class="text-right border border-black p-2">
                                                R$ {{ number_format($projeto->custo_servicos_por_turma, 2, ',', '.') }}
                                            </td>
                                            <td class="text-right border border-black p-2">
                                                R$ {{ number_format($projeto->custoMaterial(), 2, ',', '.') }}
                                            </td>
                                            <td class="text-center border border-black p-2">
                                                {{ $projeto->centroEnsino->sigla }}
                                            </td>
                                            <td class="text-center border border-black p-2">
                                                <button wire:click="editProjeto({{ $projeto->id }})" class="text-blue-600">
                                                    Editar
                                                </button>
                                                <button wire:click="viewProjeto({{ $projeto->id }})" class="text-green-600 ml-2">
                                                    Detalhes
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <h4 class="font-bold mt-6 mb-2">Projetos encerrados</h4>
                            <div>
                                <table class="w-full border-collapse border border-gray-50">
                                    <thead> 
                                    <tr class="bg-gray-500 text-white uppercase">
                                        <th class="border border-black p-3" rowspan="2">Projeto</th>
                                        <th class="border border-black" rowspan="2">Data de Aprovação</th>
                                        <th class="border border-black" rowspan="2">Turmas Executadas</th>
                                        <th class="border border-black" rowspan="2">Carga Horária</th>
                                        <th class="border border-black p-3" colspan="4">Custos</th>
                                        <th class="border border-black" rowspan="2">Centro de Ensino</th>
                                        <th class="border border-black" rowspan="2">Ações</th>
                                    </tr>
                                    <tr class="bg-gray-500 text-white uppercase">
                                        <th class="border border-black p-2">Hora-aula</th>
                                        <th class="border border-black">Serviços</th>
                                        <th class="border border-black">Bolsa Formação</th>
                                        <th class="border border-black">Material</th>
                                    <tr>
                                    </thead>
                                    <tbody>
                                    @foreach($curso->projetos->filter(fn($p)=>$p->projetoNaoEncerrado()==false) as $projeto)
                                        <tr wire:key="projeto-encerrado-{{ $projeto->id }}">
                                            <td class="text-center border border-black p-2">
                                                {{ $projeto->numeroProjeto() }}
                                            </td>
                                            <td class="text-center border border-black p-2">
                                                @if(!is_null($projeto->data_aprovacao))
                                                    {{ date('d/m/Y', strtotime($projeto->data_aprovacao)) }}
                                                @endif
                                            </td>
                                            <td class="text-center border border-black p-2">
                                                {{ $projeto->quantidade_turmas }}
                                            </td>
                                            <td class="text-center border border-black p-2">
                                                {{ $projeto->cargaHorariaTotal() }}
                                            </td>
                                            <td class="text-right border border-black p-2">
                                                R$ {{ number_format($projeto->custo_hora_aula_por_turma, 2, ',', '.') }}
                                            </td>
                                            <td class="text-right border border-black p-2">
                                                R$ {{ number_format($projeto->custo_servico_por_turma, 2, ',', '.') }}
                                            </td>
                                            <td class="text-right border border-black p-2">
                                                R$ {{ number_format($projeto->custo_bolsa_formacao_por_turma, 2, ',', '.') }}
                                            </td>
                                            <td class="text-right border border-black p-2">
                                                R$ {{ number_format($projeto->custoMaterial(), 2, ',', '.') }}
                                            </td>
                                            <td class="text-center border border-black p-2">
                                                {{ $projeto->centroEnsino->sigla }}
                                            </td>
                                            <td class="text-center border border-black p-2">
                                                <button wire:click="editProjeto({{ $projeto->id }})" class="text-blue-600">
                                                    Editar
                                                </button>
                                                <button wire:click="viewProjeto({{ $projeto->id }})" class="text-green-600 ml-2">
                                                    Detalhes
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </td>
                    </tr>

                @endif
                <!-- Fim da relação dos projetos por curso -->
            @endforeach
            <!-- Fim do loop de Cursos -->
        </x-slot>
        <!-- Fim do Corpo da tabela Cursos -->
    </x-table>
    <!-- Fim da Tabela de Cursos -->
    <!-- Modal para criação de cursos -->
    <x-modal maxWidth="xl" wire:model="openModalCurso">
        <x-form-section submit="{{ $isEditCurso ? 'updateCurso' : 'saveCurso' }}">
            <x-slot name="title">
                {{ $isEditCurso ? 'Editar Curso' : 'Criar Novo Curso' }}
            </x-slot>
            <x-slot name="description">
                {{ $isEditCurso ? 'Edite os dados do curso' : 'Preencha os dados para criar um novo curso' }}
            </x-slot>
            <x-slot name="form">
                <div class="col-span-6 w-full">
                    <x-label for="nome" value="Nome do Curso" />
                    <x-input id="nome" wire:model.defer="nome" class="w-full" type="text" />
                    <x-input-error for="nome" class="mt-2" />
                </div>
                <div class="col-span-6 w-full">
                    <x-label for="sigla" value="Sigla do Curso" />
                    <x-input id="sigla" wire:model.defer="sigla" class="w-full" type="text" />
                    <x-input-error for="sigla" class="mt-2" />
                </div>
                <div class="col-span-6 w-full">
                    <x-label for="processo_eletronico" value="Processo Eletrônico" />
                    <x-input id="processo_eletronico" wire:model.defer="processo_eletronico" class="w-full" type="text" />
                    <x-input-error for="processo_eletronico" class="mt-2" />
                </div>
                <div class="col-span-6 w-full">
                    <x-label for="objetivo_geral" value="Objetivo Geral" />
                    <x-input id="objetivo_geral" wire:model.defer="objetivo_geral" class="w-full" type="text" />
                    <x-input-error for="objetivo_geral" class="mt-2" />
                </div>
                <div class="col-span-6 w-full">
                    <x-label for="objetivos_especificos" value="Objetivos Específicos" />
                    <x-textarea id="objetivos_especificos" wire:model.defer="objetivos_especificos" class="w-full" type="text" />
                    <x-input-error for="objetivos_especificos" class="mt-2" />
                </div>
                <div class="col-span-6 w-full">
                    <x-label for="publico_alvo" value="Público Alvo" />
                    <x-input id="publico_alvo" wire:model.defer="publico_alvo" class="w-full" type="text" />
                    <x-input-error for="publico_alvo" class="mt-2" />
                </div>
            </x-slot>
            <x-slot name="actions">
                <x-button type="submit">
                    {{ $isEditCurso ? 'Atualizar' : 'Criar' }}
                </x-button>
                @if ($isEditCurso)
                    <x-secondary-button type="reset" wire:click="$set('openModalCurso', false)">Cancelar</x-secondary-button>
                @endif
            </x-slot>
        </x-form-section>
    </x-modal>
    <!-- Fim do modal para criação de cursos -->
    <!-- Modal para criação de projetos -->
    <x-modal maxWidth="xl" wire:model="openModalProjeto">
        <x-form-section submit="{{ $isEditProjeto ? 'updateProjeto' : 'saveProjeto' }}">
            <x-slot name="title">
                {{ $isEditProjeto ? 'Editar Projeto' : 'Criar Novo Projeto' }}
            </x-slot>
            <x-slot name="description">
                {{ $isEditProjeto ? 'Edite os dados do projeto' : 'Preencha os dados para criar um novo projeto' }}
            </x-slot>
            <x-slot name="form">
                <x-input type="hidden" id="curso_id" wire:model.defer="curso_id" />
                <x-input type="hidden" id="projetoId" wire:model.defer="projetoId" />
                <div class="col-span-6 w-full">
                    <x-label for="data_aprovacao" value="Data de Aprovação" />
                    <x-input id="data_aprovacao" wire:model.defer="data_aprovacao" class="w-full" type="date" />
                    <x-input-error for="data_aprovacao" class="mt-2" />
                </div>
                <div class="col-span-6 w-full">
                    <x-label for="quantidade_turmas" value="Quantidade de Turmas" />
                    <x-input id="quantidade_turmas" wire:model.defer="quantidade_turmas" class="w-full" type="number" />
                    <x-input-error for="quantidade_turmas" class="mt-2" />
                </div>
                <div class="col-span-6 w-full">
                    <x-label for="custo_hora_aula_por_turma" value="Custo com Hora-aula por Turma" />
                    <x-input id="custo_hora_aula_por_turma" wire:model.defer="custo_hora_aula_por_turma" class="w-full" type="number" step="0.01" />
                    <x-input-error for="custo_hora_aula_por_turma" class="mt-2" />
                </div>
                <div class="col-span-6 w-full">
                    <x-label for="custo_bolsa_formacao_por_turma" value="Custo com Bolsa de Formação por Turma" />
                    <x-input id="custo_bolsa_formacao_por_turma" wire:model.defer="custo_bolsa_formacao_por_turma" class="w-full" type="number" step="0.01" />
                    <x-input-error for="custo_bolsa_formacao_por_turma" class="mt-2" />
                </div>
                <div class="col-span-6 w-full">
                    <x-label for="custo_servico_por_turma" value="Custo com Serviços por Turma" />
                    <x-input id="custo_servico_por_turma" wire:model.defer="custo_servico_por_turma" class="w-full" type="number" step="0.01" />
                    <x-input-error for="custo_servico_por_turma" class="mt-2" />
                </div>
                <div class="col-span-6 w-full">
                    <x-label for="centro_ensino_id" value="Centro de Ensino" />
                    <select id="centro_ensino_id" wire:model.defer="centro_ensino_id" class="w-full">
                        <option value="">Selecione um centro de ensino</option>
                        @foreach ($centrosEnsino as $centro)
                            <option value="{{ $centro->id }}">{{ $centro->nome }}</option>
                        @endforeach
                    </select>
                    <x-input-error for="centro_ensino_id" class="mt-2" />
                </div>
            </x-slot>
            <x-slot name="actions">
                <x-button type="submit">
                    {{ $isEditProjeto ? 'Atualizar' : 'Criar' }}
                </x-button>
                @if ($isEditProjeto)
                    <x-secondary-button type="reset" wire:click="$set('openModalProjeto', false)">Cancelar</x-secondary-button>
                @endif
            </x-slot>
        </x-form-section>
    </x-modal>
    <!-- Fim do modal para criação de projetos -->
</div>