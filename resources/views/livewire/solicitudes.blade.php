<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid bg-white overflow-hidden shadow-xl sm:rounded-lg grid-cols-6">
                <h1 class="bg-gradient-to-r from-blue-600 to-blue-800 text-white col-start-1 col-span-6 text-center text-xl mb-3 border-t border-b py-2">
                    Seleccione el tipo de solicitud
                </h1>
                <select wire:model.change="showAssigned" name="TipoDocumento" id="TipoDocumento" class="col-start-3 col-span-2 mb-5 rounded-lg border border-gray-300 focus:ring focus:ring-blue-500 focus:border-blue-500 appearance-none">
                    <option  selected>Seleccione una opción...</option>
                    <option value="RegistroPolicial" class="border-b border-gray-300 hover:bg-gray-200">Exclusión de Registro Policial</option>
                    <option value="SolicitudAdministrativa" class="border-b border-gray-300 hover:bg-gray-200">Exclusión por Solicitud Administrativa</option>
                    {{-- <option value="Dictamen" class="border-b border-gray-300 hover:bg-gray-200">Dictamen</option> --}}
                    {{-- <option value="RegistroUnico" class="border-b border-gray-300 hover:bg-gray-200">Exclusión de Registro Único</option> --}}
                </select>
            </div>
        </div>

        @switch(@$showAssigned)
        @case('RegistroPolicial')
            @livewire('registro-policial')
            @break
        @case('SolicitudAdministrativa')
            @livewire('solicitud-administrativa')
            @break
        {{-- @case('Dictamen')
            @livewire('dictamen')
            @break
            @case('RegistroUnico')
            @livewire('registro-unico')
            @break--}}
    @endswitch
    </div>


</div>
