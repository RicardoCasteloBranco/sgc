<div class="p-6 w-full">
    <div class="container mx-auto px-4 h-full">
        <x-button wire:click="createTipoMaterialBelico" class="m-4">Novo Tipo de Material Bélico</x-button>
    </div>    
    <!-- Tabela de Tipos de Materiais Bélicos -->
    <x-table>
        <x-slot name="theaders">
            <th class="p-3 text-center">Descrição</th>
            <th class="p-3 text-center">Ações</th> 
        </x-slot>
        <!-- Corpo da tabela Cursos -->
        <x-slot name="tbody">
            <!-- Loop de Cursos -->
            @foreach($tiposMateriais as $tipo)
                <tr class="{{$loop->even ? 'bg-blue-100' : 'bg-white' }} transition">
                    <td class="p-3 text-center">{{ $tipo->descricao }}</td>
                    <td class="p-3 text-center">
                        <button wire:click="editTipoMaterialBelico({{ $tipo->id }})" class="text-blue-600">Editar</button>
                    </td>
            @endforeach
            <!-- Fim do loop de Cursos -->
        </x-slot>
        <!-- Fim do Corpo da tabela Cursos -->
    </x-table>
    <!-- Fim da Tabela de Cursos -->
    <!-- Modal para criação de cursos -->
    <x-modal maxWidth="xl" wire:model="openModalTipoMaterialBelico">
        <x-form-section submit="{{ $isEditTipoMaterialBelico ? 'updateTipoMaterialBelico' : 'saveTipoMaterialBelico' }}">
            <x-slot name="title">
                {{ $isEditTipoMaterialBelico ? 'Editar Tipo de Material Bélico' : 'Criar Novo Tipo de Material Bélico' }}
            </x-slot>
            <x-slot name="description">
                {{ $isEditTipoMaterialBelico ? 'Edite os dados do tipo de material bélico' : 'Preencha os dados para criar um novo tipo de material bélico' }}
            </x-slot>
            <x-slot name="form">
                <div class="col-span-6 w-full">
                    <x-label for="descricao" value="descricao" />
                    <x-input id="descricao" wire:model.defer="descricao" class="w-full" type="text" />
                    <x-input-error for="descricao" class="mt-2" />
                </div>
            </x-slot>
            <x-slot name="actions">
                <x-button type="submit">
                    {{ $isEditTipoMaterialBelico ? 'Atualizar' : 'Criar' }}
                </x-button>
                @if ($isEditTipoMaterialBelico)
                    <x-secondary-button type="reset" wire:click="$set('openModalTipoMaterialBelico', false)">Cancelar</x-secondary-button>
                @endif
            </x-slot>
        </x-form-section>
    </x-modal>
    <!-- Fim do modal para criação de Tipo de Material Bélico -->
</div>