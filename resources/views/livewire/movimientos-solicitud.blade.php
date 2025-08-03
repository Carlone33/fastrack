<div class="max-w-3xl mx-auto mt-8">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
            <svg xmlns='http://www.w3.org/2000/svg' class='h-7 w-7 text-indigo-500' fill='none' viewBox='0 0 24 24' stroke='currentColor'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z' /></svg>
            Historial de movimientos de la solicitud
        </h2>
        <a href="{{ route('menu') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-gray-600 to-gray-800 text-white rounded-full shadow hover:from-gray-700 hover:to-gray-900 transition">
            <svg xmlns='http://www.w3.org/2000/svg' class='h-4 w-4' fill='none' viewBox='0 0 24 24' stroke='currentColor'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M15 19l-7-7 7-7' /></svg>
            Regresar
        </a>
    </div>
    <div class="overflow-x-auto rounded-lg shadow" style="max-height: 420px; min-height: 120px; overflow-y: auto;">
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr class="bg-gradient-to-r from-indigo-500 to-pink-500 text-white">
                    <th class="px-4 py-2 border-b">Fecha</th>
                    <th class="px-4 py-2 border-b">Credencial</th>
                    <th class="px-4 py-2 border-b">Funcionario</th>
                    <th class="px-4 py-2 border-b">Estado anterior</th>
                    <th class="px-4 py-2 border-b">Estado nuevo</th>
                    <th class="px-4 py-2 border-b">Descripción</th>
                </tr>
            </thead>
            <tbody>
                @forelse($movimientos as $movimiento)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-2 border-b text-sm">{{ $movimiento->created_at->format('d/m/Y H:i') }}</td>
                        <td class="px-4 py-2 border-b text-sm">
                            @if($movimiento->usuario && $movimiento->usuario->funcionario)
                                <span class="font-semibold text-indigo-700">{{ $movimiento->usuario->funcionario->credencial }}</span>
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-4 py-2 border-b text-sm">
                            @if($movimiento->usuario && $movimiento->usuario->funcionario && $movimiento->usuario->funcionario->persona)
                                {{ $movimiento->usuario->funcionario->persona->primer_apellido }} {{ $movimiento->usuario->funcionario->persona->primer_nombre }}
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-4 py-2 border-b text-sm">{{ $movimiento->estado_anterior ?? '-' }}</td>
                        <td class="px-4 py-2 border-b text-sm font-semibold text-indigo-600">{{ $movimiento->estado_nuevo ?? '-' }}</td>
                        <td class="px-4 py-2 border-b text-sm">{{ $movimiento->descripcion ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-2 text-center text-gray-500">No hay movimientos registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
