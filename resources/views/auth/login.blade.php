<x-guest-layout>
    @if (session('user_id'))

        @php
            $rifa = session('rifa');
            // Validar que $rifa sea un array y tenga al menos dos elementos
            $pregunta1 = null;
            if (is_array($rifa) && count($rifa) >= 1) {
                shuffle($rifa);
                $pregunta1 = $rifa[0];
                $pregunta2 = $rifa[1];
                $preguntasUsadas = [
                    'pregunta1' => $rifa[0],
                ];
                session()->put('orden', $preguntasUsadas);
            }
        @endphp

        @if ($pregunta1)
            <div class="min-h-screen flex items-center justify-center bg-gray-100">
                <div class="max-w-xl w-full sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
                        <h2 class="text-2xl font-bold mb-6 text-center text-gray-700">Pregunta de Seguridad</h2>
                        <form method="POST" action="{{ route('preguntas.verificar') }}" class="space-y-6">
                            @csrf
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Pregunta</label>
                                <div class="bg-gray-100 rounded px-3 py-2 mb-2 text-gray-700">{{ $pregunta1 }}</div>
                                <x-password name="respuesta1" type="password" class="mt-2 w-full"
                                    placeholder="Respuesta" />
                            </div>
                            <div class="flex justify-center space-x-4">
                                <x-button type="submit" primary label="Verificar" class="w-full" />
                            </div>
                        </form>

                        <form id="logout-form" action="{{ route('destroy.session') }}" method="POST" class="w-full mt-4">
                            @csrf
                            <button type="submit"
                                class="w-full inline-flex justify-center items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:outline-none focus:border-red-700 focus:ring focus:ring-red-200 active:bg-red-600 transition">
                                Salir
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @else
            <div class="max-w-md mx-auto bg-white p-6 rounded shadow text-center">
                <p class="text-red-600">No se pudo cargar la pregunta de seguridad.</p>
            </div>
        @endif
    @elseif (session()->has('question1'))
        <div class="min-h-screen flex items-center justify-center bg-gray-100">
            <div class="max-w-xl w-full sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
                    <h2 class="text-2xl font-bold mb-6 text-center text-gray-700">¡Atención!</h2>
                    <p class="mb-6 text-gray-700 text-center">
                        Debes establecer tus preguntas de seguridad antes de continuar.
                    </p>
                    <form method="GET" action="{{ route('establecer.preguntas') }}">
                        <div class="flex justify-center">
                            <x-button type="submit" primary label="Establecer preguntas" class="w-full" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @else
        <x-authentication-card>
            <x-slot name="logo">
                <x-authentication-card-logo />
            </x-slot>

            <!-- Mensajes de error personalizados -->
            @if (session('errores'))
                <div class="mb-4 font-medium text-sm text-red-600">
                    <ul>
                        @foreach (session('errores') as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <x-validation-errors class="mb-4" />

            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div>
                    <x-label for="credencial" text="{{ __('Credencial') }}" />
                    <x-input id="credencial" class="block mt-1 w-full" type="text" name="credencial"
                        :value="old('credencial')" required autofocus autocomplete="username" />
                </div>

                <div class="mt-4">
                    <x-label for="password" text="{{ __('Contraseña') }}" />
                    <x-input id="password" class="block mt-1 w-full" type="password" name="password" required
                        autocomplete="current-password" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-button class="ms-4" type="submit">
                        {{ __('Iniciar Sesión') }}
                    </x-button>
                </div>
            </form>
        </x-authentication-card>
    @endif
</x-guest-layout>
