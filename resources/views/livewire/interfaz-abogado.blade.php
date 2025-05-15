<div>
    <button wire:click="abrirModalCrear" class="bg-blue-600 text-white px-4 py-2 rounded mb-4">Nuevo Registro</button>

    @if (session()->has('message'))
        <div class="bg-green-200 text-green-800 px-4 py-2 rounded mb-2">
            {{ session('message') }}
        </div>
    @endif
<div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
    <table class="min-w-full bg-white border border-gray-300 mb-4">
        <thead>
            <tr>
                <th class="px-4 py-2 border-b">Guía</th>
                <th class="px-4 py-2 border-b">Solicitante</th>
                <th class="px-4 py-2 border-b">Editar</th>
                <th class="px-4 py-2 border-b">Eliminar</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($registrosPoliciales as $registro)
                <tr>
                    <td class="px-4 py-2 border-b">{{ $registro->guia }}</td>
                    <td class="px-4 py-2 border-b">{{ $registro->solicitud->solicitante->primer_nombre ?? '' }}</td>
                    <td class="px-4 py-2 border-b text-center">
                        <button wire:click="abrirModalEditar({{ $registro->id }})" class="bg-yellow-400 px-2 py-1 rounded">
                            Editar
                        </button>
                    </td>
                    <td class="px-4 py-2 border-b text-center">
                        <button wire:click="eliminar({{ $registro->id }})" class="bg-red-500 text-white px-2 py-1 rounded">
                            Eliminar
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-4 py-2 text-center text-gray-500">No hay registros</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
    <!-- Modal -->
    @if($modalOpen)
        <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
            <div class="bg-white p-6 rounded shadow-lg w-96">
                <h2 class="text-lg font-bold mb-4">{{ $editando ? 'Editar' : 'Nuevo' }} Registro</h2>
                <div class="mb-4">
                    <label class="block mb-1">Guía</label>
                    <input type="text" wire:model="registro.guia" class="w-full border rounded px-2 py-1">
                    @error('registro.guia') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <!-- Agrega aquí más campos según tu modelo -->

                <div class="flex justify-end space-x-2">
                    <button wire:click="$set('modalOpen', false)" class="px-3 py-1 border rounded">Cancelar</button>
                    <button wire:click="guardar" class="bg-blue-600 text-white px-3 py-1 rounded">Guardar</button>
                </div>
            </div>
        </div>
    @endif
</div>
