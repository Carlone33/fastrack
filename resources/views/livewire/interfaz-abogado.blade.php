<div>
    <div class="mb-2">
        <pre class="text-xs text-gray-500 bg-gray-100 p-2 rounded">tipo_funcionario: {{ $tipo_funcionario }} | tipoSolicitud: {{ $tipoSolicitud }}</pre>
    </div>
    <h1 class="text-lg text-center mt-6">Solicitudes</h1>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-4">
    <div class="flex flex-col md:flex-row md:items-center gap-4">
        <div class="flex-1">
            <label for="tipo_solicitud" class="block text-sm font-medium text-gray-700 mb-1">Tipo de Solicitud</label>
            <select wire:model.change="tipoSolicitud" id="tipo_solicitud" class="border-gray-300 rounded-md shadow-sm w-full">
                <option value="">-- Todas --</option>
                <option value="RegistroPolicial">Registro Policial</option>
                <option value="Administrativa">Administrativa</option>
            </select>
        </div>
        <div class="flex-1">
            <label for="busqueda" class="block text-sm font-medium text-gray-700 mb-1">Buscar</label>
            <input type="text" wire:model.live="busqueda" id="busqueda" placeholder="Nombre, Apellido o Guía" class="border-gray-300 rounded-md shadow-sm w-full" />
        </div>
    </div>
    </div>

    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mt-16 max-w-7xl mx-auto">
        <table class="table-fixed w-full center text-center ">
            <thead>
                <tr class="bg-gradient-to-r from-blue-600 to-blue-800 text-white">
                    <th>Guía</th>
                    <th>Nombre y Apellido Solicitante</th>
                    <th>Fecha</th>
                    @if (auth()->user()->hasRole('Abogado') || auth()->user()->hasRole('Superadministrador') || auth()->user()->hasRole('Administrador'))
                        <th>Consulta</th>
                        <th>Historial</th>
                    @endif
                    <th>Estado</th>
                    @if ($tipo_funcionario === 'abogado_funcionario_id')
                        <th>Cambiar Estado</th>
                    @endif
                </tr>
            </thead>

            <tbody>
                @foreach ($resultados as $a)
                    <tr>
                        <td>{{ $a->guia }}</td>
                        <td>{{ $a->solicitud->solicitante->primer_nombre ?? '' }}
                            {{ $a->solicitud->solicitante->primer_apellido ?? '' }}</td>
                        <td>{{ $a->created_at->format('d/m/Y') }}</td>
                        @if (auth()->user()->hasRole('Abogado') || auth()->user()->hasRole('Superadministrador') || auth()->user()->hasRole('Administrador'))
                            <td>
                                <button wire:click="verDetalles({{ $a->id }}, '{{ $a->tipo ?? $tipoSolicitud }}', '{{ $tipo_funcionario }}')"
                                    class="inline-flex items-center px-4 py-2 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-gray-900 focus:outline-none hover:ring-2 focus:ring-green-500 hover:ring-offset-2 transition ease-in-out duration-150">
                                    Ver Detalle Completo
                                </button>
                            </td>
                            <td>
                                <button wire:click="verHistorial({{ $a->solicitud_id ?? $a->id }})"
                                    class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-purple-500 to-pink-500 border-0 rounded-full font-semibold text-xs text-white uppercase tracking-widest shadow-lg hover:from-pink-600 hover:to-purple-600 focus:outline-none focus:ring-2 focus:ring-pink-400 focus:ring-offset-2 transition ease-in-out duration-200">
                                    <svg xmlns='http://www.w3.org/2000/svg' class='h-4 w-4' fill='none' viewBox='0 0 24 24' stroke='currentColor'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z' /></svg>
                                    Historial
                                </button>
                            </td>
                        @endif
                        <td>
                            {{ $a->solicitud->estado_solicitud ?? 'Sin estado' }}
                        </td>
                        @if ($tipo_funcionario === 'abogado_funcionario_id')
                            <td>
                                @if ($a->tipo === 'RegistroPolicial' || $tipoSolicitud === 'RegistroPolicial' || isset($a->guia))
                                    <form method="GET" action="{{ route('registro-policial.cambiar-estado-form', $a->id) }}">
                                        @csrf
                                        <button type="submit" class="px-3 py-1 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">Cambiar Estado</button>
                                    </form>
                                @else
                                    <a href="{{ route('solicitud-generica.cambiar-estado-form', $a->solicitud->id) }}" class="px-3 py-1 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">Cambiar Estado</a>
                                @endif
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="max-w-7xl mx-auto sm:py-9 sm:px-6 lg:px-8">
        {{ $resultados->links() }}
    </div>

    @if ($modalOpen)
        <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
            <div class="bg-white p-6 rounded shadow-lg w-96">
                @livewire('detalle-solicitud', ['registro' => $registroSeleccionado, 'tipoSolicitud' => $tipoSolicitud, 'tipoFuncionario' => $tipo_funcionario], key($registroSeleccionado?->id ?? 'detalle'))
            </div>
        </div>
    @endif
</div>
