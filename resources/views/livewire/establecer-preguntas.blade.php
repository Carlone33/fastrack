<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="max-w-xl w-full sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
            <h2 class="text-2xl font-bold mb-6 text-center text-gray-700">Establecer Preguntas de Seguridad</h2>
            <form wire:submit.prevent="GuardarPreguntas" class="space-y-6">




                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pregunta 1</label>
                    <x-select id="search-1" wire:model="pregunta_1" placeholder="Seleccione una pregunta"
                        :empty-option="false" :options="[
                            '¿Cuál es tu color favorito?' => '¿Cuál es tu color favorito?',
                            '¿Cómo se llama tu primera mascota?' => '¿Cómo se llama tu primera mascota?',
                            '¿En qué ciudad naciste?' => '¿En qué ciudad naciste?',
                        ]" />
                    <input
                        class="mt-2 w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                        wire:model="respuesta_1" />

                </div>








                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pregunta 2</label>
                    <x-select id="search-2" wire:model.defer="pregunta_2" placeholder="Seleccione una pregunta"
                        :options="[
                            '¿Cuál es tu comida favorita?' => '¿Cuál es tu comida favorita?',
                            '¿Cómo se llama tu abuelo materno?' => '¿Cómo se llama tu abuelo materno?',
                            '¿Cómo se llamaba tu primer colegio?' => '¿Cómo se llamaba tu primer colegio?',
                        ]" />
                    <input
                        class="mt-2 w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                        wire:model="respuesta_2" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pregunta 3</label>
                    <x-select id="search-3" wire:model="pregunta_3" placeholder="Seleccione una pregunta"
                        :options="[
                            '¿Cuál es el nombre de tu mejor amigo de la infancia?' =>
                                '¿Cuál es el nombre de tu mejor amigo de la infancia?',
                            '¿Cuál es tu película favorita?' => '¿Cuál es tu película favorita?',
                            '¿Cuál fue tu primer trabajo?' => '¿Cuál fue tu primer trabajo?',
                        ]" />
                    <input
                        class="mt-2 w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                        wire:model="respuesta_3" />
                </div>
                <div class="flex justify-center space-x-4">
                    <x-button type="submit" primary label="Guardar" class="w-full" />
                    <x-button type="button" wire:click="salir" primary label="Salir"
                        class="w-full bg-red-700 hover:bg-red-900 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2" />
                </div>
        </div>
    </div>
</div>
