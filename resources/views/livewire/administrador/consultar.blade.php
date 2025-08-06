<div class="max-w-3xl mx-auto mt-8 bg-gray-100 min-h-screen">
    @if ($funcionario)
        <div class="bg-white shadow-lg rounded-xl p-8">
            <div class="flex items-center gap-4 mb-8">
                <div class="flex-shrink-0">
                    <div class="w-20 h-20 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 text-4xl font-bold">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-12 h-12">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.657 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 mb-1">
                        {{ $funcionario['persona']['primer_nombre'] ?? '' }} {{ $funcionario['persona']['segundo_nombre'] ?? '' }} {{ $funcionario['persona']['primer_apellido'] ?? '' }} {{ $funcionario['persona']['segundo_apellido'] ?? '' }}
                    </h2>
                    <span class="text-gray-500">{{ $funcionario['persona']['cedula'] ?? '' }} | {{ $funcionario['credencial'] ?? '' }}</span>
                </div>
            </div>
            @include('livewire.administrador.editar-nombres', ['funcionarioData' => $funcionarioData, 'modo' => $modo])
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Nacionalidad</label>
                    <select wire:model.defer="funcionarioData.persona.nacionalidad" class="w-full border rounded px-3 py-2 bg-gray-100" @if($modo !== 'editar') disabled @endif>
                        <option value="V" {{ ($funcionarioData['persona']['nacionalidad'] ?? '') == 'V' ? 'selected' : '' }}>Venezolano</option>
                        <option value="E" {{ ($funcionarioData['persona']['nacionalidad'] ?? '') == 'E' ? 'selected' : '' }}>Extranjero</option>
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Sexo</label>
                    <select wire:model.defer="funcionarioData.persona.sexo" class="w-full border rounded px-3 py-2 bg-gray-100" @if($modo !== 'editar') disabled @endif>
                        <option value="M" {{ ($funcionarioData['persona']['sexo'] ?? '') == 'M' ? 'selected' : '' }}>Masculino</option>
                        <option value="F" {{ ($funcionarioData['persona']['sexo'] ?? '') == 'F' ? 'selected' : '' }}>Femenino</option>
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Correo</label>
                    <input type="email" wire:model.defer="funcionarioData.persona.correo" class="w-full border rounded px-3 py-2 bg-gray-100" value="{{ $funcionarioData['persona']['correo'] ?? '' }}" @if($modo !== 'editar') readonly @endif>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Credencial</label>
                    <input type="text" wire:model.defer="funcionarioData.credencial" class="w-full border rounded px-3 py-2 bg-gray-100" value="{{ $funcionarioData['credencial'] ?? '' }}" @if($modo !== 'editar') readonly @endif>
                </div>
            </div>
            <div class="mt-8 grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Cédula</label>
                    <input type="text" wire:model.defer="funcionarioData.persona.cedula" class="w-full border rounded px-3 py-2 bg-gray-100" value="{{ $funcionarioData['persona']['cedula'] ?? '' }}" readonly>
                </div>
            </div>
            <div class="mt-8 flex justify-end gap-4">
                <a href="{{ route('admin') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded-lg font-semibold">Volver</a>
                @if($modo === 'editar')
                    <button wire:click="guardarCambios" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold">Guardar</button>
                @endif
            </div>
        </div>
    @else
        <div class="col-span-3 text-center text-red-500">No hay datos para mostrar.</div>
    @endif
</div>
