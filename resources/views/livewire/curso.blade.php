<div>
    <h1 class="text-2xl font-bold mb-4">Cursos</h1>
    <!-- Botão para criar novo centro de ensino -->
    <div class="flex justify-end mb-4">
        <x-button wire:click="create">Criar Novo Curso</x-button>
    </div>

    <!-- Tabela de centros de ensino -->
    <x-table>
        <x-slot name="theaders">
            <x-table.heading>Nome</x-table.heading>
            <x-table.heading>Público Alvo</x-table.heading>
            <x-table.heading>Objetivo Geral</x-table.heading>
            <x-table.heading>Objetivos Específicos</x-table.heading>
            <x-table.heading>Ações</x-table.heading>
        </x-slot>
        <x-slot name="tbody">
            @foreach($cursos as $curso)
                <x-table.row>
                    <x-table.cell>{{ $curso->nome }}</x-table.cell>
                    <x-table.cell>{{ $curso->publico_alvo }}</x-table.cell>
                    <x-table.cell>{{ $curso->objetivo_geral }}</x-table.cell>
                    <x-table.cell>{{ $curso->objetivos_especificos }}</x-table.cell>
                    <x-table.cell>
                        <x-secondary-button wire:click="edit({{ $curso->id }})">Editar</x-secondary-button>
                        <x-danger-button wire:click="delete({{ $curso->id }})">Excluir</x-danger-button>
                    </x-table.cell>
                </x-table.row>
            @endforeach
        </x-slot>
    </x-table>
    
    <!-- Modal para criar/editar curso -->
    <x-modal maxWidth="xl" wire:model="isOpenModal">
        <x-form-section submit="{{ $isEditMode? 'update' : 'store'}}" >
            <x-slot name="title">
                {{ $isEditMode? 'Editar Curso' : 'Criar Novo Curso'}}
            </x-slot>
            <x-slot name="description">
                {{ $isEditMode? 'Edite os dados do curso' : 'Preencha os dados para criar um novo curso'}}
            </x-slot>
            <x-slot name="form">
                <div class="col-span-6 w-full">
                    <x-label for="nome" value="Nome" />
                    <x-input id="nome" type="text" wire:model.defer="nome" class="w-full" />
                    <x-input-error for="nome" class="mt-2" />
                </div>
                <div class="col-span-6 w-full">
                    <x-label for="objetivo_geral" value="Objetivo Geral" />
                    <x-textarea id="objetivo_geral" wire:model.defer="objetivo_geral" class="w-full" />
                    <x-input-error for="objetivo_geral" class="mt-2" />
                </div>
                <div class="col-span-6 w-full">
                    <x-label for="objetivos_especificos" value="Objetivos Específicos" />
                    <x-textarea id="objetivos_especificos" wire:model.defer="objetivos_especificos" class="w-full" />
                    <x-input-error for="objetivos_especificos" class="mt-2" />
                </div>
                <div class="col-span-6 w-full">
                    <x-label for="publico_alvo" value="Público Alvo" />
                    <x-textarea id="publico_alvo" wire:model.defer="publico_alvo" class="w-full" />
                    <x-input-error for="publico_alvo" class="mt-2" />
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