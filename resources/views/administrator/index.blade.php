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
                            <!-- Modal toggle -->
                            <x-danger-button data-modal-target="authentication-modal-{{ $product->id }}" data-modal-toggle="authentication-modal-{{ $product->id }}">
                                Деактивирай продукт
                            </x-danger-button>

                            <!-- Main modal -->
                            <div id="authentication-modal-{{ $product->id }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                <div class="relative p-4 w-full max-w-md max-h-full">
                                    <!-- Modal content -->
                                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                        <!-- Modal header -->
                                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                                Деактивиране на продукт
                                            </h3>
                                            <button type="button" class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="authentication-modal-{{ $product->id }}">
                                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                </svg>
                                            </button>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="p-4 md:p-5">
                                            <form action="{{ route('deactivate-product-admin', $product->id) }}" method="POST">
                                                @csrf
                                                <div>
                                                    <x-label for="reason" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Причина:</x-label>
                                                    <x-input type="text" name="reason" id="reason" class="w-full" placeholder="Обидно име" required />
                                                </div>
                                                <x-success-button type="submit" class="mt-2">Деактивирай продукт</x-success-button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    @endforeach

                </div>
            </div>
        </div>
    </div>
</x-app-layout>