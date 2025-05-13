<div>
    <div>
        <div class="py-2">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <h1
                        class="bg-gradient-to-r from-blue-600 to-blue-800 text-white col-start-1 col-span-4 text-center text-xl mb-3 border-t border-b py-4">
                        Exclusión por Registro Único</h1>

                    <form wire:submit.prevent="FormatoyEnviar" class="mt-5 mr-5 ml-5 mb-5">
                        <div class=" grid grid-cols-3 gap-4">
                            @if ($currentStep === 1)
                            <h3 class="col-span-3 text-center text-lg">Datos del Solicitante</h3>

                                <x-label>
                                    @if ($foto)
                                        <img class="rounded-lg mx-auto w-40 h-40"
                                            src="{{ asset('storage/' . $foto->store('fotos', 'public')) }}">
                                    @else
                                        <img class="rounded-lg mx-auto w-40 h-40"
                                            src="{{ asset('images/default-avatar.jpg') }}">
                                    @endif
                                    <input type="file" wire:model="foto" class="hidden" ref="foto">
                                    {{-- <button type="button"
                                    class="bg-gradient-to-r from-blue-600 to-blue-800 hover:from-blue-700 hover:to-blue-900 text-white font-medium py-2 px-4 flex items-center justify-center mt-2 rounded-md shadow-md transition duration-300 ease-in-out mx-auto"
                                    id="uploadButton">
                                    Subir Foto
                                </button> --}}
                                    @error('foto')
                                        <span class="text-red-500 text-xs mt-3 block">{{ $message }}</span>
                                    @enderror
                                </x-label>


                                <x-label>
                                    Nacionalidad
                                    <select class="block rounded-lg mt-2 w-full" wire:model="nacionalidad">
                                        <option selected value="" class="rounded-lg">Seleccione una opción...
                                        </option>
                                        <option value="V">Venezolano</option>
                                        <option value="E">Extranjero</option>
                                    </select>
                                    @error('nacionalidad')
                                        <span class="text-red-500 text-xs mt-3 block ">{{ $message }}</span>
                                    @enderror
                                </x-label>

                                <x-label>
                                    Nº de Cedula
                                    <input wire:model="cedula" type="text" class="block rounded-lg mt-2 w-full">
                                    @error('cedula')
                                        <span class="text-red-500 text-xs mt-3 block">{{ $message }}</span>
                                    @enderror
                                </x-label>

                                <x-label>
                                    Primer Nombre
                                    <input wire:model="primernombre" type="text"
                                        class="block rounded-lg mt-2 w-full">
                                    @error('primernombre')
                                        <span class="text-red-500 text-xs mt-3 block ">{{ $message }}</span>
                                    @enderror
                                </x-label>

                                <x-label>
                                    Segundo Nombre
                                    <input wire:model="segundonombre" type="text"
                                        class="block rounded-lg mt-2 w-full">
                                    @error('segundonombre')
                                        <span class="text-red-500 text-xs mt-3 block ">{{ $message }}</span>
                                    @enderror
                                </x-label>

                                <x-label>
                                    Primer Apellido
                                    <input wire:model="primerapellido" type="text"
                                        class="block rounded-lg mt-2 w-full">
                                    @error('primerapellido')
                                        <span class="text-red-500 text-xs mt-3 block ">{{ $message }}</span>
                                    @enderror
                                </x-label>

                                <x-label>
                                    Segundo Apellido
                                    <input wire:model="segundoapellido" type="text"
                                        class="block rounded-lg mt-2 w-full">
                                    @error('segundoapellido')
                                        <span class="text-red-500 text-xs mt-3 block ">{{ $message }}</span>
                                    @enderror
                                </x-label>

                                <x-label>
                                    Sexo
                                    <select class="block rounded-lg mt-2 w-full" wire:model="sexo">
                                        <option selected value="" class="rounded-lg">Seleccione una opción...
                                        </option>
                                        <option value="M">Masculino</option>
                                        <option value="F">Femenino</option>
                                    </select>
                                    @error('sexo')
                                        <span class="text-red-500 text-xs mt-3 block ">{{ $message }}</span>
                                    @enderror
                                </x-label>

                                <x-label>
                                    Teléfono
                                    <input x-data x-model="telefono" x-ref="telefono"
                                        @input="
                                    let value = $refs.telefono.value.replace(/\D/g, '');
                                        if (value.length > 4) {
                                        value = value.substring(0, 4) + '-' + value.substring(4, 11);
                                        }
                                        $refs.telefono.value = value.substring(0, 12);
                                        $dispatch('input', value);
                                    "
                                        wire:model="telefono" class="block rounded-lg mt-2 w-full" type="tel"
                                        placeholder="0424-1234567" pattern="^0\d{3}-\d{7}$" maxlength="12">
                                    @error('telefono')
                                        <span class="text-red-500 text-xs mt-3 block ">{{ $message }}</span>
                                    @enderror
                                </x-label>

                                <x-label>
                                    Teléfono Local
                                    <input x-data x-model="telefonolocal" x-ref="telefonolocal"
                                        @input="
                                    let value = $refs.telefonolocal.value.replace(/\D/g, '');
                                        if (value.length > 4) {
                                        value = value.substring(0, 4) + '-' + value.substring(4, 12);
                                        }
                                        $refs.telefonolocal.value = value.substring(0, 13);
                                        $dispatch('input', value);
                                    "
                                        wire:model.change="telefonolocal" class="block rounded-lg mt-2 w-full"
                                        type="text">
                                    @error('telefono_local')
                                        <span class="text-red-500 text-xs mt-3 block ">{{ $message }}</span>
                                    @enderror
                                </x-label>

                                <x-label>
                                    Email
                                    <input wire:model="email" type="email" class="block rounded-lg mt-2 w-full"
                                        placeholder="ejemplo@correo.com">
                                    @error('email')
                                        <span class="text-red-500 text-xs mt-3 block ">{{ $message }}</span>
                                    @enderror
                                </x-label>

                                {{-- Dirección --}}
                                <h3 class="text-center col-span-3 text-lg"> Dirección Domicilial del Solicitante </h3>
                                <x-label>
                                    Estado
                                    <select wire:model.change="ubicaciones.solicitante.estado"
                                        class="block rounded-lg mt-2 w-full">
                                        <option value="">Seleccione un estado</option>
                                        @foreach ($ubicaciones['solicitante']['estados'] as $estado)
                                            <option value="{{ $estado->id }}">{{ $estado->nombre }}</option>
                                        @endforeach
                                    </select>
                                </x-label>
                                <x-label>
                                    Municipio
                                    <select wire:model.change="ubicaciones.solicitante.municipio"
                                        class="block rounded-lg mt-2 w-full">
                                        <option value="">Seleccione un municipio</option>
                                        @foreach ($ubicaciones['solicitante']['municipios'] as $municipio)
                                            <option value="{{ $municipio->id }}">{{ $municipio->nombre }}</option>
                                        @endforeach
                                    </select>
                                </x-label>
                                <x-label>
                                    Parroquia
                                    <select wire:model.change="ubicaciones.solicitante.parroquia"
                                        class="block rounded-lg mt-2 w-full">
                                        <option value="">Seleccione una parroquia</option>
                                        @foreach ($ubicaciones['solicitante']['parroquias'] as $parroquia)
                                            <option value="{{ $parroquia->id }}">{{ $parroquia->nombre }}</option>
                                        @endforeach
                                    </select>
                                </x-label>

                                <x-label>
                                    Calle
                                    <input wire:model="ubicaciones.solicitante.calle"
                                        class="block rounded-lg mt-2 w-full" type="text">
                                    @error('calle_solicitante')
                                        <span class="text-red-500 text-xs mt-3 block ">{{ $message }}</span>
                                    @enderror

                                </x-label>
                                <x-label>
                                    Casa / Edificio
                                    <input wire:model="ubicaciones.solicitante.casa_edificio"
                                        class="block rounded-lg mt-2 w-full" type="text">
                                    @error('casa_edificio_solicitante')
                                        <span class="text-red-500 text-xs mt-3 block ">{{ $message }}</span>
                                    @enderror
                                </x-label>
                                <x-label>
                                    Piso
                                    <input wire:model="ubicaciones.solicitante.piso"
                                        class="block rounded-lg mt-2 w-full" type="text">
                                    @error('piso_solicitante')
                                        <span class="text-red-500 text-xs mt-3 block ">{{ $message }}</span>
                                    @enderror
                                </x-label>
                                <x-label>
                                    Apartamento
                                    <input wire:model="ubicaciones.solicitante.apartamento"
                                        class="block rounded-lg mt-2 w-full" type="text">
                                    @error('apartamento_solicitante')
                                        <span class="text-red-500 text-xs mt-3 block ">{{ $message }}</span>
                                    @enderror
                                </x-label>


                                <h3 class="text-center col-span-3 text-lg"> Información de Solicitud de Exclusión </h3>
                                <x-label>
                                    Estado del ciudadano
                                    <input wire:model="estado_ciudadano" class="block rounded-lg mt-2 w-full"
                                        type="text">
                                    @error('estado_ciudadano')
                                        <span class="text-red-500 text-xs mt-3 block ">{{ $message }}</span>
                                    @enderror
                                </x-label>

                                <x-label>
                                    Dependencia / Unidad Administrativa
                                    <div x-data="{
                                        search: '',
                                        open: false,
                                        select(id, nombre) {
                                            this.search = nombre;
                                            $wire.set('unidad_administrativa', id);
                                            this.open = false;
                                        }
                                    }" class="relative">
                                        <input x-model="search" @focus="open = true" @input="open = true"
                                            type="text" placeholder="Buscar dependencia..."
                                            class="block rounded-lg mt-2 w-full border border-gray-300"
                                            autocomplete="off">
                                        <input type="hidden" wire:model="unidad_administrativa">
                                        <ul x-show="open && search.length > 0" @click.away="open = false"
                                            class="absolute z-10 w-full bg-white border border-gray-300 rounded-lg shadow max-h-48 overflow-auto mt-1">
                                            @foreach ($unidadesAdministrativas as $unidadAdministrativa)
                                                <li x-show="search === '' || '{{ strtolower($unidadAdministrativa->nombre) }}'.includes(search.toLowerCase())"
                                                    @click="select('{{ $unidadAdministrativa->id }}', '{{ $unidadAdministrativa->nombre }}')"
                                                    class="px-4 py-2 cursor-pointer hover:bg-blue-100">
                                                    {{ $unidadAdministrativa->nombre }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @error('unidad_administrativa')
                                        <span class="text-red-500 text-xs mt-3 block ">{{ $message }}</span>
                                    @enderror
                                </x-label>

                                <x-label>
                                    Delito
                                    <input wire:model="delito"class="block rounded-lg mt-2 w-full" type="text">
                                    @error('delito')
                                        <span class="text-red-500 text-xs mt-3 block ">{{ $message }}</span>
                                    @enderror
                                </x-label>

                                <x-label>
                                    Fecha de Registro SIIPOL
                                    <input wire:model="fecha_registrosiipol" class="block rounded-lg mt-2 w-full"
                                        type="date">
                                    @error('fecha_solicitud')
                                        <span class="text-red-500 text-xs mt-3 block ">{{ $message }}</span>
                                    @enderror
                                </x-label>

                                <x-label>
                                    Fecha de Solicitud
                                    <input wire:model="fecha_solicitud" class="block rounded-lg mt-2 w-full"
                                        type="date">
                                    @error('fecha_solicitud')
                                        <span class="text-red-500 text-xs mt-3 block ">{{ $message }}</span>
                                    @enderror
                                </x-label>

                                <x-label>
                                    Hora de Solicitud
                                    <input wire:model="hora_solicitud" class="block rounded-lg mt-2 w-full"
                                        type="time">
                                    @error('hora_solicitud')
                                        <span class="text-red-500 text-xs mt-3 block ">{{ $message }}</span>
                                    @enderror
                                </x-label>

                                <x-label class="col-start-1 flex items-center">
                                    <x-checkbox wire:click="toggleAssigned" class="h-6 w-6 mr-3" />
                                    <span class="text-xl font-bold">Con Apoderado</span>
                                </x-label></br></br></br>

                            @endif


                            @if ($currentStep === 2)





                                @if ($showAssigned)
                                        {{-- <h2
                                            class="bg-gradient-to-r from-blue-600 to-blue-800 text-white font-bold col-span-3 text-center text-xl mt-3 mb-3 border-t border-b py-4">
                                            Información del Apoderado</h2> --}}
                                    <h3 class="col-span-3 text-center text-lg">Datos del Apoderado</h3>
                                    <x-label>

                                        <x-label>
                                            @if ($foto_apoderado)
                                                <img class="rounded-lg mx-auto w-40 h-40"
                                                    src="{{ asset('storage/' . $foto_apoderado->store('fotos', 'public')) }}">
                                            @else
                                                <img class="rounded-lg mx-auto w-40 h-40"
                                                    src="{{ asset('images/default-avatar.jpg') }}">
                                            @endif
                                            <input type="file" wire:model="foto_apoderado" class="hidden" ref="foto">
                                            {{-- <button type="button"
                                            class="bg-gradient-to-r from-blue-600 to-blue-800 hover:from-blue-700 hover:to-blue-900 text-white font-medium py-2 px-4 flex items-center justify-center mt-2 rounded-md shadow-md transition duration-300 ease-in-out mx-auto"
                                            id="uploadButton">
                                            Subir Foto
                                        </button> --}}
                                            @error('foto')
                                                <span class="text-red-500 text-xs mt-3 block">{{ $message }}</span>
                                            @enderror
                                        </x-label>

                                        <x-label>
                                        Nacionalidad
                                        <select class="block rounded-lg mt-2 w-full"
                                            wire:model="nacionalidad_apoderado">
                                            <option selected value="" class="rounded-lg">Seleccione una
                                                opción...
                                            </option>
                                            <option value="V">Venezolano</option>
                                            <option value="E">Extranjero</option>
                                        </select>
                                        @error('nacionalidad')
                                            <span class="text-red-500 text-xs mt-3 block ">{{ $message }}</span>
                                        @enderror
                                    </x-label>
                                    <x-label>
                                        Nº de Cedula
                                        <input wire:model="cedula_apoderado" type="text"
                                            class="block rounded-lg mt-2 w-full">
                                        @error('cedula')
                                            <span class="text-red-500 text-xs mt-3 block">{{ $message }}</span>
                                        @enderror
                                    </x-label>

                                    <x-label>
                                        Primer Nombre
                                        <input wire:model="primernombre_apoderado" type="text"
                                            class="block rounded-lg mt-2 w-full">
                                        @error('primernombre')
                                            <span class="text-red-500 text-xs mt-3 block ">{{ $message }}</span>
                                        @enderror
                                    </x-label>

                                    <x-label>
                                        Segundo Nombre
                                        <input wire:model="segundonombre_apoderado" type="text"
                                            class="block rounded-lg mt-2 w-full">
                                        @error('segundonombre')
                                            <span class="text-red-500 text-xs mt-3 block ">{{ $message }}</span>
                                        @enderror
                                    </x-label>

                                    <x-label>
                                        Primer Apellido
                                        <input wire:model="primerapellido_apoderado" type="text"
                                            class="block rounded-lg mt-2 w-full">
                                        @error('primerapellido')
                                            <span class="text-red-500 text-xs mt-3 block ">{{ $message }}</span>
                                        @enderror
                                    </x-label>

                                    <x-label>
                                        Segundo Apellido
                                        <input wire:model="segundoapellido_apoderado" type="text"
                                            class="block rounded-lg mt-2 w-full">
                                        @error('segundoapellido')
                                            <span class="text-red-500 text-xs mt-3 block ">{{ $message }}</span>
                                        @enderror
                                    </x-label>

                                    <x-label>
                                        Sexo
                                        <select class="block rounded-lg mt-2 w-full" wire:model="sexo_apoderado">
                                            <option selected value="" class="rounded-lg">Seleccione una
                                                opción...</option>
                                            <option value="M">Masculino</option>
                                            <option value="F">Femenino</option>
                                        </select>
                                        @error('sexo_apoderado')
                                            <span class="text-red-500 text-xs mt-3 block ">{{ $message }}</span>
                                        @enderror
                                    </x-label>

                                    <x-label>
                                        Teléfono
                                        <input x-data x-model="telefono_apoderado" x-ref="telefono_apoderado"
                                            @input="
                                    let value = $refs.telefono_apoderado.value.replace(/\D/g, '');
                                        if (value.length > 4) {
                                        value = value.substring(0, 4) + '-' + value.substring(4, 12);
                                        }
                                        $refs.telefono_apoderado.value = value.substring(0, 13);
                                        $dispatch('input', value);
                                    "
                                            wire:model="telefono_apoderado" class="block rounded-lg mt-2 w-full"
                                            type="text">
                                        @error('telefono')
                                            <span class="text-red-500 text-xs mt-3 block ">{{ $message }}</span>
                                        @enderror
                                    </x-label>

                                    <x-label>
                                        Teléfono Local
                                        <input x-data x-model="telefonolocal_apoderado"
                                            x-ref="telefonolocal_apoderado"
                                            @input="
                                    let value = $refs.telefonolocal_apoderado.value.replace(/\D/g, '');
                                        if (value.length > 4) {
                                        value = value.substring(0, 4) + '-' + value.substring(4, 12);
                                        }
                                        $refs.telefonolocal_apoderado.value = value.substring(0, 13);
                                        $dispatch('input', value);
                                    "
                                            wire:model="telefonolocal_apoderado" class="block rounded-lg mt-2 w-full"
                                            type="text" pattern="^04\d{2}-\d{8}$">
                                        @error('telefono_local')
                                            <span class="text-red-500 text-xs mt-3 block ">{{ $message }}</span>
                                        @enderror
                                    </x-label>

                                    <x-label>
                                        Email
                                        <input wire:model="email_apoderado" type="email"
                                            class="block rounded-lg mt-2 w-full" placeholder="ejemplo@correo.com">
                                        @error('email_apoderado')
                                            <span class="text-red-500 text-xs mt-3 block ">{{ $message }}</span>
                                        @enderror
                                    </x-label>

                                    <h3 class="text-center col-span-3 text-lg"> Dirección Domicilial del Apoderado</h3>
                                    <x-label>
                                        Estado
                                        <select wire:model.change="ubicaciones.apoderado.estado"
                                            class="block rounded-lg mt-2 w-full">
                                            <option value="">Seleccione un estado</option>
                                            @foreach ($ubicaciones['apoderado']['estados'] as $estado)
                                                <option value="{{ $estado->id }}">{{ $estado->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </x-label>
                                    <x-label>
                                        Municipio
                                        <select wire:model.change="ubicaciones.apoderado.municipio"
                                            class="block rounded-lg mt-2 w-full">
                                            <option value="">Seleccione un municipio</option>
                                            @foreach ($ubicaciones['apoderado']['municipios'] as $municipio)
                                                <option value="{{ $municipio->id }}">{{ $municipio->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </x-label>
                                    <x-label>
                                        Parroquia
                                        <select wire:model.change="ubicaciones.apoderado.parroquia"
                                            class="block rounded-lg mt-2 w-full">
                                            <option value="">Seleccione una parroquia</option>
                                            @foreach ($ubicaciones['apoderado']['parroquias'] as $parroquia)
                                                <option value="{{ $parroquia->id }}">{{ $parroquia->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </x-label>

                                    <x-label>
                                        Calle
                                        <input wire:model="ubicaciones.apoderado.calle"
                                            class="block rounded-lg mt-2 w-full" type="text">
                                        @error('calle_apoderado')
                                            <span class="text-red-500 text-xs mt-3 block ">{{ $message }}</span>
                                        @enderror

                                    </x-label>
                                    <x-label>
                                        Casa / Edificio
                                        <input wire:model="ubicaciones.apoderado.casa_edificio"
                                            class="block rounded-lg mt-2 w-full" type="text">
                                        @error('casa_edificio_apoderado')
                                            <span class="text-red-500 text-xs mt-3 block ">{{ $message }}</span>
                                        @enderror
                                    </x-label>
                                    <x-label>
                                        Piso
                                        <input wire:model="ubicaciones.apoderado.piso"
                                            class="block rounded-lg mt-2 w-full" type="text">
                                        @error('piso_apoderado')
                                            <span class="text-red-500 text-xs mt-3 block ">{{ $message }}</span>
                                        @enderror
                                    </x-label>
                                    <x-label>
                                        Apartamento
                                        <input wire:model="ubicaciones.apoderado.apartamento"
                                            class="block rounded-lg mt-2 w-full" type="text">
                                        @error('apartamento_apoderado')
                                            <span class="text-red-500 text-xs mt-3 block ">{{ $message }}</span>
                                        @enderror
                                    </x-label>



                                @endif
                            @endif


                            @if ($currentStep === 3)
                                {{-- <h2
                                    class="bg-gradient-to-r from-blue-600 to-blue-800 text-white col-span-3 text-center text-xl mt-3 mb-3 border-t border-b py-4">
                                    Información del abogado
                                </h2> --}}

                                <h3 class="col-span-3 text-center text-lg">Datos del Abogado</h3>

                                <x-label>
                                    Nacionalidad
                                    <select class="block rounded-lg mt-2 w-full" wire:model="nacionalidad_abogado">
                                        <option selected value="" class="rounded-lg">Seleccione una opción...
                                        </option>
                                        <option value="V">Venezolano</option>
                                        <option value="E">Extranjero</option>
                                    </select>
                                    @error('nacionalidad')
                                        <span class="text-red-500 text-xs mt-3 block ">{{ $message }}</span>
                                    @enderror
                                </x-label>

                                <x-label>
                                    Nº de Cedula
                                    <input wire:model="cedula_abogado" type="text"
                                        class="block rounded-lg mt-2 w-full">
                                    @error('cedula')
                                        <span class="text-red-500 text-xs mt-3 block">{{ $message }}</span>
                                    @enderror
                                </x-label>

                                <x-label>
                                    Primer Nombre
                                    <input wire:model="primernombre_abogado" type="text"
                                        class="block rounded-lg mt-2 w-full">
                                    @error('primernombre')
                                        <span class="text-red-500 text-xs mt-3 block ">{{ $message }}</span>
                                    @enderror
                                </x-label>

                                <x-label>
                                    Segundo Nombre
                                    <input wire:model="segundonombre_abogado" type="text"
                                        class="block rounded-lg mt-2 w-full">
                                    @error('segundonombre')
                                        <span class="text-red-500 text-xs mt-3 block ">{{ $message }}</span>
                                    @enderror
                                </x-label>

                                <x-label>
                                    Primer Apellido
                                    <input wire:model="primerapellido_abogado" type="text"
                                        class="block rounded-lg mt-2 w-full">
                                    @error('primerapellido')
                                        <span class="text-red-500 text-xs mt-3 block ">{{ $message }}</span>
                                    @enderror
                                </x-label>

                                <x-label>
                                    Segundo Apellido
                                    <input wire:model="segundoapellido_abogado" type="text"
                                        class="block rounded-lg mt-2 w-full">
                                    @error('segundoapellido')
                                        <span class="text-red-500 text-xs mt-3 block ">{{ $message }}</span>
                                    @enderror
                                </x-label>

                                <x-label>
                                    Sexo
                                    <select class="block rounded-lg mt-2 w-full" wire:model="sexo_abogado">
                                        <option selected value="" class="rounded-lg">Seleccione una opción...
                                        </option>
                                        <option value="M">Masculino</option>
                                        <option value="F">Femenino</option>
                                    </select>
                                    @error('sexo_abogado')
                                        <span class="text-red-500 text-xs mt-3 block ">{{ $message }}</span>
                                    @enderror
                                </x-label>

                                <x-label>
                                    Teléfono
                                    <input x-data x-model="telefono_abogado" x-ref="telefono_abogado"
                                        @input="
                                    let value = $refs.telefono_abogado.value.replace(/\D/g, '');
                                        if (value.length > 4) {
                                        value = value.substring(0, 4) + '-' + value.substring(4, 12);
                                        }
                                        $refs.telefono_abogado.value = value.substring(0, 13);
                                        $dispatch('input', value);
                                    "
                                        wire:model="telefono_abogado" class="block rounded-lg mt-2 w-full"
                                        type="text">
                                    @error('telefono')
                                        <span class="text-red-500 text-xs mt-3 block ">{{ $message }}</span>
                                    @enderror
                                </x-label>

                                <x-label>
                                    Teléfono Local
                                    <input x-data x-model="telefonolcal_abogado" x-ref="telefonolcal_abogado"
                                        @input="
                                    let value = $refs.telefonolcal_abogado.value.replace(/\D/g, '');
                                        if (value.length > 4) {
                                        value = value.substring(0, 4) + '-' + value.substring(4, 12);
                                        }
                                        $refs.telefonolcal_abogado.value = value.substring(0, 13);
                                        $dispatch('input', value);
                                    "
                                        wire:model="telefonolocal_abogado" class="block rounded-lg mt-2 w-full"
                                        type="text">
                                    @error('telefono_local')
                                        <span class="text-red-500 text-xs mt-3 block ">{{ $message }}</span>
                                    @enderror
                                </x-label>

                                <x-label>
                                    Email
                                    <input wire:model="email_abogado" type="email"
                                        class="block rounded-lg mt-2 w-full" placeholder="ejemplo@correo.com">
                                    @error('email_abogado')
                                        <span class="text-red-500 text-xs mt-3 block ">{{ $message }}</span>
                                    @enderror
                                </x-label>

                                <h3 class="text-center col-span-3 text-lg"> Dirección Domicilial del Abogado </h3>
                                <x-label>
                                    Estado
                                    <select wire:model.change="ubicaciones.abogado.estado"
                                        class="block rounded-lg mt-2 w-full">
                                        <option value="">Seleccione un estado</option>
                                        @foreach ($ubicaciones['abogado']['estados'] as $estado)
                                            <option value="{{ $estado->id }}">{{ $estado->nombre }}</option>
                                        @endforeach
                                    </select>
                                </x-label>
                                <x-label>
                                    Municipio
                                    <select wire:model.change="ubicaciones.abogado.municipio"
                                        class="block rounded-lg mt-2 w-full">
                                        <option value="">Seleccione un municipio</option>
                                        @foreach ($ubicaciones['abogado']['municipios'] as $municipio)
                                            <option value="{{ $municipio->id }}">{{ $municipio->nombre }}</option>
                                        @endforeach
                                    </select>
                                </x-label>
                                <x-label>
                                    Parroquia
                                    <select wire:model.change="ubicaciones.abogado.parroquia"
                                        class="block rounded-lg mt-2 w-full">
                                        <option value="">Seleccione una parroquia</option>
                                        @foreach ($ubicaciones['abogado']['parroquias'] as $parroquia)
                                            <option value="{{ $parroquia->id }}">{{ $parroquia->nombre }}</option>
                                        @endforeach
                                    </select>
                                </x-label>

                                <x-label>
                                    Calle
                                    <input wire:model="ubicaciones.abogado.calle" class="block rounded-lg mt-2 w-full"
                                        type="text">
                                    @error('calle_abogado')
                                        <span class="text-red-500 text-xs mt-3 block ">{{ $message }}</span>
                                    @enderror

                                </x-label>
                                <x-label>
                                    Casa / Edificio
                                    <input wire:model="ubicaciones.abogado.casa_edificio"
                                        class="block rounded-lg mt-2 w-full" type="text">
                                    @error('casa_edificio_abogado')
                                        <span class="text-red-500 text-xs mt-3 block ">{{ $message }}</span>
                                    @enderror
                                </x-label>
                                <x-label>
                                    Piso
                                    <input wire:model="ubicaciones.abogado.piso" class="block rounded-lg mt-2 w-full"
                                        type="text">
                                    @error('piso_abogado')
                                        <span class="text-red-500 text-xs mt-3 block ">{{ $message }}</span>
                                    @enderror
                                </x-label>
                                <x-label>
                                    Apartamento
                                    <input wire:model="ubicaciones.abogado.apartamento"
                                        class="block rounded-lg mt-2 w-full" type="text">
                                    @error('apartamento_abogado')
                                        <span class="text-red-500 text-xs mt-3 block ">{{ $message }}</span>
                                    @enderror
                                </x-label>
                        </div>
                        @endif
                    </form>

                    <div class="grid grid-cols-9 gap-4 mt-3">
                        <!-- Botón Anterior -->
                        @if($currentStep > 1)
                            <div class="col-span-3">
                                <button type="button" wire:click="{{$showAssigned ? 'prevStep' : 'prevprevStep'}}"
                                    class="w-full px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium rounded-md shadow-sm transition duration-150 ease-in-out">
                                    Anterior
                                </button>
                            </div>
                        @else
                            <div class="col-span-3"></div> <!-- Espacio vacío para mantener el layout -->
                        @endif

                        <!-- Espacio intermedio -->
                        <div class="col-span-3"></div>

                        <!-- Botón Siguiente/Enviar -->
                        @if($currentStep < $totalSteps)
                            <div class="col-span-3">
                                <button type="button" wire:click="{{$showAssigned ? 'nextStep' : 'nextnextStep'}}"
                                    class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md shadow-sm transition duration-150 ease-in-out">
                                    Siguiente
                                </button>
                            </div>
                        @else
                            <div class="col-span-3">
                                <button type="submit"
                                    class="w-full py-2 px-4 bg-gradient-to-r from-blue-600 to-blue-800 hover:from-blue-700 hover:to-blue-900 text-white font-medium rounded-md shadow-md transition duration-300 ease-in-out">
                                    Enviar
                                </button>
                            </div>
                        @endif
                        @endif
                    </div>

                </div>
            </div>



        </div>
