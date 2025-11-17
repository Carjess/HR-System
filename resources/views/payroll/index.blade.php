<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Administración de Nómina') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if (session('status'))
                        <div class="mb-4 p-4 bg-green-100 text-green-700 border border-green-300 rounded">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="mb-4 p-4 bg-red-100 text-red-700 border border-red-300 rounded">
                            {{ session('error') }}
                        </div>
                    @endif

                    <h3 class="text-lg font-semibold mb-4">Generar Nómina Mensual</h3>
                    <p class="mb-4">Selecciona el mes y el año para generar los recibos de pago de todos los empleados.</p>

                    <form method="POST" action="{{ route('payroll.generate') }}">
                        @csrf

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="month">Mes:</label>
                                <select name="month" id="month" class="block w-full mt-1" required>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}" {{ $i == date('m') ? 'selected' : '' }}>
                                            {{ strftime('%B', mktime(0, 0, 0, $i, 10)) }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <div>
                                <label for="year">Año:</label>
                                <select name="year" id="year" class="block w-full mt-1" required>
                                    @for ($i = date('Y'); $i >= date('Y') - 5; $i--)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        <div class="mt-6">
                            <button type="submit" class="bg-red-600 hover:bg-red-800 text-white font-bold py-2 px-4 rounded" onclick="return confirm('¿Estás seguro? Esto generará (o regenerará) la nómina para todos los empleados en este período.')">
                                Generar Nómina
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>