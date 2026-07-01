<div class="p-6">
    <!-- Tabela de Acesso -->
    <div>
        <div class="container mx-auto px-4 mt-8 mb-2 flex flex-col lg:flex-row gap-6">
            <div class="lg:w-1/2 w-full flex flex-col">
                <h1 class="text-lg font-semibold uppercase">Perfil de Usuário</h1>
                <h4 class="text-sm mb-2">Lista do Perfil dos Usuários com Acesso ao Sistema</h4>
            </div>
            <div class="lg:w-1/2 w-full items-end justify-end flex p-2">
                <x-button wire:click="createAcesso">
                    Atribuir Perfil
                </x-button>
            </div>
        </div>
        <x-table>
            <x-slot name="theaders">
                <th class="p-3">Usuário</th>
                <th class="p-3">Perfil</th>
                <th class="p-3">Ações</th>
            </x-slot>
            <x-slot name="tbody">
               @foreach($perfisUsuarios as $perfilUsuario)
                <tr  class="{{$loop->even ? 'bg-blue-100' : 'bg-white' }} transition">
                    <td class="p-3 text-center">{{ $perfilUsuario->user->name }}</td>
                    <td class="p-3 text-center">{{ $perfilUsuario->perfil->descricao }}</td>
                    <td class="text-center">
                        <button wire:click="deletePerfilUsuario({{ $perfilUsuario->id }})" wire:confirm="Você tem certeza que deseja apagar esse perfil?" class="ml-2 text-red-600">Apagar</button>
                    </td>
                </tr>
               @endforeach
            </x-slot>
        </x-table>
    </div>
    <!-- Fim da Tabela de Acesso -->
    <!-- Modal de Cadastro de Acesso -->
     <x-modal wire:model="openModalPerfilUsuario">
        <x-form-section submit="savePerfilUsuario">
            <x-slot name="title">
                Novo Perfil de Usuário
            </x-slot>
            <x-slot name="description">
                Preencha os detalhes do novo perfil de usuário.
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
                    <x-label for="user_id" value="Usuário" />
                    <x-select id="user_id" class="mt-1 block w-full" wire:model.defer="user_id">
                        <option value="">Selecione um usuário</option>
                        @foreach($usuarios as $usuario)
                            <option value="{{ $usuario->id }}">{{ $usuario->name }}</option>
                        @endforeach
                    </x-select>
                    <x-input-error for="user_id" class="mt-2" />
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