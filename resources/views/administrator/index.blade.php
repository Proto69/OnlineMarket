<x-app-layout>
    @section('title', "Всички продукти")
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Всички продукти') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-xl sm:rounded-lg">
                <div class="bg-transparent bg-opacity-25 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 lg:gap-6 p-6">

                    @foreach($products as $product)

                    <div class="card-form relative min-w-80 bg-white dark:bg-gray-800 border border-gray-300 p-4 rounded-lg flex flex-col h-full items-center">

                        <div class="mb-2 flex-grow">
                            <!-- Product Image -->
                            <img class="mt-1 mb-2 ms-5 productImage" src="{{ $product->getImageURL() }}">
                            <!-- Product Name -->
                            <h5 class="text-xl font-semibold tracking-tight text-gray-900 dark:text-white">{{ $product->name }}</h5>
                            <!-- Product Description -->
                            <p class="mt-2 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                                {{ $product->description }}
                            </p>
                        </div>

                        <div class="mt-auto mb-2 flex items-center justify-between">
                            @if ($product->is_deleted)
                            <form action="{{ route('activate-product-admin', $product->id) }}" method="POST">
                                @csrf
                                <x-success-button type="submit" class="mt-3">
                                    Активирай продукт
                                </x-success-button>
                            </form>
                            @else
                            <form action="{{ route('deactivate-product-admin', $product->id) }}" method="POST">
                                @csrf
                                <x-danger-button type="submit" class="mt-3">
                                    Деактивирай продукт
                                </x-danger-button>
                            </form>
                            @endif
                        </div>
                    </div>

                    @endforeach

                </div>
            </div>
        </div>
    </div>
</x-app-layout>