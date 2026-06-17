<div class="p-6">
    <x-button wire:click="createCurso">Novo Curso</x-button>
    
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
                <tr class="{{$loop->even ? 'bg-blue-50' : 'bg-white' }} hover:bg-blue-100 transition">
                    <td class="p-3 cursor-pointer" wire:click="toggle({{ $curso->id }})">{{ $curso->nome }}</td>
                    <td class="text-center">{{ $curso->sigla }}</td>
                    <td class="text-center">{{ $curso->processo_eletronico }}</td>
                    <td class="text-center">{{ $curso->projetos->filter(fn($p) => $p->turmas()->whereNull('data_fim')->exists())->sum('quantidade_turmas') }}</td>
                    <td class="text-center">{{ $curso->projetos->filter(fn($p) => $p->turmas()->whereNull('data_fim')->exists())->count() }}</td>
                    <td class="text-center">{{ $curso->projetos->filter(fn($p) => $p->turmas()->whereNotNull('data_fim')->exists())->count() }}</td>
                    <td>
                        <button wire:click="editCurso({{ $curso->id }})" class="text-blue-600">Editar</button>
                        <button wire:click="toggle({{ $curso->id }})" class="ml-2 text-green-600">
                            {{ ($expanded[$curso->id] ?? false) ? 'Fechar' : 'Detalhes' }}
                        </button>
                    </td>
                </tr>
                <!-- Relação dos projetos por curso -->
                @if($expanded[$curso->id] ?? false)
                    <tr>
                        <td colspan="7" class="{{$loop->even ? 'bg-blue-50' : 'bg-white' }} hover:bg-blue-100 p-4">
                        <button wire:model="openModalProjeto" wire:click="createProjeto({{ $curso->id }})" class="mb-4 text-green-600">Novo Projeto</button>
                            <h4 class="font-bold">Projetos em andamento</h4>
                            <div>
                                <table class="w-full border-collapse border border-gray-50">
                                    <tr>
                                        <th class="border border-gray-300">Projeto</th>
                                        <th class="border border-gray-300">Data de Aprovação</th>
                                        <th class="border border-gray-300">Turmas Previstas</th>
                                        <th class="border border-gray-300">Carga Horária</th>
                                        <th class="border border-gray-300">Custo Pessoal</th>
                                        <th class="border border-gray-300">Custo Material</th>
                                        <th class="border border-gray-300">Custo Serviços</th>
                                        <th class="border border-gray-300">Centro de Ensino</th>
                                        <th class="border border-gray-300">Ações</th>
                                    </tr>
                                    @foreach($curso->projetos->filter(fn($p)=>!$p->encerrado()) as $projeto)
                                        <tr>
                                            <td class="border border-gray-300">
                                                {{ $projeto->numeroProjeto() }}
                                            </td>
                                            <td class="text-center border border-gray-300">
                                                @if(!is_null($projeto->data_aprovacao))
                                                    {{ date('d/m/Y', strtotime($projeto->data_aprovacao)) }}
                                                @endif
                                            </td>
                                            <td class="text-center border border-gray-300">
                                                {{ $projeto->quantidade_turmas }}
                                            </td>
                                            <td class="text-center border border-gray-300">
                                                {{ $projeto->cargaHorariaTotal() }}
                                            </td>
                                            <td class="text-right border border-gray-300">
                                                R$ {{ number_format($projeto->custo_pessoal, 2, ',', '.') }}
                                            </td>
                                            <td class="text-right border border-gray-300">
                                                R$ {{ number_format($projeto->custo_material, 2, ',', '.') }}
                                            </td>
                                            <td class="text-right border border-gray-300">
                                                R$ {{ number_format($projeto->custo_servicos, 2, ',', '.') }}
                                            </td>
                                            <td class="text-center border border-gray-300">
                                                {{ $projeto->centroEnsino->sigla }}
                                            </td>
                                            <td class="text-center border border-gray-300">
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
                            <h4 class="font-bold mt-4">Projetos encerrados</h4>
                            <div>
                                <table class="w-full border-collapse border border-gray-50">
                                    <tr>
                                        <th class="border border-gray-300">Projeto</th>
                                        <th class="border border-gray-300">Data de Aprovação</th>
                                        <th class="border border-gray-300">Turmas Previstas</th>
                                        <th class="border border-gray-300">Custo Pessoal</th>
                                        <th class="border border-gray-300">Custo Material</th>
                                        <th class="border border-gray-300">Custo Serviços</th>
                                        <th class="border border-gray-300">Centro de Ensino</th>
                                        <th class="border border-gray-300">Ações</th>
                                    </tr>
                                    @foreach($curso->projetos->filter(fn($p)=>$p->encerrado()) as $projeto)
                                        <tr>
                                            <td>
                                                {{ $projeto->numeroProjeto() }}
                                            </td>
                                            <td class="text-center border border-gray-300">
                                                @if(!is_null($projeto->data_aprovacao))
                                                    {{ date('d/m/Y', strtotime($projeto->data_aprovacao)) }}
                                                @endif
                                            </td>
                                            <td class="text-center border border-gray-300">
                                                {{ $projeto->quantidade_turmas }}
                                            </td>
                                            <td class="text-right border border-gray-300">
                                                R$ {{ number_format($projeto->custo_pessoal, 2, ',', '.') }}
                                            </td>
                                            <td class="text-right border border-gray-300">
                                                R$ {{ number_format($projeto->custo_material, 2, ',', '.') }}
                                            </td>
                                            <td class="text-right border border-gray-300">
                                                R$ {{ number_format($projeto->custo_servicos, 2, ',', '.') }}
                                            </td>
                                            <td class="text-center border border-gray-300">
                                                {{ $projeto->centroEnsino->sigla }}
                                            </td>
                                            <td class="text-center border border-gray-300">
                                                <button wire:click="editProjeto({{ $projeto->id }})" class="text-blue-600">
                                                    Editar
                                                </button>
                                                <button wire:click="viewProjeto({{ $projeto->id }})" class="text-green-600 ml-2">
                                                    Ver Detalhes
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
                    <x-label for="custo_pessoal" value="Custo Pessoal" />
                    <x-input id="custo_pessoal" wire:model.defer="custo_pessoal" class="w-full" type="number" step="0.01" />
                    <x-input-error for="custo_pessoal" class="mt-2" />
                </div>
                <div class="col-span-6 w-full">
                    <x-label for="custo_material" value="Custo Material" />
                    <x-input id="custo_material" wire:model.defer="custo_material" class="w-full" type="number" step="0.01" />
                    <x-input-error for="custo_material" class="mt-2" />
                </div>
                <div class="col-span-6 w-full">
                    <x-label for="custo_servicos" value="Custo Serviços" />
                    <x-input id="custo_servicos" wire:model.defer="custo_servicos" class="w-full" type="number" step="0.01" />
                    <x-input-error for="custo_servicos" class="mt-2" />
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