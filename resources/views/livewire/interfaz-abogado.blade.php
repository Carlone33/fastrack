<div>
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
                    <th>Estado</th>
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
                            <button wire:click="abrirModal('{{ $a->id }}', '{{ $a->tipo }}')"
                                class="inline-flex items-center px-4 py-2 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-gray-900 focus:outline-none hover:ring-2 focus:ring-green-500 hover:ring-offset-2 transition ease-in-out duration-150">
                                Consultar
                            </button>
                        </td>
                        <td>
                            @if ($a->verificado == true)
                                {{ 'verificado fecha: ' . $a->fecha_verificación }}
                            @else
                                No ha sido verificado
                            @endif
                        </td>
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
                <h2 class="text-lg font-bold mb-4">Detalle de la Solicitud</h2>
                @if ($registroSeleccionado)
                    <p><strong>Guía:</strong> {{ $registroSeleccionado->guia }}</p>
                    <p><strong>Solicitante:</strong>
                        {{ $registroSeleccionado->solicitud->solicitante->primer_nombre ?? '' }}
                        {{ $registroSeleccionado->solicitud->solicitante->primer_apellido ?? '' }}</p>
                    <p><strong>Fecha:</strong> {{ $registroSeleccionado->created_at->format('d/m/Y') }}</p>
                    <p><strong>Delito:</strong> {{ $registroSeleccionado->solicitud->registroSolicitud->delito }} </p>
                    <p><strong>Nº de Oficio:</strong> {{ $registroSeleccionado->numero_oficio }} </p>
                    <p><strong>Expediente del tribunal:</strong> {{ $registroSeleccionado->numero_expediente_tribunal }} </p>
                @endif
                <div class="flex justify-between mt-4">
                    <x-icons.pdf wire:click="" class="px-3 py-1 border rounded"></x-icons.pdf>
                    <button wire:click="$set('modalOpen', false)" class="px-3 py-1 border rounded">Cerrar</button>
                </div>
            </div>
        </div>
    @endif


</div>
