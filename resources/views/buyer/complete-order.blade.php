<x-app-layout>
    @section('title', $title)
    <div class="py-12 flex justify-center">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex justify-between">
            <div class="min-w-[400px] me-5 items-center bg-white border border-lime-500 rounded-lg shadow-md dark:bg-gray-800 dark:border-lime-400 sm:rounded-lg pt-3 w-1/4">
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

            <div class="min-w-[400px] ms-5 items-center bg-white border border-lime-500 rounded-lg shadow-md dark:bg-gray-800 dark:border-lime-400 sm:rounded-lg pt-3 w-1/4">
                <div class="px-4">
                    <h2 class="dark:text-white text-black font-bold px-20 text-xl pb-3">
                        Данни за доставка
                    </h2>

                    @if (!$billingAddresses->isEmpty())
                    <div class="px-10 my-5">
                        <x-basic-button id="dropdownDefaultButton" data-dropdown-toggle="dropdown" class="w-full text-white font-medium rounded-lg text-sm py-2.5 text-center inline-flex items-center" type="button">
                            Избери запазени данни
                            <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                            </svg>
                        </x-basic-button>
                    </div>


                    <!-- Dropdown menu -->
                    <div id="dropdown" class="z-10 hidden bg-gray-200 divide-y divide-gray-600 rounded-lg shadow dark:bg-gray-700">
                        <ul class="py-2 text-sm text-gray-200 dark:text-gray-400" aria-labelledby="dropdownDefaultButton">
                            @foreach ($billingAddresses as $billingAddress)
                            <li>
                                <a href="#" class="block px-4 py-3 hover:bg-gray-700 rounded-md dark:hover:bg-gray-600 dark:hover:text-white" data-full-name="{{ $billingAddress->full_name }}" data-phone="{{ $billingAddress->phone }}" data-address="{{ $billingAddress->address }}">
                                    <span class="font-bold">{{ $billingAddress->full_name }}</span> - <span>{{ $billingAddress->phone }}</span><br>
                                    <span class="text-sm text-gray-400">{{ $billingAddress->address }}</span>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>


                    @endif
                    <form action="{{ route('complete-order') }}" class="px-10" method="POST">
                        @csrf
                        <x-label for="full_name">Пълно име:</x-label>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 top-0 flex items-center ps-3.5 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M4 4a2 2 0 0 0-2 2v12c0 1.1.9 2 2 2h16a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2H4Zm10 5c0-.6.4-1 1-1h3a1 1 0 1 1 0 2h-3a1 1 0 0 1-1-1Zm0 3c0-.6.4-1 1-1h3a1 1 0 1 1 0 2h-3a1 1 0 0 1-1-1Zm0 3c0-.6.4-1 1-1h3a1 1 0 1 1 0 2h-3a1 1 0 0 1-1-1Zm-8-5a3 3 0 1 1 6 0 3 3 0 0 1-6 0Zm2 4a3 3 0 0 0-3 2v.2c0 .1-.1.2 0 .2v.2c.3.2.6.4.9.4h6c.3 0 .6-.2.8-.4l.2-.2v-.2l-.1-.1A3 3 0 0 0 10 14H7.9Z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <x-input type="text" name="full_name" id="full_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Иван Иванов Иванов" required></x-input>
                        </div>
                        @error('full_name')
                        <p class="text-red-500 text-sm mt-1 mb-1">{{ $message }}</p>
                        @enderror

                        <x-label for="phone" class="mt-2">Телефонен номер:</x-label>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 top-0 flex items-center ps-3.5 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 19 18">
                                    <path d="M18 13.446a3.02 3.02 0 0 0-.946-1.985l-1.4-1.4a3.054 3.054 0 0 0-4.218 0l-.7.7a.983.983 0 0 1-1.39 0l-2.1-2.1a.983.983 0 0 1 0-1.389l.7-.7a2.98 2.98 0 0 0 0-4.217l-1.4-1.4a2.824 2.824 0 0 0-4.218 0c-3.619 3.619-3 8.229 1.752 12.979C6.785 16.639 9.45 18 11.912 18a7.175 7.175 0 0 0 5.139-2.325A2.9 2.9 0 0 0 18 13.446Z" />
                                </svg>
                            </div>
                            <x-input type="text" name="phone" id="phone" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" pattern="[0-9]{10}" placeholder="0123456789" required></x-input>
                        </div>
                        @error('phone')
                        <p class="text-red-500 text-sm mt-1 mb-1">{{ $message }}</p>
                        @enderror

                        <x-label for="address" class="mt-2">Адрес за доставка:</x-label>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 top-0 flex items-center ps-3.5 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M11.3 3.3a1 1 0 0 1 1.4 0l6 6 2 2a1 1 0 0 1-1.4 1.4l-.3-.3V19a2 2 0 0 1-2 2h-3a1 1 0 0 1-1-1v-3h-2v3c0 .6-.4 1-1 1H7a2 2 0 0 1-2-2v-6.6l-.3.3a1 1 0 0 1-1.4-1.4l2-2 6-6Z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <x-input type="text" name="address" id="address" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="ул. Иван Вазов №1" required></x-input>
                        </div>
                        @error('address')
                        <p class="text-red-500 text-sm mt-1 mb-1">{{ $message }}</p>
                        @enderror


                        <button type="submit" class="my-5 w-full text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm py-2.5 dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 dark:focus:ring-green-800">
                            Завършване на поръчката
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>

<script>
    // Wait for the document to be ready
    $(document).ready(function() {
        // Handle click event on dropdown option
        $('#dropdown a').click(function(e) {
            e.preventDefault();
            // Get data attributes of the clicked option
            var fullName = $(this).data('full-name');
            var phone = $(this).data('phone');
            var address = $(this).data('address');
            // Update input fields with the data
            $('#full_name').val(fullName);
            $('#phone').val(phone);
            $('#address').val(address);
            $('#dropdownDefaultButton').click();
            // $('#dropdown').addClass('hidden');
        });
    });
</script>