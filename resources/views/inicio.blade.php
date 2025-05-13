<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Inicio') }}
        </h2>
    </x-slot>

    <div class="py-12 flex flex-col items-center">
        <div class="flex justify-center mb-6">
            <x-icons.alert />
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <span class="block text-center">
                    Se le recuerda al usuario que entre aqui que este es un sistema bla bla bla
                </span>
            </div>
        </div>
    </div>
</x-app-layout>
