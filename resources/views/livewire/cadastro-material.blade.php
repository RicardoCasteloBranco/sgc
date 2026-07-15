<div class="p-6 w-full">
    <div class="container mx-auto px-4 h-full">
        <x-button wire:click="createTipoMaterial" class="m-4">Novo Tipo de Material</x-button>
    </div>    
    <!-- Tabela de Tipos de Materiais Bélicos -->
    <x-table>
        <x-slot name="theaders">
            <th class="p-3 text-center">Descrição</th>
            <th class="p-3 text-center">Unidade de Medida</th>
            <th class="p-3 text-center">Material Bélico</th>
            <th class="p-3 text-center">Ações</th> 
        </x-slot>
        <!-- Corpo da tabela Cursos -->
        <x-slot name="tbody">
            <!-- Loop de Cursos -->
            @foreach($tiposMateriais as $tipo)
                <tr wire:key="tipo-material-{{ $tipo->id }}"
                    class="{{ $loop->even ? 'bg-blue-100' : 'bg-white' }}">
                    <td class="p-3 text-center">{{ $tipo->descricao }}</td>
                    <td class="p-3 text-center">{{ $tipo->unidade_medida }}</td>
                    <td class="p-3 text-center">{{ $tipo->material_belico ? 'Sim' : 'Não' }}</td>
                    <td class="p-3 text-center">
                        <button wire:click="editTipoMaterial({{ $tipo->id }})">
                            Editar
                        </button>
                    </td>
                </tr>
            @endforeach
            <!-- Fim do loop de Cursos -->
        </x-slot>
        <!-- Fim do Corpo da tabela Cursos -->
    </x-table>
    <!-- Fim da Tabela de Cursos -->
    <!-- Modal para criação de cursos -->
    <x-modal maxWidth="xl" wire:model="openModalTipoMaterial">
        <x-form-section submit="{{ $isEditTipoMaterial ? 'updateTipoMaterial' : 'saveTipoMaterial' }}">
            <x-slot name="title">
                {{ $isEditTipoMaterial ? 'Editar Tipo de Material' : 'Criar Novo Tipo de Material' }}
            </x-slot>
            <x-slot name="description">
                {{ $isEditTipoMaterial ? 'Edite os dados do tipo de material' : 'Preencha os dados para criar um novo tipo de material' }}
            </x-slot>
            <x-slot name="form">
                <div class="col-span-6 w-full">
                    <x-label for="descricao" value="Descricao" />
                    <x-input id="descricao" wire:model.defer="descricao" class="w-full" type="text" />
                    <x-input-error for="descricao" class="mt-2" />
                </div>
                <div class="col-span-6 w-full">
                    <x-label for="unidade_medida" value="Unidade de Medida" />
                    <x-input id="unidade_medida" wire:model.defer="unidade_medida" class="w-full" type="text" />
                    <x-input-error for="unidade_medida" class="mt-2" />
                </div>
                <div class="col-span-6 w-full">
                    <x-label for="material_belico" value="Material Bélico" />
                    <x-checkbox id="material_belico" wire:model.defer="material_belico" />
                    <x-input-error for="material_belico" class="mt-2" />
                </div>
            </x-slot>
            <x-slot name="actions">
                <x-button type="submit">
                    {{ $isEditTipoMaterial ? 'Atualizar' : 'Criar' }}
                </x-button>
                @if ($isEditTipoMaterial)
                    <x-secondary-button type="reset" wire:click="$set('openModalTipoMaterial', false)">Cancelar</x-secondary-button>
                @endif
            </x-slot>
        </x-form-section>
    </x-modal>
    <!-- Fim do modal para criação de Tipo de Material Bélico -->
</div>