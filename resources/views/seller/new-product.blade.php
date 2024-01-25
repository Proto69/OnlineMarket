<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="card-form bg-white dark:bg-gray-800 border border-gray-300 p-4 rounded-lg">
                    <form id="newProductForm" action="{{ route('new-product') }}" method="POST">
                        <div class="flex items-center">
                            <h2 class="text-xxl font-semibold text-gray-900 dark:text-white">
                                <label for="quantity-input" class="block mb-2 text-xl font-medium text-gray-900 dark:text-white">Име:</label>
                                <x-input type="text" id="name" class="name" value=""></x-input>
                            </h2>
                        </div>
                        <p class="text-gray-500 dark:text-gray-400 text-xl">
                            <label for="quantity-input" class="block mt-3 text-xl font-medium text-gray-900 dark:text-white">Описание:</label>
                            <textarea id="description" class="ps-2 pe-2 description border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-3 mb-3" cols="20" rows="5"></textarea>
                        </p>
                        <label for="quantity-input" class="block mb-2 text-xl font-medium text-gray-900 dark:text-white">Количество:</label>
                        <div class="relative flex items-center max-w-[8rem]">
                            <button type="button" id="decrement-button" data-input-counter-decrement="quantity" class="decrement-button bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 border border-gray-300 rounded-s-lg p-3 h-11 focus:ring-gray-100 dark:focus:ring-gray-700 focus:ring-2 focus:outline-none">
                                <svg class="w-3 h-3 text-gray-900 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 2">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h16" />
                                </svg>
                            </button>
                            <input type="text" id="quantity" data-input-counter data-input-counter-min="0" aria-describedby="helper-text-explanation" class="quantity-input bg-gray-50 border-x-0 border-gray-300 h-11 text-center text-gray-900 text-sm focus:ring-blue-500 focus:border-blue-500 block w-full py-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="0" required>
                            <button type="button" id="increment-button" data-input-counter-increment="quantity" class="increment-button bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 border border-gray-300 rounded-e-lg p-3 h-11 focus:ring-gray-100 dark:focus:ring-gray-700 focus:ring-2 focus:outline-none">
                                <svg class="w-3 h-3 text-gray-900 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16" />
                                </svg>
                            </button>

                        </div>
                        <label class="text-xl block mb-2 mt-3 text-sm font-medium text-gray-900 dark:text-white ">Цена: </label>
                        <x-input class="price ps-2 mb-4" type="text" value="0.00"></x-input> <br />

                        <x-success-button class="mt-3 me-2" href="#" onClick="document.getElementById('newProductForm').submit(); return false;">
                            Добави продукт
                        </x-success-button>
                    </form>

                    <x-danger-button class="mt-3" href="{{ route('dashboard') }}">
                        Отказ
                    </x-danger-button>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>