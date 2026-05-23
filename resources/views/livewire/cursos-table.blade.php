<div class="p-6">
    <x-button wire:click="createCurso">Novo Curso</x-button>
    
    <!-- Tabela de Cursos -->
    <x-table>
        <x-slot name="theaders">
            <th class="p-3 text-left">Curso</th>
            <th>Sigla</th>
            <th>Projetos em Andamento</th>
            <th>Projetos Encerrados</th>
            <th>Ações</th> 
        </x-slot>
        <!-- Corpo da tabela Cursos -->
        <x-slot name="tbody">
            <!-- Loop de Cursos -->
            @foreach($cursos as $curso)
                <tr>
                    <td class="p-3 cursor-pointer" wire:click="toggle({{ $curso->id }})">{{ $curso->nome }}</td>
                    <td class="text-center">{{ $curso->sigla }}</td>
                    <td class="text-center">{{ $curso->projetos->filter(fn($p)=>!$p->encerrado())->count() }}</td>
                    <td class="text-center">{{ $curso->projetos->filter(fn($p)=>$p->encerrado())->count() }}</td>
                    <td>
                        <x-secondary-button wire:click="editCurso({{ $curso->id }})">Editar Curso</x-secondary-button>
                    </td>
                </tr>
                <!-- Relação dos projetos por curso -->
                @if($expanded[$curso->id] ?? false)
                    <tr>
                        <td colspan="3" class="bg-gray-50 p-4">
                        <button wire:model="openModalProjeto" wire:click="createProjeto" class="mb-4 text-green-600">Novo Projeto</button>
                            <h4 class="font-bold">Projetos em andamento</h4>
                            <div>
                                <table class="w-full">
                                    <tr>
                                        <th>Projeto</th>
                                        <th>Data de Aprovação</th>
                                        <th>Ações</th>
                                    </tr>
                                    @foreach($curso->projetos->filter(fn($p)=>!$p->encerrado()) as $projeto)
                                        <tr>
                                            <td>
                                                Projeto #{{ $projeto->id }}
                                            </td>
                                            <td>
                                                @if(!is_null($projeto->data_aprovacao))
                                                    {{ $projeto->data_aprovacao->format('d/m/Y') }}
                                                @endif
                                            </td>
                                            <td>
                                                <button wire:click="editProjeto({{ $projeto->id }})" class="text-blue-600">
                                                    Editar
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                            <h4 class="font-bold mt-4">Projetos encerrados</h4>
                            <div>
                                <table class="w-full">
                                    <tr>
                                        <th>Projeto</th>
                                        <th>Data de Aprovação</th>
                                        <th>Ações</th>
                                    </tr>
                                    @foreach($curso->projetos->filter(fn($p)=>$p->encerrado()) as $projeto)
                                        <tr>
                                            <td>
                                                Projeto #{{ $projeto->id }}
                                            </td>
                                            <td>
                                                @if(!is_null($projeto->data_aprovacao))
                                                    {{ $projeto->data_aprovacao->format('d/m/Y') }}
                                                @endif
                                            </td>
                                            <td>
                                                <button wire:click="editProjeto({{ $projeto->id }})"
                                                    class="text-blue-600">
                                                    Editar
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
                <div class="col-span-6 w-full">
                    <x-label for="data_aprovacao" value="Data de Aprovação" />
                    <x-input id="data_aprovacao" wire:model.defer="data_aprovacao" class="w-full" type="date" />
                    <x-input-error for="data_aprovacao" class="mt-2" />
                </div>
                <div class="col-span-6 w-full">
                    <x-label for="parecer_tecnico" value="Parecer Técnico" />
                    <x-input id="parecer_tecnico" wire:model.defer="parecer_tecnico" class="w-full" type="text" />
                    <x-input-error for="parecer_tecnico" class="mt-2" />
                </div>
                <div class="col-span-6 w-full">
                    <x-label for="quantidade_turmas" value="Quantidade de Turmas" />
                    <x-input id="quantidade_turmas" wire:model.defer="quantidade_turmas" class="w-full" type="number" />
                    <x-input-error for="quantidade_turmas" class="mt-2" />
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