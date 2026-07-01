<div class="p-6">
    <div class="w-full">
        <div class="flex flex-col lg:flex-row gap-6 items-stretch h-auto">
            <div class="w-full lg:w-1/2 bg-white text-black shadow p-5 rounded-lg">
                <div class="ml-4">
                    <h1 class="ml-4 text-lg font-semibold uppercase">Perfil</h1>
                    <h4 class="ml-4 mb-4 text-sm">Perfis de Acesso ao Sistema</h4>
                    <!-- Tabela de Perfil -->
                    <x-table>
                        <x-slot name="theaders">
                            <th class="p-3">Descrição</th>
                            <th class="p-3">Ações</th>
                        </x-slot>
                        <x-slot name="tbody">
                            @foreach($perfis as $perfil)
                            <tr  class="{{$loop->even ? 'bg-blue-100' : 'bg-white' }} transition">
                                <td>{{ $perfil->descricao }}</td>
                                <td class="text-center">
                                    <button wire:click="editPerfil({{ $perfil->id }})" class="text-blue-600">Editar</button>
                                    <button wire:click="deletePerfil({{ $perfil->id }})" wire:confirm="Você tem certeza que deseja apagar esse perfil?" class="ml-2 text-red-600">Apagar</button>
                                </td>
                            </tr>
                            @endforeach
                        </x-slot>
                    </x-table>
                </div>
                <div class="m-4 px-1">
                    <x-button wire:click="createPerfil">
                        Novo Perfil
                    </x-button>
                </div>
            </div>
            <div class="w-full lg:w-1/2 bg-white p-5 rounded-lg shadow flex flex-col">
                <!-- Tabela de Menu -->
                <div class="flex-1 overflow-y-auto mt-4">
                    <h1 class="ml-4 text-lg font-semibold uppercase">Menu</h1>
                    <h4 class="ml-4 mb-4 text-sm">Lista de Menus do Sistema</h4>
                    <x-table>
                        <x-slot name="theaders">
                            <th class="p-3">Título</th>
                            <th class="p-3">Rota</th>
                            <th class="p-3">Ação</th>
                        </x-slot>
                        <x-slot name="tbody">
                           @foreach($menus as $menu)
                            <tr  class="{{$loop->even ? 'bg-blue-100' : 'bg-white' }} transition">
                                <td>{{ $menu->titulo }}</td>
                                <td>{{ $menu->rota }}</td>
                                <td class="text-center">
                                    <button wire:click="editMenu({{ $menu->id }})" class="text-blue-600">Editar</button>
                                    <button wire:click="deleteMenu({{ $menu->id }})" wire:confirm="Você tem certeza que deseja apagar esse menu?" class="ml-2 text-red-600">Apagar</button>
                                </td>
                            </tr>
                           @endforeach
                        </x-slot>
                    </x-table>
                    <!-- Fim da Tabela de Menu -->
                </div>
                <div class="m-4 px-1">
                    <x-button wire:click="createMenu">
                        Novo Menu
                    </x-button>
                </div>
            </div>
        </div>
    </div>
    <!-- Tabela de Acesso -->
    <div>
        <div class="container mx-auto px-4 mt-8 mb-2 flex flex-col lg:flex-row gap-6">
            <div class="lg:w-1/2 w-full flex flex-col">
                <h1 class="text-lg font-semibold uppercase">Perfil de Acesso</h1>
                <h4 class="text-sm mb-2">Lista de Perfis com Acesso aos Menus do Sistema</h4>
            </div>
            <div class="lg:w-1/2 w-full items-end justify-end flex p-2">
                <x-button wire:click="createAcesso">
                    Criar Acesso
                </x-button>
            </div>
        </div>
        <x-table>
            <x-slot name="theaders">
                <th class="p-3">Perfil</th>
                <th class="p-3">Menu</th>
                <th class="p-3">Ações</th>
            </x-slot>
            <x-slot name="tbody">
               @foreach($acessos as $acesso)
                <tr  class="{{$loop->even ? 'bg-blue-100' : 'bg-white' }} transition">
                    <td>{{ $acesso->perfil->descricao }}</td>
                    <td>{{ $acesso->menu->titulo }}</td>
                    <td class="text-center">
                        <button wire:click="deleteAcesso({{ $acesso->id }})" wire:confirm="Você tem certeza que deseja apagar esse acesso?" class="ml-2 text-red-600">Apagar</button>
                    </td>
                </tr>
               @endforeach
            </x-slot>
        </x-table>
    </div>
    <!-- Fim da Tabela de Turmas -->
    <!-- Modal de Cadastro/Edicação de Perfil -->
     <x-modal wire:model="openModalPerfil">
        <x-form-section submit=" {{ $isEditPerfil ? 'updatePerfil' : 'savePerfil' }}">
            <x-slot name="title">
                {{ $isEditPerfil ? 'Editar Perfil' : 'Novo Perfil' }}
            </x-slot>
            <x-slot name="description">
                {{ $isEditPerfil ? 'Edite os detalhes do Perfil.' : 'Preencha os detalhes do novo perfil.' }}
            </x-slot>
            <x-slot name="form">
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="descricao" value="Descrição" />
                    <x-input id="descricao" type="text" class="mt-1 block w-full" wire:model.defer="descricao" />
                    <x-input-error for="descricao" class="mt-2" />
                </div>
            </x-slot>
            <x-slot name="actions">
                <x-secondary-button wire:click="$set('openModalPerfil', false)">
                    Cancelar
                </x-secondary-button>
                <x-button class="ml-3" type="submit">
                    {{ $isEditPerfil ? 'Atualizar' : 'Salvar' }}
                </x-button>
            </x-slot>
        </x-form-section>
     </x-modal>
     <!-- Fim do Modal de Cadastro/Edição de Perfil -->
    <!-- Modal de Cadastro/Edicação de Menu -->
     <x-modal wire:model="openModalMenu">
        <x-form-section submit=" {{ $isEditMenu ? 'updateMenu' : 'saveMenu' }}">
            <x-slot name="title">
                {{ $isEditMenu ? 'Editar Menu' : 'Novo Menu' }}
            </x-slot>
            <x-slot name="description">
                {{ $isEditMenu ? 'Edite os detalhes do Menu.' : 'Preencha os detalhes do novo menu.' }}
            </x-slot>
            <x-slot name="form">
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="titulo" value="Título" />
                    <x-input id="titulo" type="text" class="mt-1 block w-full" wire:model.defer="titulo" />
                    <x-input-error for="titulo" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="rota" value="Rota" />
                    <x-input id="rota" type="text" class="mt-1 block w-full" wire:model.defer="rota" />
                    <x-input-error for="rota" class="mt-2" />
                </div>
            </x-slot>
            <x-slot name="actions">
                <x-secondary-button wire:click="$set('openModalMenu', false)">
                    Cancelar
                </x-secondary-button>
                <x-button class="ml-3" type="submit">
                    {{ $isEditMenu ? 'Atualizar' : 'Salvar' }}
                </x-button>
            </x-slot>
        </x-form-section>
     </x-modal>
     <!-- Fim do Modal de Cadastro/Edição de Menu -->
    <!-- Modal de Cadastro de Acesso -->
     <x-modal wire:model="openModalAcesso">
        <x-form-section submit="saveAcesso">
            <x-slot name="title">
                Novo Acesso
            </x-slot>
            <x-slot name="description">
                Preencha os detalhes do novo acesso.
            </x-slot>
            <x-slot name="form">
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="perfil_id" value="Perfil" />
                    <x-select id="perfil_id" class="mt-1 block w-full" wire:model.defer="perfil_id">
                        <option value="">Selecione um perfil</option>
                        @foreach($perfis as $perfil)
                            <option value="{{ $perfil->id }}">{{ $perfil->descricao }}</option>
                        @endforeach
                    </x-select>
                    <x-input-error for="perfil_id" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="menu_id" value="Menu" />
                    <x-select id="menu_id" class="mt-1 block w-full" wire:model.defer="menu_id">
                        <option value="">Selecione um menu</option>
                        @foreach($menus as $menu)
                            <option value="{{ $menu->id }}">{{ $menu->titulo }}</option>
                        @endforeach
                    </x-select>
                    <x-input-error for="menu_id" class="mt-2" />
                </div>
            </x-slot>
            <x-slot name="actions">
                <x-secondary-button wire:click="$set('openModalAcesso', false)">
                    Cancelar
                </x-secondary-button>
                <x-button class="ml-3" type="submit">
                    Salvar
                </x-button>
            </x-slot>
        </x-form-section>
     </x-modal>
     <!-- Fim do Modal de Cadastro de Acesso -->
</div>