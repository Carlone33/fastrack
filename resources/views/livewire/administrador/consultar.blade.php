<div>

    @if ($funcionario)
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 p-4">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Primer Nombre</label>
                <input type="text" wire:model.defer="funcionario.primer_nombre" class="w-full border rounded px-3 py-2 bg-gray-100"
                    @if(!$modoEdicion) readonly @endif>
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Segundo Nombre</label>
                <input type="text" wire:model.defer="funcionario.segundo_nombre" class="w-full border rounded px-3 py-2 bg-gray-100"
                    @if(!$modoEdicion) readonly @endif>
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Primer Apellido</label>
                <input type="text" wire:model.defer="funcionario.primer_apellido" class="w-full border rounded px-3 py-2 bg-gray-100"
                    @if(!$modoEdicion) readonly @endif>
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Segundo Apellido</label>
                <input type="text" wire:model.defer="funcionario.segundo_apellido" class="w-full border rounded px-3 py-2 bg-gray-100"
                    @if(!$modoEdicion) readonly @endif>
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Nacionalidad</label>
                <select wire:model.defer="funcionario.nacionalidad" class="w-full border rounded px-3 py-2 bg-gray-100" @if(!$modoEdicion) disabled @endif>
                    <option value="V" {{ $funcionario['nacionalidad'] == 'V' ? 'selected' : '' }}>Venezolano</option>
                    <option value="E" {{ $funcionario['nacionalidad'] == 'E' ? 'selected' : '' }}>Extranjero</option>
                </select>
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Cédula</label>
                <input type="text" class="w-full border rounded px-3 py-2 bg-gray-100"
                    value="{{ $funcionario['cedula'] ?? '' }}"
                    readonly>
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Correo</label>
                <input type="email" wire:model.defer="funcionario.correo" class="w-full border rounded px-3 py-2 bg-gray-100"
                    @if(!$modoEdicion) readonly @endif>
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Sexo</label>
                <select wire:model.defer="funcionario.sexo" class="w-full border rounded px-3 py-2 bg-gray-100" @if(!$modoEdicion) disabled @endif>
                    <option value="M" {{ $funcionario['sexo'] == 'M' ? 'selected' : '' }}>Masculino</option>
                    <option value="F" {{ $funcionario['sexo'] == 'F' ? 'selected' : '' }}>Femenino</option>
                </select>
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Credencial</label>
                <input type="text" class="w-full border rounded px-3 py-2 bg-gray-100"
                    value="{{ $funcionario['credencial'] ?? '' }}"
                    readonly>
            </div>
        </div>
    @else
        <div class="col-span-3 text-center text-red-500">No hay datos para mostrar.</div>
    @endif



</div>
