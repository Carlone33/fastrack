<div>
    <div>
        <div class="py-2">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <h1
                        class="bg-gradient-to-r from-blue-600 to-blue-800 text-white  col-start-1 col-span-3 text-center text-xl  mb-3  border-t border-b py-4">
                        Exclusión por Registro Policial</h1>

                    <form wire:submit.prevent="submit" class="mt-5 mr-5 ml-5 mb-5">
                        <div class="grid grid-cols-3 gap-4">

                            <div
                                class="mx-auto bg-gradient-to-r from-blue-600 to-blue-700 text-white text-center border-t border-b py-2 px-2 rounded-lg">
                                Nº GUIA:
                                {{-- <input type="text" value=" --}}
                                {{ $guia }}
                                {{-- " class="rounded-lg" readonly></input> --}}
                            </div>

                            @if ($currentStep === 1)
                                <h3 class="col-span-3 text-center text-lg">Caso de solicitud</h3>
                                <h2 class="col-span-3 text-center text-lg">¿Quién está entregando la solicitud?</h2>
                                <x-label class="col-span-3  mx-auto">
                                    <select wire:model.change="showAssigned" class="rounded-lg block mt-2 w-full">
                                        <option value="0" selected>Seleccione una opción...</option>
                                        <option value="1">Solicitante apoderado</option>
                                        <option value="2">Solicitante directo</option>
                                    </select>
                                </x-label></br>



                                {{-- <x-label class="col-start-1 flex items-cen ter">
                                <x-checkbox wire:click="toggleAssigned" class="h-6 w-6 mr-3" />
                                <span class="text-xl font-bold">Con Apoderado</span>
                            </x-label> --}}
                            @endif


                            @if ($currentStep == 2)


                                <h3 class="col-span-3 text-center text-lg">Datos del Solicitante</h3>
                                @if ($showAssigned == 2)
                                    <x-label>

                                        @if ($foto)
                                            <img class="rounded-lg mx-auto w-40 h-40"
                                                src="{{ asset('storage/' . $foto->store('fotos', 'public')) }}">
                                        @else
                                            <img class="rounded-lg mx-auto w-40 h-40"
                                                src="{{ asset('images/default-avatar.jpg') }}">
                                        @endif
                                        <input type="file" wire:model="foto" class="hidden" ref="foto">
                                        {{-- <button type="button" class="bg-gradient-to-r from-blue-600 to-blue-800 hover:from-blue-700 hover:to-blue-900 text-white font-medium py-2 px-4 flex items-center justify-center mt-2 rounded-md shadow-md transition duration-300 ease-in-out mx-auto" onclick="$refs.foto.click()">
                                    Subir Foto
                                </button> --}}
                                        @error('foto')
                                            <span class="text-red-500 text-xs mt-3 block">{{ $message }}</span>
                                        @enderror
                                    </x-label>

                                @endif


                                <x-label>
                                    Nacionalidad
                                    <select class=" rounded-lg block mt-2 w-full" wire:model="nacionalidad">
                                        <option selected value="">Seleccione una opción...</option>
                                        <option value="V">Venezolano</option>
                                        <option value="E">Extranjero</option>
                                    </select>
                                    @error('nacionalidad')
                                        <span class="text-red-500 text-xs mt-3 block">{{ $message }}</span>
                                    @enderror
                                </x-label>

                                <x-label>
                                    Nº de Cédula
                                    <input type="text" wire:model.live="cedula" class="w-full rounded-lg block mt-2">
                                    @php
                                        $existeCedula = null;
                                        if (!empty($cedula)) {
                                            $existeCedula = \App\Models\Persona::where('cedula', $cedula)->exists();
                                        }
                                    @endphp
                                    @if ($existeCedula)
                                        <span class="text-yellow-600 text-xs mt-2 block">Esta cédula ya existe. Se usará el registro existente.</span>
                                    @endif
                                    @error('cedula')
                                        <span class="text-red-500 text-xs mt-3 block">{{ $message }}</span>
                                    @enderror
                                </x-label>

                                <x-label>
                                    Primer Nombre
                                    <input type="text" wire:model="primernombre"
                                        class="w-full rounded-lg block mt-2">
                                    @error('primernombre')
                                        <span class="text-red-500 text-xs mt-3 block">{{ $message }}</span>
                                    @enderror
                                </x-label>

                                <x-label>
                                    Segundo Nombre
                                    <input type="text" wire:model="segundonombre"
                                        class="w-full rounded-lg block mt-2">
                                    @error('segundonombre')
                                        <span class="text-red-500 text-xs mt-3 block">{{ $message }}</span>
                                    @enderror
                                </x-label>

                                <x-label>
                                    Primer Apellido
                                    <input type="text" wire:model="primerapellido"
                                        class="w-full rounded-lg block mt-2">
                                    @error('primerapellido')
                                        <span class="text-red-500 text-xs mt-3 block">{{ $message }}</span>
                                    @enderror
                                </x-label>

                                <x-label>
                                    Segundo Apellido
                                    <input type="text" wire:model="segundoapellido"
                                        class="w-full rounded-lg block mt-2">
                                    @error('segundoapellido')
                                        <span class="text-red-500 text-xs mt-3 block">{{ $message }}</span>
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
                                        placeholder="0412-34567890" pattern="^0\d{3}-\d{7}$" maxlength="12">
                                    @error('telefono')
                                        <span class="text-red-500 text-xs mt-3 block ">{{ $message }}</span>
                                    @enderror
                                </x-label>

                                <x-label>
                                    Teléfono Local
                                    <input x-data x_model="telefonolocal" x-ref="telefonolocal"
                                        @input="
                                let value = $refs.telefonolocal.value.replace(/\D/g, '');
                                    if (value.length > 4) {
                                    value = value.substring(0, 4) + '-' + value.substring(4, 12);
                                    }
                                    $refs.telefonolocal.value = value.substring(0, 13);
                                    $dispatch('input', value);
                                "
                                        wire:model.change="telefonolocal" class="block rounded-lg mt-2 w-full"
                                        type="tel" placeholder="0412-34567890">
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

                                {{-- Dirección del Solicitante --}}
                                <x-label>
                                    Calle
                                    <input wire:model="ubicaciones.solicitante.calle"
                                        class="block rounded-lg mt-2 w-full" type="text">
                                    @error('ubicaciones.solicitante.calle')
                                        <span class="text-red-500 text-xs mt-3 block ">{{ $message }}</span>
                                    @enderror
                                </x-label>
                                <x-label>
                                    Casa / Edificio
                                    <input wire:model="ubicaciones.solicitante.casa_edificio"
                                        class="block rounded-lg mt-2 w-full" type="text">
                                    @error('ubicaciones.solicitante.casa_edificio')
                                        <span class="text-red-500 text-xs mt-3 block ">{{ $message }}</span>
                                    @enderror
                                </x-label>
                                <x-label>
                                    Piso
                                    <input wire:model="ubicaciones.solicitante.piso"
                                        class="block rounded-lg mt-2 w-full" type="text">
                                    @error('ubicaciones.solicitante.piso')
                                        <span class="text-red-500 text-xs mt-3 block ">{{ $message }}</span>
                                    @enderror
                                </x-label>
                                <x-label>
                                    Apartamento
                                    <input wire:model="ubicaciones.solicitante.apartamento"
                                        class="block rounded-lg mt-2 w-full" type="text">
                                    @error('ubicaciones.solicitante.apartamento')
                                        <span class="text-red-500 text-xs mt-3 block ">{{ $message }}</span>
                                    @enderror
                                </x-label>
                            @endif



                            @if ($currentStep == 3)


                                <h3 class="col-span-3 text-center text-lg">Datos del apoderado</h3>

                                @if ($showAssigned == 1)
                                    <x-label>
                                        @if ($foto)
                                            <img class="rounded-lg mx-auto w-40 h-40"
                                                src="{{ asset('storage/' . $foto->store('fotos', 'public')) }}">
                                        @else
                                            <img class="rounded-lg mx-auto w-40 h-40"
                                                src="{{ asset('images/default-avatar.jpg') }}">
                                        @endif
                                        <input type="file" wire:model="foto" class="hidden" ref="foto">
                                        {{-- <button type="button" class="bg-gradient-to-r from-blue-600 to-blue-800 hover:from-blue-700 hover:to-blue-900 text-white font-medium py-2 px-4 flex items-center justify-center mt-2 rounded-md shadow-md transition duration-300 ease-in-out mx-auto" onclick="$refs.foto.click()">
                        Subir Foto
                    </button> --}}
                                        @error('foto')
                                            <span class="text-red-500 text-xs mt-3 block">{{ $message }}</span>
                                        @enderror
                                    </x-label>
                                @endif

                                <x-label>
                                    Nacionalidad
                                    <select class="block rounded-lg mt-2 w-full" wire:model="nacionalidad_apoderado">
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
                                    <input x-data x_model="telefono_apoderado" x-ref="telefono_apoderado"
                                        @input="
                                let value = $refs.telefono_apoderado.value.replace(/\D/g, '');
                                    if (value.length > 4) {
                                    value = value.substring(0, 4) + '-' + value.substring(4, 12);
                                    }
                                    $refs.telefono_apoderado.value = value.substring(0, 13);
                                    $dispatch('input', value);
                                "
                                        wire:model="telefono_apoderado" class="block rounded-lg mt-2 w-full"
                                        type="tel" placeholder="0412-34567890">
                                    @error('telefono')
                                        <span class="text-red-500 text-xs mt-3 block ">{{ $message }}</span>
                                    @enderror
                                </x-label>

                                <x-label>
                                    Teléfono Local
                                    <input x-data x_model="telefonolocal_apoderado" x-ref="telefonolocal_apoderado"
                                        @input="
                                let value = $refs.telefonolocal_apoderado.value.replace(/\D/g, '');
                                    if (value.length > 4) {
                                    value = value.substring(0, 4) + '-' + value.substring(4, 12);
                                    }
                                    $refs.telefonolocal_apoderado.value = value.substring(0, 13);
                                    $dispatch('input', value);
                                "
                                        wire:model="telefonolocal_apoderado" class="block rounded-lg mt-2 w-full"
                                        type="tel" placeholder="0412-34567890" pattern="^04\d{2}-\d{8}$">
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

                                {{-- Dirección del Apoderado --}}
                                <x-label>
                                    Calle
                                    <input wire:model="ubicaciones.apoderado.calle"
                                        class="block rounded-lg mt-2 w-full" type="text">
                                    @error('ubicaciones.apoderado.calle')
                                        <span class="text-red-500 text-xs mt-3 block ">{{ $message }}</span>
                                    @enderror
                                </x-label>
                                <x-label>
                                    Casa / Edificio
                                    <input wire:model="ubicaciones.apoderado.casa_edificio"
                                        class="block rounded-lg mt-2 w-full" type="text">
                                    @error('ubicaciones.apoderado.casa_edificio')
                                        <span class="text-red-500 text-xs mt-3 block ">{{ $message }}</span>
                                    @enderror
                                </x-label>
                                <x-label>
                                    Piso
                                    <input wire:model="ubicaciones.apoderado.piso"
                                        class="block rounded-lg mt-2 w-full" type="text">
                                    @error('ubicaciones.apoderado.piso')
                                        <span class="text-red-500 text-xs mt-3 block ">{{ $message }}</span>
                                    @enderror
                                </x-label>
                                <x-label>
                                    Apartamento
                                    <input wire:model="ubicaciones.apoderado.apartamento"
                                        class="block rounded-lg mt-2 w-full" type="text">
                                    @error('ubicaciones.apoderado.apartamento')
                                        <span class="text-red-500 text-xs mt-3 block ">{{ $message }}</span>
                                    @enderror
                                </x-label>

                            @endif


                            @if ($currentStep === 4)
                                <h3 class="text-center col-span-3 text-lg"> Información de Solicitud de Exclusión </h3>

                                <x-label>
                                    Delito
                                    <input type="text" wire:model="delito" class="w-full rounded-lg block mt-2">
                                    @error('delito')
                                        <span class="text-red-500 text-xs mt-3 block">{{ $message }}</span>
                                    @enderror
                                </x-label>

                                <h3 class="text-center col-span-3 text-lg"> Documentos para la Solicitud de Exclusión
                                </h3>

                                <div class="space-y-6">
                                    <!-- Input 1 - para foto_cedula_solicitante -->
                                    <div x-data="{ previewUrl: null, fileName: null }" class="flex flex-col">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Foto Cédula Solicitante
                                        </label>

                                        <!-- Input oculto con estilos personalizados -->
                                        <div class="relative">
                                            <input type="file" wire:model="foto_cedula_solicitante"
                                                x-ref="fileInput"
                                                @change="
                                                    fileName = $event.target.files[0]?.name;
                                                    const file = $event.target.files[0];
                                                    if (file && file.type.startsWith('image/')) {
                                                        const reader = new FileReader();
                                                        reader.onload = (e) => previewUrl = e.target.result;
                                                        reader.readAsDataURL(file);
                                                    }
                                                "
                                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">

                                            <!-- Diseño visual personalizado -->
                                            <div
                                                class="flex items-center justify-between px-4 py-3 bg-white border border-gray-300 rounded-md shadow-sm">
                                                <span x-text="fileName || 'Seleccionar imagen'"
                                                    class="truncate max-w-xs"></span>
                                                <svg class="w-5 h-5 text-gray-500" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                                    </path>
                                                </svg>
                                            </div>
                                        </div>

                                        <!-- Previsualización de imagen -->
                                        <template x-if="previewUrl">
                                            <div class="mt-3">
                                                <img :src="previewUrl"
                                                    class="max-w-full h-auto max-h-40 rounded-md border border-gray-200">
                                                <button
                                                    @click="previewUrl = null; fileName = null; $refs.fileInput.value = ''"
                                                    class="mt-2 text-sm text-red-600 hover:text-red-800">
                                                    Eliminar previsualización
                                                </button>
                                            </div>
                                        </template>

                                        <!-- Mensaje de validación de Livewire -->
                                        @error('foto_cedula_solicitante')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                @if ($showAssigned == 1)
                                    <div class="space-y-6">
                                        <!-- Input 2 - para foto_cedula_apdoerado -->
                                        <div x-data="{ previewUrl: null, fileName: null }" class="flex flex-col">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                                Foto Cédula Apoderado
                                            </label>

                                            <!-- Input oculto con estilos personalizados -->
                                            <div class="relative">
                                                <input type="file" wire:model="foto_cedula_apoderado"
                                                    x-ref="fileInput"
                                                    @change="
                                                    fileName = $event.target.files[0]?.name;
                                                    const file = $event.target.files[0];
                                                    if (file && file.type.startsWith('image/')) {
                                                        const reader = new FileReader();
                                                        reader.onload = (e) => previewUrl = e.target.result;
                                                        reader.readAsDataURL(file);
                                                    }
                                                "
                                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">

                                                <!-- Diseño visual personalizado -->
                                                <div
                                                    class="flex items-center justify-between px-4 py-3 bg-white border border-gray-300 rounded-md shadow-sm">
                                                    <span x-text="fileName || 'Seleccionar imagen'"
                                                        class="truncate max-w-xs"></span>
                                                    <svg class="w-5 h-5 text-gray-500" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                                        </path>
                                                    </svg>
                                                </div>
                                            </div>

                                            <!-- Previsualización de imagen -->
                                            <template x-if="previewUrl">
                                                <div class="mt-3">
                                                    <img :src="previewUrl"
                                                        class="max-w-full h-auto max-h-40 rounded-md border border-gray-200">
                                                    <button
                                                        @click="previewUrl = null; fileName = null; $refs.fileInput.value = ''"
                                                        class="mt-2 text-sm text-red-600 hover:text-red-800">
                                                        Eliminar previsualización
                                                    </button>
                                                </div>
                                            </template>

                                            <!-- Mensaje de validación de Livewire -->
                                            @error('foto_cedula_solicitante')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                @endif

                                @if ($showAssigned == 1)
                                    <div class="space-y-6">
                                        <!-- Input 3 - para foto_poder -->
                                        <div x-data="{ previewUrl: null, fileName: null }" class="flex flex-col">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                                Foto Poder
                                            </label>

                                            <!-- Input oculto con estilos personalizados -->
                                            <div class="relative">
                                                <input type="file" wire:model="foto_poder" x-ref="fileInput"
                                                    @change="
                                                    fileName = $event.target.files[0]?.name;
                                                    const file = $event.target.files[0];
                                                    if (file && file.type.startsWith('image/')) {
                                                        const reader = new FileReader();
                                                        reader.onload = (e) => previewUrl = e.target.result;
                                                        reader.readAsDataURL(file);
                                                    }
                                                "
                                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">

                                                <!-- Diseño visual personalizado -->
                                                <div
                                                    class="flex items-center justify-between px-4 py-3 bg-white border border-gray-300 rounded-md shadow-sm">
                                                    <span x-text="fileName || 'Seleccionar imagen'"
                                                        class="truncate max-w-xs"></span>
                                                    <svg class="w-5 h-5 text-gray-500" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                                        </path>
                                                    </svg>
                                                </div>
                                            </div>

                                            <!-- Previsualización de imagen -->
                                            <template x-if="previewUrl">
                                                <div class="mt-3">
                                                    <img :src="previewUrl"
                                                        class="max-w-full h-auto max-h-40 rounded-md border border-gray-200">
                                                    <button
                                                        @click="previewUrl = null; fileName = null; $refs.fileInput.value = ''"
                                                        class="mt-2 text-sm text-red-600 hover:text-red-800">
                                                        Eliminar previsualización
                                                    </button>
                                                </div>
                                            </template>

                                            <!-- Mensaje de validación de Livewire -->
                                            @error('foto_cedula_solicitante')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                @endif
                            @endif

                            @if ($currentStep === 5)
                                <h3 class="text-center col-span-3 text-lg">Selección del abogado</h3>
                                <div class="col-span-3 mb-52"><!-- Aquí agregas mb-10 o el valor que prefieras -->
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Selecciona un abogado
                                    </label>
                                    <x-select
                                        placeholder="Escribe para buscar"
                                        wire:model="abogado_id"
                                        :async-data="route('buscar.abogados')"
                                        option-label="nombre_completo"
                                        option-value="id"
                                        :searchable="true"
                                    />
                                    @error('abogado_id')
                                        <span class="text-red-500 text-xs mt-3 block">{{ $message }}</span>
                                    @enderror
                                </div>
                            @endif

                        </div>



                        <div class="grid grid-cols-9 gap-4 mt-3">
                            <!-- Botón Anterior -->
                            @if ($currentStep > 1)
                                <div class="col-span-3">
                                    <button type="button" wire:click="prevStep"
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
                            @if ($currentStep < $totalSteps)
                                <div class="col-span-3">
                                    <button type="button" wire:click="nextStep"
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
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
