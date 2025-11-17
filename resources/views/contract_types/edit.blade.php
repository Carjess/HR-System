<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Tipo de Contrato') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    {{-- OJO: La ruta ($tiposContrato) debe coincidir con el controlador --}}
                    <form method="POST" action="{{ route('tipos-contrato.update', $tiposContrato->id) }}">
                        @csrf 
                        @method('PATCH')

                        <div>
                            <label for="name">Nombre:</label>
                            {{-- Rellenamos el valor con el dato actual --}}
                            <input type="text" name="name" id="name" class="block w-full mt-1" value="{{ old('name', $tiposContrato->name) }}" required autofocus>
                            
                            @error('name')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mt-6">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Actualizar
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>