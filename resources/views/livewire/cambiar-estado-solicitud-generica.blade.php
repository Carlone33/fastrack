<div class="container mx-auto max-w-lg mt-10">
    <h2 class="text-2xl font-bold mb-4">Cambiar estado de la solicitud</h2>
    <div class="mb-4">
        <strong>Tipo:</strong> {{ $solicitud->tipo_solicitud ?? '-' }}<br>
        <strong>Estado actual:</strong> {{ $solicitud->estado_solicitud ?? 'Sin estado' }}
    </div>
    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-2 rounded mb-4">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 text-red-800 p-2 rounded mb-4">{{ session('error') }}</div>
    @endif
    <form wire:submit.prevent="actualizarEstado">
        <div class="mb-4">
            <label for="nuevo_estado" class="block mb-1 font-semibold">Nuevo estado</label>
            <select wire:model="nuevo_estado" id="nuevo_estado" class="w-full border rounded p-2">
                @foreach($estados as $estado)
                    <option value="{{ $estado }}">{{ $estado }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label for="comentario" class="block mb-1 font-semibold">Comentario <span class="text-red-500">*</span></label>
            <textarea wire:model.defer="comentario" id="comentario" rows="3" class="w-full border rounded p-2" placeholder="Escribe el motivo del cambio de estado" required></textarea>
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Actualizar estado</button>
    </form>
</div>
