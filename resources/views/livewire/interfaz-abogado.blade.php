<div>
    <div class="mb-2">
        <pre class="text-xs text-gray-500 bg-gray-100 p-2 rounded">tipo_funcionario: {{ $tipo_funcionario }} | tipoSolicitud: {{ $tipoSolicitud }}</pre>
    </div>
    <h1 class="text-lg text-center mt-6">Solicitudes</h1>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-4">
        <label for="tipo_solicitud" class="block text-sm font-medium text-gray-700 mb-1">Tipo de Solicitud</label>
        <select wire:model.change="tipoSolicitud" id="tipo_solicitud" class="border-gray-300 rounded-md shadow-sm w-full">
            <option value="">-- Todas --</option>
            <option value="RegistroPolicial">Registro Policial</option>
            {{-- <option value="Transcripción">Dictamen</option> --}}
            <option value="Administrativa">Administrativa</option>
            <option value="RegistroUnico">Registro Único</option>
        </select>
    </div>

    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mt-16 max-w-7xl mx-auto">
        <table class="table-fixed w-full center text-center ">
            <thead>
                <tr class="bg-gradient-to-r from-blue-600 to-blue-800 text-white">
                    <th>Guía</th>
                    <th>Nombre y Apellido Solicitante</th>
                    <th>Fecha</th>
                    <th>Consulta</th>
                    <th>Historial</th>
                    <th>Estado</th>
                    @if ($tipo_funcionario === 'abogado_funcionario_id' && ($tipoSolicitud === 'RegistroPolicial' || $tipoSolicitud === 'Administrativa' || $tipoSolicitud === 'RegistroUnico'))
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
                        <td>
                            <button wire:click="verDetalles({{ $a->id }}, '{{ $a->tipo ?? $tipoSolicitud }}')"
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
                        <td>
                            {{ $a->solicitud->estado_solicitud ?? 'Sin estado' }}
                        </td>
                        @if ($tipo_funcionario === 'abogado_funcionario_id')
                            @if ($tipoSolicitud === 'RegistroPolicial')
                                <td>
                                    <form method="GET" action="{{ route('registro-policial.cambiar-estado-form', $a->id) }}">
                                        @csrf
                                        <button type="submit" class="px-3 py-1 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">Cambiar Estado</button>
                                    </form>
                                </td>
                            @elseif ($tipoSolicitud === 'Administrativa' || $tipoSolicitud === 'RegistroUnico')
                                <td>
                                    <a href="{{ route('solicitud-generica.cambiar-estado-form', $a->solicitud->id) }}" class="px-3 py-1 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">Cambiar Estado</a>
                                </td>
                            @endif
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
