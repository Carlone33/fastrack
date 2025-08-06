<div>
    <form wire:submit.prevent="guardarCambios">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Primer Nombre</label>
                <input type="text" wire:model.defer="funcionarioData.persona.primer_nombre" class="w-full border rounded px-3 py-2 bg-gray-100" @if($modo !== 'editar') disabled @endif>
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Segundo Nombre</label>
                <input type="text" wire:model.defer="funcionarioData.persona.segundo_nombre" class="w-full border rounded px-3 py-2 bg-gray-100" @if($modo !== 'editar') disabled @endif>
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Primer Apellido</label>
                <input type="text" wire:model.defer="funcionarioData.persona.primer_apellido" class="w-full border rounded px-3 py-2 bg-gray-100" @if($modo !== 'editar') disabled @endif>
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Segundo Apellido</label>
                <input type="text" wire:model.defer="funcionarioData.persona.segundo_apellido" class="w-full border rounded px-3 py-2 bg-gray-100" @if($modo !== 'editar') disabled @endif>
            </div>
        </div>
        @if($modo === 'editar')
            <div class="mt-6 flex justify-end">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold">Guardar Nombres</button>
            </div>
        @endif
    </form>
</div>
