<div>
    <h1 class="text-2xl font-bold mb-4">Supervisores</h1>
    <!-- Botão para criar novo centro de ensino -->
    <div class="flex justify-end mb-4">
        <x-button wire:click="create">Atribuir Supervisor ao Centro</x-button>
    </div>

    <!-- Tabela de centros de ensino -->
    <x-table>
        <x-slot name="theaders">
            <x-table.heading>Supervisor</x-table.heading>
            <x-table.heading>Centro</x-table.heading>
            <x-table.heading>Ações</x-table.heading>
        </x-slot>
        <x-slot name="tbody">
            @foreach($supervisores as $supervisor)
                <x-table.row>
                    <x-table.cell>{{ $supervisor->user->name }}</x-table.cell>
                    <x-table.cell>{{ $supervisor->centroEnsino->sigla }}</x-table.cell>
                    <x-table.cell>
                        <x-secondary-button wire:click="edit({{ $supervisor->id }})">Editar</x-secondary-button>
                        <x-danger-button wire:click="delete({{ $supervisor->id }})">Excluir</x-danger-button>
                    </x-table.cell>
                </x-table.row>
            @endforeach
        </x-slot>
    </x-table>
    
    <!-- Modal para criar/editar centro de ensino -->
    <x-modal maxWidth="xl" wire:model="isOpenModal">
        <x-form-section submit="{{ $isEditMode? 'update' : 'store'}}">
            <x-slot name="title">
                {{ $isEditMode? 'Editar Supervisor' : 'Atribuir Supervisor ao Centro'}}
            </x-slot>
            <x-slot name="description">
                {{ $isEditMode? 'Edite os dados do supervisor' : 'Preencha os dados para atribuir um supervisor ao centro de ensino'}}
            </x-slot>
            <x-slot name="form">
                <div class="col-span-6">
                    <x-label for="centro_ensino_id" value="Centro de Ensino" />
                    <x-select id="centro_ensino_id" wire:model.defer="centro_ensino_id" class="w-full">
                        <option value="">Nenhum</option>
                        @foreach ($centros as $centroOption)
                            <option value="{{ $centroOption->id }}">{{ $centroOption->nome }}</option>
                        @endforeach
                    </x-select>
                    <x-input-error for="centro_ensino_id" class="mt-2" />
                </div>
                <div class="col-span-6">
                    <x-label for="user_id" value="Supervisor" />
                    <x-select id="user_id" wire:model.defer="user_id" class="w-full">
                        <option value="">Nenhum</option>
                        @foreach ($users as $userOption)
                            <option value="{{ $userOption->id }}">{{ $userOption->name }}</option>
                        @endforeach
                    </x-select>
                    <x-input-error for="user_id" class="mt-2" />
                </div>
                <x-slot name="actions">
                    <x-button type="submit">
                        {{ $isEditMode? 'Atualizar' : 'Criar'}}
                    </x-button>
                    @if ($isEditMode)
                        <x-secondary-button type="reset" wire:click="closeModal">Cancelar</x-secondary-button>
                    @endif
                </x-slot>
            </x-slot>
        </x-form-section>
    </x-modal>
</div>