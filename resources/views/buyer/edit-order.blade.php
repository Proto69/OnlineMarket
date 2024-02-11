@php
use App\Models\Product;

@endphp
<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="card-form bg-white dark:bg-gray-800 border border-gray-300 p-4 rounded-lg">
                    @foreach($logs as $log)
                    <form action="{{ route('edit-log-save', $log->id) }}" method="POST">
                        @csrf
                        <!-- Име -->
                        <div class="flex items-center">
                            <h2 class="text-xxl font-semibold text-gray-900 dark:text-white">
                                {{ Product::find($log->product)->name }}
                            </h2>
                        </div>

                        <!-- Количество -->
                        <label for="quantity-input"
                            class="block mb-1 text-xl font-medium text-gray-900 dark:text-white">Количество:</label>
                        @error('quantity')
                            <p class="text-red-500 text-sm mt-1 mb-1">{{ $message }}</p>
                        @enderror
                        <x-input type="text" name="quantity" id="quantity" class="h-11 text-center text-sm py-2.5"
                            value="{{ $log->quantity }}" required></x-input>

                        <!-- Добавяне на продукт -->
                        <x-success-button class="mt-3 me-2" type="submit">
                            Запази промените
                        </x-success-button>
                    </form>

                    <form action="{{ route('delete-log', $log->id) }}" method="POST" class="inline">
                        @csrf
                        <x-danger-button class="mt-3" type="submit">
                            Изтрий продукта
                        </x-danger-button>
                    </form>

                    <form action="{{ route('shopping') }}" method="GET" class="inline">
                        @csrf
                        <x-danger-button class="mt-3" type="submit">
                            Отказ
                        </x-danger-button>
                    </form>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
