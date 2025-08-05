<div>
    <h2 class="text-lg font-bold mb-4">Detalle de la Solicitud</h2>
    @if ($registro)
        <p><strong>Guía:</strong> {{ $registro->guia }}</p>
        <p><strong>Fecha:</strong> {{ $registro->created_at->format('d/m/Y') }}</p>
        <p><strong>Delito:</strong> {{ $registro->solicitud->registroSolicitud->delito ?? '-' }} </p>
        @if ($registro->tipo === 'RegistroPolicial' || $tipoSolicitud === 'RegistroPolicial')
            <p><strong>Nº de Oficio:</strong> {{ $registro->numero_oficio ?? '-' }} </p>
            <p><strong>Expediente del tribunal:</strong> {{ $registro->numero_expediente_tribunal ?? '-' }} </p>
        @endif

        {{-- Datos completos del solicitante --}}
        @php $solicitante = $registro->solicitud->solicitante ?? null; @endphp
        @if($solicitante)
            <div class="mt-4 border-t pt-2">
                <h3 class="font-semibold text-base mb-1">Datos del Solicitante</h3>
                <p><strong>Nombre:</strong> {{ $solicitante->primer_nombre }} {{ $solicitante->segundo_nombre }} {{ $solicitante->primer_apellido }} {{ $solicitante->segundo_apellido }}</p>
                <p><strong>Cédula:</strong> {{ $solicitante->cedula }}</p>
                <p><strong>Fecha de nacimiento:</strong> {{ $solicitante->fecha_nacimiento ?? '-' }}</p>
                <p><strong>Dirección:</strong>
                    @if(isset($solicitante->direcciones) && count($solicitante->direcciones))
                        {{ $solicitante->direcciones->pluck('direccion')->join(' / ') }}
                    @else
                        -
                    @endif
                </p>
                {{-- Teléfonos --}}
                @if($solicitante->telefonos && count($solicitante->telefonos))
                    <p><strong>Teléfonos:</strong>
                        @foreach($solicitante->telefonos as $tel)
                            {{ $tel->numero }}@if(!$loop->last), @endif
                        @endforeach
                    </p>
                @endif
                {{-- Imágenes --}}
                @if(isset($solicitante->imagenes) && count($solicitante->imagenes))
                    <div class="mt-2">
                        <strong>Imágenes:</strong>
                        <div class="flex flex-wrap gap-2 mt-1">
                            @foreach($solicitante->imagenes as $img)
                                @if(!empty($img->url ?? $img->ruta ?? $img))
                                    <img src="{{ asset('storage/' . ($img->url ?? $img->ruta ?? $img)) }}" alt="Imagen" class="w-16 h-16 object-cover rounded border" />
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        @endif

        {{-- Campos adicionales para el abogado según el tipo de solicitud --}}
        @if ($tipoFuncionario === 'abogado_funcionario_id')
            @if ($tipoSolicitud === 'RegistroPolicial')
                <div class="mt-4 flex justify-end">
                    <button wire:click="$emit('cambiarEstadoRegistroPolicial')" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
                        Marcar como revisado
                    </button>
                </div>
            @elseif ($tipoSolicitud === 'Administrativa')
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700">Motivo administrativo</label>
                    <input type="text" wire:model.defer="registro.motivo_administrativo" class="w-full border rounded p-2 mt-1" />
                </div>
            @elseif ($tipoSolicitud === 'Transcripción')
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700">Notas del abogado</label>
                    <textarea wire:model.defer="registro.notas_abogado" class="w-full border rounded p-2 mt-1"></textarea>
                </div>
            @endif
        @endif
    @endif
    <div class="flex justify-between mt-4">
        @if ($registro->tipo === 'RegistroPolicial' || $tipoSolicitud === 'RegistroPolicial')
            <x-icons.pdf wire:click="" class="px-3 py-1 border rounded"></x-icons.pdf>
        @endif
        <button wire:click="$emit('cerrarModal')" class="px-3 py-1 border rounded">Cerrar</button>
    </div>
</div>
