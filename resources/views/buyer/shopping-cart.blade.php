<x-app-layout>
    @section('title', $title)
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Количка') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto min-w-[905px] sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-xl sm:rounded-lg mr-96 mt-[-0.5rem] bg-transparent">
                @if (count($products) > 0)
                @foreach ($products as $product)
                <div class="border border-lime-500 mb-1 dark:border-lime-400 dark:bg-gray-800 h-96 rounded-lg grid grid-cols-3 min-w-[470px]">
                    <div class="col-span-2 relative min-w-80">
                        <div class="absolute top-2 left-1/2 transform -translate-x-1/2">
                            <img class="rounded-lg mb-2 productImage" src="{{ $product->getImageURL() }}" alt="{{ $product->name }}">
                        </div>

                        <div class="absolute bottom-2 left-1/2 transform -translate-x-1/2">

                            <div class="flex items-center">
                                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                                    <a>{{ $product->name}}</a>
                                </h2>
                            </div>

                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <p class="mt-8 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                                {{ $product->description }}
                            </p>
                        </div>

                    </div>
                    <div class="col-span-1 border-l border-lime-500 dark:border-lime-400 rounded-tr-lg rounded-br-lg flex items-center justify-center min-w-40">
                        <form class="max-w-xs mx-auto" action="/remove-product-from-cart" method="GET">
                            @csrf
                            <label for="quantity-input" class="block mb-2 pl-7 text-sm font-medium items-center justify-center text-gray-900 dark:text-white">
                                <strong>Количество</strong></label>
                            <x-input name="product_id" id="default-search" class="hidden" value="{{ $product->id }}" />
                            <div class="relative flex items-center max-w-[9rem]">
                                <button type="button" id="decrement-button-{{ $product->id }}" data-product-id="{{ $product->id }}" data-input-counter-decrement="quantity-input-{{ $product->id }}" class="decrement-button bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 border border-gray-300 rounded-s-lg p-3 h-11 focus:ring-gray-100 dark:focus:ring-gray-700 focus:ring-2 focus:outline-none">
                                    <svg class="w-3 h-3 text-gray-900 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 2">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h16" />
                                    </svg>
                                </button>
                                <input type="text" id="quantity-input-{{ $product->id }}" data-product-id="{{ $product->id }}" data-input-counter data-input-counter-min="1" data-input-counter-max="{{ $product->quantity }}" aria-describedby="helper-text-explanation" class="quantity-input bg-gray-50 border-x-0 border-gray-300 h-11 text-center text-gray-900 text-sm focus:ring-blue-500 focus:border-blue-500 block w-full py-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="{{ $product->bought_quantity }}" required>
                                <button type="button" id="increment-button-{{ $product->id }}" data-product-id="{{ $product->id }}" data-input-counter-increment="quantity-input-{{ $product->id }}" class="increment-button bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 border border-gray-300 rounded-e-lg p-3 h-11 focus:ring-gray-100 dark:focus:ring-gray-700 focus:ring-2 focus:outline-none">
                                    <svg class="w-3 h-3 text-gray-900 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16" />
                                    </svg>
                                </button>
                            </div>

                            <div class="mt-7">
                                <button type="submit" class="text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-10 py-2.5 text-center me-1 mb-1 dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
                                    Премахни
                                </button>

                            </div>
                        </form>
                    </div>
                </div>
                @endforeach
                @else
                <div class="border border-lime-500 dark:border-lime-400 p-4 rounded-lg left-4 right-4">
                    <div class="flex items-center">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                            <a>Нямате продукти в количката</a>
                        </h2>
                    </div>
                </div>
                @endif
            </div>
            @if ($sum > 0)
            <div class="fixed top-44 right-6 bottom-12 min-w-[300px] items-center mr-16 bg-white border border-lime-500 rounded-lg shadow-md dark:bg-gray-800 dark:border-lime-400 dark:hover:bg-gray-700 sm:rounded-lg pt-3 w-1/4">
                <div class="px-4">
                    <h2 class="dark:text-white text-black font-bold px-20 text-xl pb-3">
                        Касова бележка
                    </h2>
                </div>

                @php
                $productCount = count($products);
                $scrollClass = $productCount >= 14 ? 'overflow-y-scroll' : '';
                @endphp

                <div class="{{ $scrollClass }} mx-0 max-h-80 border-y border-lime-500 dark:border-lime-400 py-3">
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

                    <form action="{{ route('complete-order') }}" method="POST">
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
                            <x-input type="text" name="phone" id="phone-input" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" pattern="[0-9]{10}" placeholder="0123456789" required></x-input>
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


                        <button type="submit" class="mt-3 text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 dark:focus:ring-green-800">
                            Завършване на поръчката
                        </button>
                    </form>
                </div>
            </div>



            @endif

        </div>
    </div>
</x-app-layout>

<script>
    let inputQuantityField = document.querySelector(".quantity-input");

    inputQuantityField.addEventListener("keydown", function(event) {
        if (event.keyCode === 13) {
            event.preventDefault();
            let productId = $(this).data('product-id');
            let currentValue = parseInt($(this).val());

            updateQuantity(productId, currentValue);
        }
    });

    $('.decrement-button, .increment-button').on('click', function() {
        let productId = $(this).data('product-id');
        let currentValue = parseInt($(this).siblings('.quantity-input').val());
        let minValue = $(this).siblings('.quantity-input').data('input-counter-min');
        let maxValue = $(this).siblings('.quantity-input').data('input-counter-max');

        // Decrement or increment based on the clicked button
        if ($(this).hasClass('decrement-button')) {
            currentValue = Math.max(currentValue - 1, minValue);
        } else {
            currentValue = Math.min(currentValue + 1, maxValue);
        }

        // Make the AJAX request
        updateQuantity(productId, currentValue);
    });

    function updateQuantity(productId, newQuantity) {
        $.ajax({
            url: '/edit-shopping-quantity',
            method: 'POST',
            data: {
                product_id: productId,
                new_bought_quantity: newQuantity,
                "_token": "{{ csrf_token() }}"
            },
            success: function(response) {
                console.log('success');

                let receiptHTML = '';
                response.products.forEach(product => {
                    receiptHTML += `<p class="ps-3 dark:text-gray-400 text-gray-900"><strong>${product.name}</strong> x <strong>${product.bought_quantity}</strong> = <strong>${product.price * product.bought_quantity}</strong></p>`;
                });

                // Replace the receipt section content
                $('.receipt-section').html(receiptHTML);

                // Update the total sum
                $('.total-sum').text(`Обща сума: ${response.sum}лв`);
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                console.error('Status:', status);
                console.error('Response Text:', xhr.responseText);
            }
        });
    }
</script>