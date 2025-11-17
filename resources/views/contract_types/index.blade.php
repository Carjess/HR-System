<x-app-layout>
    {{-- Encabezado de la Página --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tipos de Contrato') }}
        </h2>
    </x-slot>

    {{-- Contenido Principal --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if (session('status'))
                        <div class="mb-4 p-4 bg-green-100 text-green-700 border border-green-300 rounded">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="mb-4">
                        <a href="{{ route('tipos-contrato.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Crear Nuevo Tipo
                        </a>
                    </div>

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            
                            @foreach ($tipos as $tipo)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $tipo->name }}</td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ route('tipos-contrato.edit', $tipo->id) }}" class="text-indigo-600 hover:text-indigo-900">
                                            Editar
                                        </a>
                                        
                                        <form method="POST" action="{{ route('tipos-contrato.destroy', $tipo->id) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 ml-4" onclick="return confirm('¿Estás seguro de que quieres eliminar este tipo?')">
                                                Eliminar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>