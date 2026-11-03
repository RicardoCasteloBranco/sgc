<div class="p-6 w-full">
    <div class="container mx-auto px-4 h-full">
        <x-button wire:click="createTipoMaterial" class="m-4">Novo Tipo de Material</x-button>
    </div>    
    <!-- Tabela de Tipos de Materiais Bélicos -->
    <x-table>
        <x-slot name="theaders">
            <th class="p-3 text-center">Descrição</th>
            <th class="p-3 text-center">Unidade de Medida</th>
            <th class="p-3 text-center">Natureza do Material</th>
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
                    <td class="p-3 text-center">{{ $tipo->naturezaMaterial->descricao ?? 'Nenhuma' }}</td>
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
                    <x-label for="unidadeMedida" value="Unidade de Medida" />
                    <x-input id="unidadeMedida" wire:model.defer="unidadeMedida" class="w-full" type="text" />
                    <x-input-error for="unidadeMedida" class="mt-2" />
                </div>
                <div class="col-span-6 w-full">
                    <x-label for="naturezaMaterialId" value="Natureza do Material" />
                    <x-select id="naturezaMaterialId" wire:model.defer="naturezaMaterialId" class="w-full">
                        <option value="">Selecione uma natureza</option>
                        @foreach($naturezasMateriais as $natureza)
                            <option value="{{ $natureza->id }}">{{ $natureza->descricao }}</option>
                        @endforeach
                    </x-select>
                    <x-input-error for="naturezaMaterialId" class="mt-2" />
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