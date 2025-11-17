<x-app-layout>
    {{-- 1. Encabezado de la Página --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lista de Empleados') }}
        </h2>
    </x-slot>

    {{-- 2. Contenido Principal de la Página --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                <div class="p-6 text-gray-900">

                    @if (session('status'))
    <div class="mb-4 p-4 bg-green-100 text-green-700 border border-green-300 rounded">
        {{ session('status') }}
    </div>
@endif
<div class="mb-4">
    <a href="{{ route('empleados.create') }}" ...>

    </a>
    <div class="mb-4">
        <a href="{{ route('empleados.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Añadir Nuevo Empleado
        </a>
    </div>
        {{-- 3. La Tabla para mostrar los empleados --}}
        <table class="min-w-full divide-y divide-gray-200"></table>

                    {{-- 3. La Tabla para mostrar los empleados --}}
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Puesto</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            
                            {{-- 4. Bucle para recorrer los empleados --}}
                            @foreach ($empleados as $empleado)
                                <tr>
                                    {{-- COLUMNA 1: Nombre --}}
                                    <td class="px-6 py-4 whitespace-nowrap"><a href="{{ route('empleados.show', $empleado->id) }}" class="text-blue-600 hover:underline">{{ $empleado->name }}</a></td>

                                    {{-- COLUMNA 2: Email --}}
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $empleado->email }}</td>
                                    
                                    {{-- COLUMNA 3: Puesto --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $empleado->position->name ?? 'Sin Puesto' }}
                                    </td>

                                    {{-- COLUMNA 4: Acciones (Editar) --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ route('empleados.edit', $empleado->id) }}" class="text-indigo-600 hover:text-indigo-900">
                                            Editar
                                        </a>
                                        <form method="POST" action="{{ route('empleados.destroy', $empleado->id) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 ml-4" onclick="return confirm('¿Estás seguro de que quieres eliminar a este empleado?')">
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