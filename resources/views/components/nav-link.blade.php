@props(['active'])

@php
/*
    Lógica de Estilos (Diseño Blanco + Verde Petróleo):
    - Active: Fondo Verde Petróleo (Primary-600), Texto Blanco, Sombra suave.
    - Inactive: Texto Gris (Gray-500), Hover con fondo gris muy claro y texto verde.
*/
$classes = ($active ?? false)
            ? 'flex items-center p-3 rounded-xl transition-all duration-200 group bg-primary-600 text-white shadow-md focus:outline-none'
            : 'flex items-center p-3 rounded-xl transition-all duration-200 group text-gray-500 dark:text-gray-400 hover:bg-primary-50 dark:hover:bg-gray-800 hover:text-primary-600 dark:hover:text-primary-400 focus:outline-none focus:bg-primary-50';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>