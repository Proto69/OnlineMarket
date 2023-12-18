<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Количка') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                @if (count($products) > 0)
                @foreach ($products as $product)
                <div class="border border-gray-500 p-4 rounded-lg">
                    <div class="flex items-center">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                            <a href="https://laravel.com/docs">{{ $product->name}}</a>
                        </h2>
                    </div>
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                        {{ $product->description }}
                    </p>

                    <form class="max-w-xs mx-auto" action="/remove-product-from-cart" method="GET">
                        @csrf
                        <label for="quantity-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Количество:</label>
                        <x-input name="product_id" id="default-search" class="hidden" value="{{ $product->id }}" />
                        <div class="relative flex items-center max-w-[8rem]">
                            <button type="button" id="decrement-button" data-product-id="{{ $product->id }}" data-input-counter-decrement="quantity-input" class="decrement-button bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 border border-gray-300 rounded-s-lg p-3 h-11 focus:ring-gray-100 dark:focus:ring-gray-700 focus:ring-2 focus:outline-none">
                                <svg class="w-3 h-3 text-gray-900 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 2">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h16" />
                                </svg>
                            </button>
                            <input type="text" id="quantity-input" data-input-counter data-input-counter-min="1" data-input-counter-max="{{ $product->quantity }}" aria-describedby="helper-text-explanation" class="quantity-input bg-gray-50 border-x-0 border-gray-300 h-11 text-center text-gray-900 text-sm focus:ring-blue-500 focus:border-blue-500 block w-full py-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="{{ $product->bought_quantity }}" required>
                            <button type="button" id="increment-button" data-product-id="{{ $product->id }}" data-input-counter-increment="quantity-input" class="increment-button bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 border border-gray-300 rounded-e-lg p-3 h-11 focus:ring-gray-100 dark:focus:ring-gray-700 focus:ring-2 focus:outline-none">
                                <svg class="w-3 h-3 text-gray-900 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16" />
                                </svg>
                            </button>
                        </div>

                        <div class="mt-7">
                            <button type="submit" class="text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
                                Премахни
                            </button>
                        </div>
                    </form>
                </div>
                @endforeach
                @else
                <div class="border border-gray-500 p-4 rounded-lg">
                    <div class="flex items-center">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                            <a href="https://laravel.com/docs">Нямате продукти в количката</a>
                        </h2>
                    </div>
                </div>
                @endif
            </div>
            @if ($sum > 0)
            <div class="relative items-center block max-w-sm bg-white border border-lime-500 rounded-lg shadow-md dark:bg-gray-800 dark:border-lime-400 dark:hover:bg-gray-700 shadow-xl sm:rounded-lg pt-3 mt-4">
                <h2 class="dark:text-white text-black font-semibold text-xl ps-3">
                    Касова бележка:
                </h2>
                @foreach ($products as $product)
                <p class="ps-3 dark:text-gray-400 text-gray-900 receipt-section{{ $product->id }}">
                    {{ $product->name }} x {{ $product->bought_quantity }} = {{ $product->price * $product->bought_quantity}}
                </p>

                <div role="status" class="absolute -translate-x-1/2 -translate-y-1/2 top-2/4 left-1/2 spinner hidden" id="{{ $product->id }}">
                    <svg aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor" />
                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill" />
                    </svg>
                    <span class="sr-only">Loading...</span>
                </div>
                @endforeach

                <h1 class="ps-3 dark:text-lime-200 text-lime-600 font-bold text-2xl mt-10 total-sum">
                    Обща сума: {{ $sum }}
                </h1>

                <button type="button" class="ms-3 mt-3 text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 dark:focus:ring-green-800">
                    Завършване на поръчката
                </button>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>

<script>
    $('.decrement-button, .increment-button').on('click', function() {
        let currentValue = parseInt($(this).siblings('.quantity-input').val());
        let productId = $(this).data('product-id');
        let minValue = $(this).siblings('.quantity-input').data('input-counter-min');
        let maxValue = $(this).siblings('.quantity-input').data('input-counter-max');
        let spinner = document.getElementById(productId);

        spinner.classList.remove('hidden');

        // Decrement or increment based on the clicked button
        if ($(this).hasClass('decrement-button')) {
            currentValue = Math.max(currentValue - 1, minValue);
        } else {
            currentValue = Math.min(currentValue + 1, maxValue);
        }

        // Make the AJAX request
        updateQuantity(productId, currentValue, spinner);
    });

    function updateQuantity(productId, newQuantity, spinner) {
        $.ajax({
            url: '/edit-quantity',
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
                    receiptHTML += `<p>${product.name} x ${product.bought_quantity} = ${product.price * product.bought_quantity}</p>`;
                });

                spinner.classList.add('hidden');

                // Replace the receipt section content
                $('.receipt-section' + productId).html(receiptHTML);

                // Update the total sum
                $('.total-sum').text(`Обща сума: ${response.sum}`);
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                console.error('Status:', status);
                console.error('Response Text:', xhr.responseText);
            }
        });
    }
</script>