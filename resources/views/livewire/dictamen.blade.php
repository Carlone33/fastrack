<div>
    <div>
        <div class="py-2">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <h1 class="bg-gradient-to-r from-blue-600 to-blue-800 text-white col-start-1 col-span-4 text-center text-xl mb-3 border-t border-b py-4">Exclusión por Dictamen</h1>

                    <form wire:submit.prevent="submit" class="mt-5 mr-5 ml-5 mb-5">
                        <div class="grid grid-cols-3 gap-4">
                            <x-label>
                                @if ($foto)
                                    <img class="rounded-lg mx-auto w-40 h-40" src="{{ asset('storage/' . $foto->store('fotos', 'public')) }}">
                                @else
                                    <img class="rounded-lg mx-auto w-40 h-40" src="{{ asset('images/default-avatar.jpg') }}">
                                @endif
                                <input type="file" wire:model="foto" class="hidden" ref="foto">
                                <button type="button" class="bg-gradient-to-r from-blue-600 to-blue-800 hover:from-blue-700 hover:to-blue-900 text-white font-medium py-2 px-4 flex items-center justify-center mt-2 rounded-md shadow-md transition duration-300 ease-in-out mx-auto" onclick="$refs.foto.click()">
                                    Subir Foto
                                </button>
                                @error('foto')
                                    <span class="text-red-500 text-xs mt-3 block">{{ $message }}</span>
                                @enderror
                            </x-label>

                            <x-label>
                                Nº de Guía
                                <input type="text" wire:model="guia" class="block rounded-lg mt-2 w-full">
                                @error('guia')
                                    <span class="text-red-500 text-xs mt-3 block">{{ $message }}</span>
                                @enderror
                            </x-label>

                            <x-label>
                                Nº de Cedula
                                <input type="text" wire:model="cedula" class="block rounded-lg mt-2 w-full">
                                @error('cedula')
                                    <span class="text-red-500 text-xs mt-3 block">{{ $message }}</span>
                                @enderror
                            </x-label>

                            <x-label>
                                Nombre
                                <input type="text" wire:model="nombre" class="block rounded-lg mt-2 w-full">
                                @error('nombre')
                                    <span class="text-red-500 text-xs mt-3 block">{{ $message }}</span>
                                @enderror
                            </x-label>

                            <x-label>
                                Apellido
                                <input type="text" wire:model="apellido" class="block rounded-lg mt-2 w-full">
                                @error('apellido')
                                    <span class="text-red-500 text-xs mt-3 block">{{ $message }}</span>
                                @enderror
                            </x-label>

                            <x-label>
                                Dirección domicilial
                                <input type="text" wire:model="direccion" class="block rounded-lg mt-2 w-full">
                                @error('direccion')
                                    <span class="text-red-500 text-xs mt-3 block">{{ $message }}</span>
                                @enderror
                            </x-label>

                            <x-label>
                                Teléfono
                                <input type="text" wire:model="telefono" class="block rounded-lg mt-2 w-full">
                                @error('telefono')
                                    <span class="text-red-500 text-xs mt-3 block">{{ $message }}</span>
                                @enderror
                            </x-label>

                            <x-label>
                                Teléfono Local
                                <input type="text" wire:model="telefonolocal" class="block rounded-lg mt-2 w-full">
                                @error('telefonolocal')
                                    <span class="text-red-500 text-xs mt-3 block">{{ $message }}</span>
                                @enderror
                            </x-label>

                            <x-label>
                                Estado del ciudadano
                                <input type="text" wire:model="estado_ciudadano" class="block rounded-lg mt-2 w-full">
                                @error('estado_ciudadano')
                                    <span class="text-red-500 text-xs mt-3 block">{{ $message }}</span>
                                @enderror
                            </x-label>

                            <x-label>
                                Dirección dependencia
                                <input type="text" wire:model="direccion_dependencia" class="block rounded-lg mt-2 w-full">
                                @error('direccion_dependencia')
                                    <span class="text-red-500 text-xs mt-3 block">{{ $message }}</span>
                                @enderror
                            </x-label>

                            <x-label>
                                Delito
                                <input type="text" wire:model="delito" class="block rounded-lg mt-2 w-full">
                                @error('delito')
                                    <span class="text-red-500 text-xs mt-3 block">{{ $message }}</span>
                                @enderror
                            </x-label>

                            <x-label>
                                Fecha inicio
                                <input type="date" wire:model="fecha_inicio" class="block rounded-lg mt-2 w-full">
                                @error('fecha_inicio')
                                    <span class="text-red-500 text-xs mt-3 block">{{ $message }}</span>
                                @enderror
                            </x-label>

                            <x-label>
                                Fecha final
                                <input type="date" wire:model="fecha_final" class="block rounded-lg mt-2 w-full">
                                @error('fecha_final')
                                    <span class="text-red-500 text-xs mt-3 block">{{ $message }}</span>
                                @enderror
                            </x-label>

                            <h2 class="bg-gradient-to-r from-blue-600 to-blue-800 text-white col-span-3 text-center text-xl mt-3 mb-3 border-t border-b py-4">
                                Información del abogado
                            </h2>

                            <x-label>
                                Nombre
                                <input type="text" wire:model="nombre_abogado" class="block rounded-lg mt-2 w-full">
                                @error('nombre_abogado')
                                    <span class="text-red-500 text-xs mt-3 block">{{ $message }}</span>
                                @enderror
                            </x-label>

                            <x-label>
                                Apellido
                                <input type="text" wire:model="apellido_abogado" class="block rounded-lg mt-2 w-full">
                                @error('apellido_abogado')
                                    <span class="text-red-500 text-xs mt-3 block">{{ $message }}</span>
                                @enderror
                            </x-label>

                            <x-label>
                                Cedula
                                <input type="text" wire:model="cedula_abogado" class="block rounded-lg mt-2 w-full">
                                @error('cedula_abogado')
                                    <span class="text-red-500 text-xs mt-3 block">{{ $message }}</span>
                                @enderror
                            </x-label>

                            <x-label>
                                Teléfono
                                <input type="text" wire:model="telefono_abogado" class="block rounded-lg mt-2 w-full">
                                @error('telefono_abogado')
                                    <span class="text-red-500 text-xs mt-3 block">{{ $message }}</span>
                                @enderror
                            </x-label>
                        </div>
                        <div class="grid grid-cols-9 mt-3">
                            <button type="submit" class="col-start-9 col-span-1 py-3 px-6 bg-gradient-to-r from-blue-600 to-blue-800 hover:from-blue-700 hover:to-blue-900 text-base font-medium text-white rounded-md shadow-md transition duration-300 ease-in-out text-center justify-center">Enviar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
