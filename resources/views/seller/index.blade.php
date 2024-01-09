<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Табло') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-transparent dark:bg-transparent overflow-hidden shadow-xl sm:rounded-lg">
                <div class="bg-transparent bg-opacity-25 grid grid-cols-1 md:grid-cols-2 gap-4 p-6">

                    @foreach ($products as $product)
                    <div class="bg-white dark:bg-gray-800 border border-gray-300 p-4 rounded-lg">
                        <div class="flex items-center">
                            @if (!$product->active || $product->quantity === 0)
                            <h2 class="text-xl font-semibold text-red-700 dark:text-red-400">
                                <a>{{ $product->name }}</a>

                            </h2>
                            @else
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                                <a>{{ $product->name }}</a>
                            </h2>
                            @endif
                        </div>
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                            {{ $product->description }}
                            <br />
                            Налично количество: {{ $product->quantity }}
                        </p>
                        @if (!$product->active)
                        <cr class="text-red-800 dark:text-red-500 font-bold">Този продукт е неактивен!</cr>
                        <br />
                        @elseif ($product->quantity === 0)
                        <cr class="text-red-800 dark:text-red-500 font-bold">Този продукт е изчерпан!</cr>
                        <br />
                        @endif
                        <x-button class="edit-quantity mt-3" data-product-id="{{ $product->id }}">
                            Промени количество
                        </x-button>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>