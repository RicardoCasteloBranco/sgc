<div>
    <h1 class="text-2xl font-bold mb-4">Centros de Ensino</h1>
    <!-- Botão para criar novo centro de ensino -->
    <div class="flex justify-end mb-4">
        <x-button wire:click="create">Criar Centro de Ensino</x-button>
    </div>

    <!-- Tabela de centros de ensino -->
    <x-table>
        <x-slot name="theaders">
            <x-table.heading>Nome</x-table.heading>
            <x-table.heading>Sigla</x-table.heading>
            <x-table.heading>Unidade Pai </x-table.heading>
            <x-table.heading>Ações</x-table.heading>
        </x-slot>
        <x-slot name="tbody">
            @foreach($centros as $centro)
                <x-table.row>
                    <x-table.cell>{{ $centro->nome }}</x-table.cell>
                    <x-table.cell>{{ $centro->sigla }}</x-table.cell>
                    <x-table.cell>{{ $centro->centroEnsino?->nome ?? 'Nenhuma' }}</x-table.cell>
                    <x-table.cell>
                        <x-secondary-button wire:click="edit({{ $centro->id }})">Editar</x-secondary-button>
                        <x-danger-button wire:click="delete({{ $centro->id }})">Excluir</x-danger-button>
                    </x-table.cell>
                </x-table.row>
            @endforeach
        </x-slot>
    </x-table>
    
    <!-- Modal para criar/editar centro de ensino -->
    <x-modal maxWidth="xl" wire:model="isOpenModal">
        <x-form-section submit="{{ $isEditMode? 'update' : 'store'}}">
            <x-slot name="title">
                {{ $isEditMode? 'Editar Centro de Ensino' : 'Criar Centro de Ensino'}}
            </x-slot>
            <x-slot name="description">
                {{ $isEditMode? 'Edite os dados do centro de ensino' : 'Preencha os dados para criar um novo centro de ensino'}}
            </x-slot>
            <x-slot name="form">
                <div class="col-span-6">
                    <x-label for="nome" value="Nome" />
                    <x-input id="nome" type="text" class="mt-1 block w-full" wire:model.defer="nome" />
                    <x-input-error for="nome" class="mt-2" />
                </div>
                <div class="col-span-6">
                    <x-label for="sigla" value="Sigla" />
                    <x-input id="sigla" type="text" class="mt-1 block w-full" wire:model.defer="sigla" />
                    <x-input-error for="sigla" class="mt-2" />
                </div>
                <div class="col-span-6">
                    <x-label for="centro_ensino_id" value="Centro de Ensino Pai" />
                    <x-select id="centro_ensino_id" wire:model.defer="centro_ensino_id" class="mt-1 block w-full">
                        <option value="">Nenhum</option>
                        @foreach ($centros as $centroOption)
                            <option value="{{ $centroOption->id }}">{{ $centroOption->nome }}</option>
                        @endforeach
                    </x-select>
                    <x-input-error for="centro_ensino_id" class="mt-2" />
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