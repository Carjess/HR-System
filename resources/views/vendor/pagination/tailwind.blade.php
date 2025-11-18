@if ($paginator->hasPages())
   
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-center space-x-3">
        
        {{-- Botón de Anterior (<) --}}
        @if ($paginator->onFirstPage())
            {{-- Deshabilitado si es la primera página --}}
            <span class="flex items-center justify-center w-8 h-8 rounded-full text-gray-400 cursor-not-allowed">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="flex items-center justify-center w-8 h-8 rounded-full text-gray-800 hover:bg-gray-100">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
            </a>
        @endif

        {{-- Elementos de Paginación (Números y ...) --}}
        @foreach ($elements as $element)
            
            {{-- Separador "..." --}}
            @if (is_string($element))
                <span class="flex items-center justify-center w-8 h-8 text-gray-500">{{ $element }}</span>
            @endif

            {{-- Array de Números de Página --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        {{-- Página Actual (Círculo Azul/Primary) --}}
                        <span class="flex items-center justify-center w-8 h-8 rounded-full bg-primary-600 text-white font-bold">{{ $page }}</span>
                    @else
                        {{-- Otras Páginas (Solo Número) --}}
                        <a href="{{ $url }}" class="flex items-center justify-center w-8 h-8 rounded-full text-gray-800 hover:bg-gray-100">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Botón de Siguiente (>) --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="flex items-center justify-center w-8 h-8 rounded-full text-gray-800 hover:bg-gray-100">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
            </a>
        @else
            {{-- Deshabilitado si es la última página --}}
            <span class="flex items-center justify-center w-8 h-8 rounded-full text-gray-400 cursor-not-allowed">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
            </span>
        @endif
    </nav>
@endif