<div>
    <h1 class="text-lg text-center mt-6">Interfaz de Administrador del Sistema</h1>
    <div class="max-w-7xl mx-auto sm:py-9 sm:px-6 lg:px-8">
        <span class="block text-center">
            <div class="flex justify-end mx-auto px-6 mb-4">
                @can('Crear usuarios')
                    <div class="flex flex-col md:flex-row justify-between items-center">
                        <button wire:click="abrirModalYEnviarparaCrear(true)">
                            <x-icons.agregar />
                        </button>
                    </div>
                @endcan
                <input wire:model.live.debounce.500ms="search" type="text" placeholder="Buscar..."
                    class="bg-gray-100 ml-2 rounded px-4 py-2 hover:bg-gray-100 center justify-self-stretch" /><br><br>

            </div>
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <table class="table-fixed w-full center text-center ">
                    <thead>
                        <tr class="bg-gradient-to-r from-blue-600 to-blue-800 text-white">
                            <th>Nombre del funcionario</th>
                            <th>Cedula</th>
                            <th>Credencial</th>
                            {{-- <th>Unidad administrativa</th> --}}
                            @can('Ver usuarios')
                                <th class="w-24">Consulta</th>
                            @endcan
                            @can('Editar usuarios')
                                <th class="w-24">Editar</th>
                            @endcan
                            @can('Eliminar usuarios')
                                <th class="w-24">Habilitado</th>
                            @endcan
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($this->funcionarios as $funcionario)
                            @if ($funcionario->eliminado == false)
                                <tr class="h-10">
                                    <td class="border border-b-gray-300 border-t-gray-300">
                                        {{ $funcionario->primer_nombre . ' ' . $funcionario->primer_apellido }}
                                    </td>
                                    <td class="border border-b-gray-300 border-t-gray-300">{{ $funcionario->cedula }}
                                    </td>
                                    <td class="border border-b-gray-300 border-t-gray-300">
                                        {{ $funcionario->credencial }}
                                    </td>
                                    <td class="w-24 border border-b-gray-300 border-t-gray-300">
                                        @can('Ver usuarios')
                                            <button onclick="window.location.href='{{ route('funcionarios.consultar', ['id' => $funcionario->id, 'modo' => 'consultar']) }}'">
                                                <x-icons.consulta />
                                            </button>
                                        @endcan
                                    </td>
                                    <td class="w-24 border border-b-gray-300 border-t-gray-300">
                                        @can('Editar usuarios')
                                            <button onclick="window.location.href='{{ route('funcionarios.consultar', ['id' => $funcionario->id, 'modo' => 'editar']) }}'">
                                                <x-icons.editar />
                                            </button>
                                        @endcan
                                    </td>
                                    <td class="w-24 border border-b-gray-300 border-t-gray-300">
                                        @can('Eliminar usuarios')
                                            @if ($funcionario->habilitado == true)
                                                <button wire:click=" EnviarparaInhabilitar({{ $funcionario->id }})">
                                                    <x-icons.habilitar />
                                                </button>
                                            @else
                                                <button wire:click="EnviarparaHabilitar({{ $funcionario->id }})" >
                                                    <x-icons.inhabilitar />
                                                </button>
                                            @endif
                                        @endcan
                                    </td>
                                </tr>
                                {{-- Ya no se muestra el modal inline, ahora se navega a la vista compartida --}}
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $this->funcionarios->links() }}
        </span>


        {{-- Modal de abrir controlador Livewire del Formulario de Crear --}}
        <div x-data="{ open: false }" x-on:abrir-modal-crear.window="open = true">
            <div x-show="open" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50">
                <div class="bg-white p-6 rounded shadow-lg">
                    @livewire('administrador.crear')
                    <button @click="open = false; $wire.limpiarCampos()"
                        class="mt-4 bg-red-500 text-white px-4 py-2 rounded">Cerrar
                        Modal</button>
                </div>
            </div>
        </div>


        {{-- Modal de abrir controlador Livewire del Formulario de Editar --}}
        <div x-data="{ open: false }" x-on:abrir-modal-editar.window="open = true">
            <div x-show="open" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50">
                <div class="bg-white p-6 rounded shadow-lg">
                    @livewire('administrador.editar')
                    <button @click="open = false; $wire.limpiarCampos()"
                        class="mt-4 bg-red-500 text-white px-4 py-2 rounded">Cerrar
                        Modal</button>
                </div>
            </div>
        </div>


        {{-- Modal de abrir controlador Livewire del Formulario de Consultar --}}
        <div x-data="{ open: false }" x-on:abrir-modal-consultar.window="open = true" <div x-data="{ open: false }"
            x-on:abrir-modal-consultar.window="open = true" x-on:cerrar-modal-consultar.window="open = false">
            <div x-show="open" ...>
                <div class="bg-white ...">
                    @livewire('administrador.consultar')
                </div>
            </div>
        </div>
    </div>



</div>
</div>
