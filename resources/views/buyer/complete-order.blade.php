<x-app-layout>
    @section('title', $title)
    <div class="py-12 flex justify-center">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex justify-between" >
            <div class="min-w-[400px] me-5 items-center bg-white border border-lime-500 rounded-lg shadow-md dark:bg-gray-800 dark:border-lime-400 dark:hover:bg-gray-700 sm:rounded-lg pt-3 w-1/4">
                <div class="px-4">
                    <h2 class="dark:text-white text-black font-bold px-20 text-xl pb-3">
                        Касова бележка
                    </h2>
                </div>

                @php
                $productCount = count($products);
                $scrollClass = $productCount >= 15 ? 'overflow-y-scroll' : '';
                @endphp

                <div class="{{ $scrollClass }} mx-0 border-y border-lime-500 dark:border-lime-400 py-3">
                    <div class="receipt-section">
                        @foreach ($products as $product)
                        <p class="ps-3 dark:text-gray-400 text-gray-900">
                            <strong>{{ $product->name }}</strong> x <strong>{{ $product->bought_quantity }}</strong> = <strong>{{ $product->price * $product->bought_quantity}}</strong>
                        </p>
                        @endforeach
                    </div>
                </div>
                <div class="flex flex-col items-center justify-end px-4 mb-4">
                    <h1 class="total-sum ps-3 dark:text-lime-200 text-lime-600 font-bold text-2xl mt-2 mb-6">
                        Обща сума: {{ $sum }}лв
                    </h1>
                </div>
            </div>

            <div class="min-w-[400px] ms-5 items-center bg-white border border-lime-500 rounded-lg shadow-md dark:bg-gray-800 dark:border-lime-400 dark:hover:bg-gray-700 sm:rounded-lg pt-3 w-1/4">
                <div class="px-4">
                    <h2 class="dark:text-white text-black font-bold px-20 text-xl pb-3">
                        Данни за доставка
                    </h2>

                    <button id="dropdownDefaultButton" data-dropdown-toggle="dropdown" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">Dropdown button <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                        </svg>
                    </button>

                    <!-- Dropdown menu -->
                    <div id="dropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
                            <li>
                                <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Dashboard</a>
                            </li>
                            <li>
                                <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Settings</a>
                            </li>
                            <li>
                                <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Earnings</a>
                            </li>
                            <li>
                                <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Sign out</a>
                            </li>
                        </ul>
                    </div>

                </div>

            </div>
        </div>
    </div>
</x-app-layout>