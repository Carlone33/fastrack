<div class="max-w-2xl mx-auto mt-10 mb-10">
    <div class="bg-white shadow-lg rounded-xl p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Registrar nuevo funcionario</h2>
        @if($success)
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">Funcionario y usuario creados correctamente.</div>
        @endif
        @if($error)
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">{{ $error }}</div>
        @endif
        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form wire:submit.prevent="guardarFuncionario">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Primer Nombre</label>
                    <input type="text" wire:model.defer="persona.primer_nombre" class="w-full border rounded px-3 py-2 bg-gray-100" required>
                    @error('persona.primer_nombre')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Segundo Nombre</label>
                    <input type="text" wire:model.defer="persona.segundo_nombre" class="w-full border rounded px-3 py-2 bg-gray-100">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Primer Apellido</label>
                    <input type="text" wire:model.defer="persona.primer_apellido" class="w-full border rounded px-3 py-2 bg-gray-100" required>
                    @error('persona.primer_apellido')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Segundo Apellido</label>
                    <input type="text" wire:model.defer="persona.segundo_apellido" class="w-full border rounded px-3 py-2 bg-gray-100">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Nacionalidad</label>
                    <select wire:model.defer="persona.nacionalidad" class="w-full border rounded px-3 py-2 bg-gray-100">
                    @error('persona.nacionalidad')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                        <option value="V">Venezolano</option>
                        <option value="E">Extranjero</option>
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Cédula</label>
                    <input type="text" wire:model.defer="persona.cedula" class="w-full border rounded px-3 py-2 bg-gray-100" required>
                    @error('persona.cedula')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Sexo</label>
                    <select wire:model.defer="persona.sexo" class="w-full border rounded px-3 py-2 bg-gray-100">
                    @error('persona.sexo')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                        <option value="M">Masculino</option>
                        <option value="F">Femenino</option>
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Correo</label>
                    <input type="email" wire:model.defer="persona.correo" class="w-full border rounded px-3 py-2 bg-gray-100" required>
                    @error('persona.correo')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Credencial</label>
                    <input type="text" wire:model.defer="credencial" class="w-full border rounded px-3 py-2 bg-gray-100" required>
                    @error('credencial')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Rol</label>
                    <select wire:model.defer="rol" class="w-full border rounded px-3 py-2 bg-gray-100" required>
                    @error('rol')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                        <option value="">Seleccione un rol</option>
                        @foreach($this->roles as $role)
                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                    @error('rol')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="mt-8 flex justify-end gap-4">
                <a href="{{ route('admin') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded-lg font-semibold">Cancelar</a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold">Registrar</button>
            </div>
        </form>
    </div>
</div>
