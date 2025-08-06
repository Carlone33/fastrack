<div>
    <div class="mb-4">
        <h2 class="text-2xl font-bold text-center mb-2">Detalles de la Solicitud</h2>
        <div class="flex justify-end">
            <a href="{{ url()->previous() }}" class="px-6 py-2 rounded-full bg-gradient-to-r from-blue-600 to-blue-400 text-white font-semibold shadow-lg hover:from-blue-700 hover:to-blue-500 transition-all duration-200 text-lg border-2 border-blue-200 hover:border-blue-400">Volver</a>
        </div>
    </div>

    <!-- Acciones: Cambiar estado y PDF -->
    <div class="flex flex-col sm:flex-row flex-wrap justify-center items-center gap-4 mt-4 mb-8 max-w-3xl mx-auto">
        @php
            use Illuminate\Support\Str;
            $tipo = Str::lower(trim($tipoSolicitud));
        @endphp
        @if(Str::contains($tipo, 'registropolicial'))
            <button wire:click="generarPDFPolicial" class="px-4 py-2 rounded bg-blue-700 text-white font-bold shadow hover:bg-blue-800 transition flex items-center gap-2 border border-blue-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                PDF Registro Policial
            </button>
        @endif
        @if(Str::contains($tipo, 'administrativa'))
            <button wire:click="generarPDFAdministrativa" class="px-4 py-2 rounded bg-red-700 text-white font-bold shadow hover:bg-red-800 transition flex items-center gap-2 border border-red-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                PDF Solicitud Administrativa
            </button>
        @endif
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    </div>
    <!-- Galería de imágenes -->
    <div class="mb-8">
        <h3 class="font-semibold mb-4 text-lg text-center">Imágenes asociadas</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            @php
                $imagenes = $registro->solicitud->imagenes ?? $registro->imagenes ?? collect();
            @endphp
            @forelse($imagenes as $img)
                @php
                    $imgUrl = ltrim(preg_replace('#^/?storage/#', '', $img->url ?? $img['url']), '/');
                    $fullUrl = asset('storage/' . $imgUrl);
                @endphp
                <div class="group bg-gradient-to-br from-blue-50 to-white rounded-2xl shadow-xl border border-blue-100 hover:border-blue-400 p-4 flex flex-col items-center transition-all duration-200">
                    <div class="relative w-40 h-40 rounded-xl overflow-hidden shadow-lg border-2 border-blue-200 group-hover:border-blue-500 transition-all duration-200">
                        <img src="{{ $fullUrl }}"
                             alt="Imagen"
                             class="w-full h-full object-cover cursor-pointer transition-transform duration-200 hover:scale-110 bg-gray-100"
                             onclick="mostrarModalImagen('{{ $fullUrl }}')">
                        <a href="{{ $fullUrl }}" download target="_blank"
                           class="absolute bottom-2 right-2 bg-white bg-opacity-90 rounded-full p-1 shadow hover:bg-blue-200 text-xs hidden group-hover:block"
                           title="Descargar imagen">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-700" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5 5-5M12 15V3" /></svg>
                        </a>
                    </div>
                    <span class="text-xs text-blue-700 mt-3 truncate w-36 font-medium" title="{{ $imgUrl }}">{{ basename($imgUrl) }}</span>
                </div>
            @empty
                <span class="text-gray-500 col-span-full text-center">No hay imágenes asociadas.</span>
            @endforelse
        </div>
        <!-- Modal para imagen ampliada -->
        <div id="modalImagen" class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50 hidden">
            <div class="relative">
                <img id="imagenAmpliada" src="" alt="Imagen ampliada" class="max-w-[90vw] max-h-[80vh] rounded shadow-lg border-4 border-white bg-white">
                <a id="descargarImagen" href="#" download target="_blank" class="absolute bottom-2 left-2 bg-white bg-opacity-90 rounded-full p-2 shadow hover:bg-blue-200" title="Descargar imagen" style="display:none;">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-700" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5 5-5M12 15V3" /></svg>
                </a>
                <button onclick="cerrarModalImagen()" class="absolute top-2 right-2 bg-white rounded-full p-1 shadow hover:bg-blue-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-700" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
        </div>
        <script>
            function mostrarModalImagen(url) {
                const img = document.getElementById('imagenAmpliada');
                img.src = url;
                document.getElementById('modalImagen').classList.remove('hidden');
                const link = document.getElementById('descargarImagen');
                link.href = url;
                link.style.display = 'block';
            }
            function cerrarModalImagen() {
                document.getElementById('modalImagen').classList.add('hidden');
                document.getElementById('imagenAmpliada').src = '';
                document.getElementById('descargarImagen').style.display = 'none';
            }
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') cerrarModalImagen();
            });
        </script>
    </div>
            <div class="bg-white rounded-xl shadow-lg p-8 max-w-3xl mx-auto border border-blue-100 mb-8">
            <table class="w-full text-center table-auto border-separate border-spacing-y-2">
                <tbody>
                    <tr>
                        <td colspan="2" class="font-bold text-lg text-blue-700 bg-blue-50 rounded">Datos del Solicitante</td>
                    </tr>
                    <tr>
                        <td class="font-semibold text-gray-700">Nombre completo</td>
                        <td>
                            @php
                                $pnom = $registro['solicitud']['solicitante']['primer_nombre'] ?? $registro->solicitud->solicitante->primer_nombre ?? null;
                                $snom = $registro['solicitud']['solicitante']['segundo_nombre'] ?? $registro->solicitud->solicitante->segundo_nombre ?? null;
                                $pape = $registro['solicitud']['solicitante']['primer_apellido'] ?? $registro->solicitud->solicitante->primer_apellido ?? null;
                                $sape = $registro['solicitud']['solicitante']['segundo_apellido'] ?? $registro->solicitud->solicitante->segundo_apellido ?? null;
                                $nombreSimple = $registro['solicitud']['solicitante']['nombre'] ?? $registro->solicitud->solicitante->nombre ?? null;
                                $nombreCompleto = trim(($pnom ?? '').' '.($snom ?? '').' '.($pape ?? '').' '.($sape ?? ''));
                            @endphp
                            @if($nombreCompleto && trim($nombreCompleto) !== '')
                                {{ $nombreCompleto }}
                            @elseif($nombreSimple)
                                {{ $nombreSimple }}
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="font-semibold text-gray-700">Cédula</td>
                        <td>{{ $registro['solicitud']['solicitante']['cedula'] ?? $registro->solicitud->solicitante->cedula ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold text-gray-700">Dirección</td>
                        <td>
                            @php
                                $direcciones = $registro['solicitud']['solicitante']['direcciones'] ?? $registro->solicitud->solicitante->direcciones ?? [];
                                if (is_array($direcciones) && !empty($direcciones)) {
                                    $dir = $direcciones[0];
                                } elseif (method_exists($direcciones, 'first') && $direcciones->count()) {
                                    $dir = $direcciones->first();
                                } else {
                                    $dir = null;
                                }
                                if (is_array($dir)) {
                                    $estado = $dir['estado'] ?? '';
                                    $municipio = $dir['municipio'] ?? '';
                                    $parroquia = $dir['parroquia'] ?? '';
                                    $calle = $dir['calle'] ?? '';
                                    $casa = $dir['casa-edificio'] ?? '';
                                    $piso = $dir['piso'] ?? '';
                                    $apto = $dir['apartamento'] ?? '';
                                } elseif ($dir) {
                                    $estado = $dir->estado ?? '';
                                    $municipio = $dir->municipio ?? '';
                                    $parroquia = $dir->parroquia ?? '';
                                    $calle = $dir->calle ?? '';
                                    $casa = $dir->{'casa-edificio'} ?? '';
                                    $piso = $dir->piso ?? '';
                                    $apto = $dir->apartamento ?? '';
                                } else {
                                    $estado = $municipio = $parroquia = $calle = $casa = $piso = $apto = '';
                                }
                                $direccionCompleta = collect([
                                    $estado ? 'Estado: '.$estado : null,
                                    $municipio ? 'Municipio: '.$municipio : null,
                                    $parroquia ? 'Parroquia: '.$parroquia : null,
                                    $calle ? 'Calle: '.$calle : null,
                                    $casa ? 'Casa/Edif.: '.$casa : null,
                                    $piso ? 'Piso: '.$piso : null,
                                    $apto ? 'Apto: '.$apto : null,
                                ])->filter()->implode(', ');
                            @endphp
                            {{ $direccionCompleta ?: '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="font-semibold text-gray-700">Teléfono</td>
                        <td>
                            @php
                                $telefonos = $registro['solicitud']['solicitante']['telefonos'] ?? $registro->solicitud->solicitante->telefonos ?? [];
                                if ($telefonos instanceof \Illuminate\Support\Collection) $telefonos = $telefonos->toArray();
                                $ultimoTel = null;
                                if (!empty($telefonos)) {
                                    $ultimoTel = is_array(end($telefonos)) ? end($telefonos) : (object)end($telefonos);
                                }
                            @endphp
                            @if(!empty($telefonos))
                                @foreach($telefonos as $i => $tel)
                                    @php
                                        $num = is_array($tel) ? ($tel['numero'] ?? $tel['telefono'] ?? $tel['tel'] ?? $tel['valor'] ?? $tel['telefono_principal'] ?? '-') : ($tel->numero ?? $tel->telefono ?? $tel->tel ?? $tel->valor ?? $tel->telefono_principal ?? '-');
                                        $isLast = ($tel === $ultimoTel);
                                    @endphp
                                    <span class="inline-block px-2 py-1 rounded mr-1 {{ $isLast ? 'bg-green-200 text-green-900 font-bold border border-green-400' : 'bg-gray-100' }}">{{ $num }}</span>
                                @endforeach
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    <tr><td colspan="2" class="h-2"></td></tr>
                    <tr>
                        <td colspan="2" class="font-bold text-lg text-blue-700 bg-blue-50 rounded">Datos de la Solicitud</td>
                    </tr>
                    <!-- ID de solicitud removido -->
                    <tr>
                        <td class="font-semibold text-gray-700">Tipo Solicitud</td>
                        <td>{{ $tipoSolicitud }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold text-gray-700">Estado</td>
                        <td>{{ $registro['solicitud']['estado_solicitud'] ?? $registro->solicitud->estado_solicitud ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold text-gray-700">Funcionario encargado</td>
                        <td>
                            @php
                                $abogado = $registro['solicitud']['abogado'] ?? $registro->solicitud->abogado ?? null;
                                $credencial = null;
                                $nombreF = null;
                                if ($abogado) {
                                    $credencial = is_array($abogado) ? ($abogado['credencial'] ?? null) : ($abogado->credencial ?? null);
                                    $personaF = is_array($abogado) ? ($abogado['persona'] ?? null) : ($abogado->persona ?? null);
                                    if ($personaF) {
                                        if (is_array($personaF)) {
                                            $pnomF = $personaF['primer_nombre'] ?? '';
                                            $snomF = $personaF['segundo_nombre'] ?? '';
                                            $papeF = $personaF['primer_apellido'] ?? '';
                                            $sapeF = $personaF['segundo_apellido'] ?? '';
                                        } else {
                                            $pnomF = $personaF->primer_nombre ?? '';
                                            $snomF = $personaF->segundo_nombre ?? '';
                                            $papeF = $personaF->primer_apellido ?? '';
                                            $sapeF = $personaF->segundo_apellido ?? '';
                                        }
                                        $nombreF = trim($pnomF.' '.$snomF.' '.$papeF.' '.$sapeF);
                                        if ($nombreF === '') $nombreF = null;
                                    }
                                }
                            @endphp
                            @if(!$abogado)
                                <span class="block text-red-600">No hay abogado asociado a la solicitud.</span>
                            @elseif(!$personaF)
                                <span class="block text-red-600">No hay datos de persona para el abogado.</span>
                                <span class="block text-xs text-gray-400">Debug abogado: {{ json_encode($abogado) }}</span>
                            @else
                                <span class="block font-semibold">Credencial: {{ $credencial ?? '-' }}</span>
                                <span class="block">{{ $nombreF ?? '-' }}</span>
                            @endif
                        </td>
                    </tr>
                    <tr><td colspan="2" class="h-2"></td></tr>
                    <tr>
                        <td colspan="2" class="font-bold text-lg text-blue-700 bg-blue-50 rounded">Datos del Apoderado</td>
                    </tr>
                    @php
                        $apoderado = $registro['solicitud']['apoderado'] ?? $registro->solicitud->apoderado ?? null;
                    @endphp
                    @if($apoderado)
                        <tr>
                            <td class="font-semibold text-gray-700">Nombre completo</td>
                            <td>
                                @php
                                    $pnomA = $apoderado['primer_nombre'] ?? $apoderado->primer_nombre ?? null;
                                    $snomA = $apoderado['segundo_nombre'] ?? $apoderado->segundo_nombre ?? null;
                                    $papeA = $apoderado['primer_apellido'] ?? $apoderado->primer_apellido ?? null;
                                    $sapeA = $apoderado['segundo_apellido'] ?? $apoderado->segundo_apellido ?? null;
                                    $nombreSimpleA = $apoderado['nombre'] ?? $apoderado->nombre ?? null;
                                    $nombreCompletoA = trim(($pnomA ?? '').' '.($snomA ?? '').' '.($papeA ?? '').' '.($sapeA ?? ''));
                                @endphp
                                @if($nombreCompletoA && trim($nombreCompletoA) !== '')
                                    {{ $nombreCompletoA }}
                                @elseif($nombreSimpleA)
                                    {{ $nombreSimpleA }}
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="font-semibold text-gray-700">Cédula</td>
                            <td>{{ $apoderado['cedula'] ?? $apoderado->cedula ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="font-semibold text-gray-700">Dirección</td>
                            <td>
                                @php
                                    $direccionesA = $apoderado['direcciones'] ?? $apoderado->direcciones ?? [];
                                    if (is_array($direccionesA) && !empty($direccionesA)) {
                                        $dirA = $direccionesA[0];
                                    } elseif (method_exists($direccionesA, 'first') && $direccionesA->count()) {
                                        $dirA = $direccionesA->first();
                                    } else {
                                        $dirA = null;
                                    }
                                    if (is_array($dirA)) {
                                        $estadoA = $dirA['estado'] ?? '';
                                        $municipioA = $dirA['municipio'] ?? '';
                                        $parroquiaA = $dirA['parroquia'] ?? '';
                                        $calleA = $dirA['calle'] ?? '';
                                        $casaA = $dirA['casa-edificio'] ?? '';
                                        $pisoA = $dirA['piso'] ?? '';
                                        $aptoA = $dirA['apartamento'] ?? '';
                                    } elseif ($dirA) {
                                        $estadoA = $dirA->estado ?? '';
                                        $municipioA = $dirA->municipio ?? '';
                                        $parroquiaA = $dirA->parroquia ?? '';
                                        $calleA = $dirA->calle ?? '';
                                        $casaA = $dirA->{'casa-edificio'} ?? '';
                                        $pisoA = $dirA->piso ?? '';
                                        $aptoA = $dirA->apartamento ?? '';
                                    } else {
                                        $estadoA = $municipioA = $parroquiaA = $calleA = $casaA = $pisoA = $aptoA = '';
                                    }
                                    $direccionCompletaA = collect([
                                        $estadoA ? 'Estado: '.$estadoA : null,
                                        $municipioA ? 'Municipio: '.$municipioA : null,
                                        $parroquiaA ? 'Parroquia: '.$parroquiaA : null,
                                        $calleA ? 'Calle: '.$calleA : null,
                                        $casaA ? 'Casa/Edif.: '.$casaA : null,
                                        $pisoA ? 'Piso: '.$pisoA : null,
                                        $aptoA ? 'Apto: '.$aptoA : null,
                                    ])->filter()->implode(', ');
                                @endphp
                                {{ $direccionCompletaA ?: '-' }}
                            </td>
                        </tr>
                        <tr>
                            <td class="font-semibold text-gray-700">Teléfono</td>
                            <td>
                                @php
                                    $tels = $apoderado['telefonos'] ?? $apoderado->telefonos ?? [];
                                    if ($tels instanceof \Illuminate\Support\Collection) $tels = $tels->toArray();
                                    $ultimoTelA = null;
                                    if (!empty($tels)) {
                                        $ultimoTelA = is_array(end($tels)) ? end($tels) : (object)end($tels);
                                    }
                                @endphp
                                @if(!empty($tels))
                                    @foreach($tels as $i => $tel)
                                        @php
                                            $numA = is_array($tel) ? ($tel['numero'] ?? $tel['telefono'] ?? $tel['tel'] ?? $tel['valor'] ?? $tel['telefono_principal'] ?? '-') : ($tel->numero ?? $tel->telefono ?? $tel->tel ?? $tel->valor ?? $tel->telefono_principal ?? '-');
                                            $isLastA = ($tel === $ultimoTelA);
                                        @endphp
                                        <span class="inline-block px-2 py-1 rounded mr-1 {{ $isLastA ? 'bg-green-200 text-green-900 font-bold border border-green-400' : 'bg-gray-100' }}">{{ $numA }}</span>
                                    @endforeach
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @else
                        <tr>
                            <td colspan="2" class="text-gray-500">No hay apoderado registrado.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
            </div>
</div>
