<div>
    <h1 class="text-2xl font-bold mb-4">Projetos</h1>
    <!-- Botão para inserir novo projeto -->
    <div class="flex justify-end mb-4">
        <x-button wire:click="create">Criar Novo Projeto</x-button>
    </div>

    <!-- Tabela de projetos -->
    <x-table>
        <x-slot name="theaders">
            <x-table.heading>Curso</x-table.heading>
            <x-table.heading>Público Alvo</x-table.heading>
            <x-table.heading>Objetivo Geral</x-table.heading>
            <x-table.heading>Objetivos Específicos</x-table.heading>
            <x-table.heading>Ano</x-table.heading>
            <x-table.heading>Ações</x-table.heading>
        </x-slot>
        <x-slot name="tbody">
            @foreach($projetos as $projeto)
                <x-table.row>
                    <x-table.cell>{{ $projeto->curso->nome ?? '' }}</x-table.cell>
                    <x-table.cell>{{ $projeto->curso->publico_alvo ?? '' }}</x-table.cell>
                    <x-table.cell>{{ $projeto->curso->objetivo_geral ?? '' }}</x-table.cell>
                    <x-table.cell>{{ $projeto->curso->objetivos_especificos ?? '' }}</x-table.cell>
                    <x-table.cell>{{ $projeto->ano ?? '' }}</x-table.cell>
                    <x-table.cell>
                        <x-button wire:click="view({{ $projeto->id ?? '' }})" class="w-full">Visualizar</x-button>
                        <x-secondary-button wire:click="edit({{$projeto->id ?? '' }})" class="w-full">Editar</x-secondary-button>
                        <x-danger-button wire:click="delete({{ $projeto->id ?? '' }})" class="w-full">Excluir</x-danger-button>
                    </x-table.cell>
                </x-table.row>
            @endforeach
        </x-slot>
    </x-table>
    
    <!-- Modal para criar/editar projeto -->
    <x-modal maxWidth="xl" wire:model="isOpenModal">
        <x-form-section submit="{{ $isEditMode? 'update' : 'store'}}" >
            <x-slot name="title">
                {{ $isEditMode? 'Editar Projeto' : 'Criar Novo Projeto'}}
            </x-slot>
            <x-slot name="description">
                {{ $isEditMode? 'Edite os dados do projeto' : 'Preencha os dados para criar um novo projeto'}}
            </x-slot>
            <x-slot name="form">
                <div class="col-span-6 w-full">
                    <x-label for="curso_id" value="Curso" />
                    <x-select wire:model.defer="curso_id" id="curso_id" class="w-full">
                        <option value="">Selecione um curso</option>
                        @foreach($cursos as $curso)
                            <option value="{{ $curso->id }}" {{ $curso->id == $curso_id ? 'selected' : '' }}>{{ $curso->nome }}</option>
                        @endforeach
                    </x-select>
                    <x-input-error for="curso_id" class="mt-2" />
                </div>
                <div class="col-span-6 w-full">
                    <x-label for="ano" value="Ano" />
                    <x-input id="ano" wire:model.defer="ano" class="w-full" />
                    <x-input-error for="ano" class="mt-2" />
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