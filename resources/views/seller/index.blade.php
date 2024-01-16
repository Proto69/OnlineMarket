<x-app-layout>
    <x-slot name="header">
        <div class="grid grid-cols-5 gap-4 text-gray-800 dark:text-gray-200">
            <h2 class="font-semibold text-xl leading-tight">
                {{ __('Табло') }}
            </h2>
            <x-success-button class="col-end-7 col-span-1">Добави нов продукт</x-success-button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-transparent dark:bg-transparent overflow-hidden shadow-xl sm:rounded-lg">
                <div class="bg-transparent bg-opacity-25 grid grid-cols-1 md:grid-cols-4 gap-4 p-3">

                    @foreach ($products as $product)
                    <div class="card-form bg-white dark:bg-gray-800 border border-gray-300 p-4 rounded-lg">
                        <div class="flex items-center">
                            @if (!$product->active || $product->quantity === 0)
                            <h2 class="text-xxl font-semibold text-red-700 dark:text-red-400">
                                <x-input type="text" class="name" value="{{ $product->name }}"></x-input>
                            </h2>
                            @else
                            <h2 class="text-xxl font-semibold text-gray-900 dark:text-white">
                                <x-input type="text" class="name" value="{{ $product->name }}"></x-input>
                            </h2>
                            @endif
                        </div>
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <p class="text-gray-500 dark:text-gray-400 text-xl">
                            <textarea class="ps-2 pt-1 pe-2 description border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-3 mb-3" cols="20" rows="5">{{ $product->description }}</textarea>
                        </p>
                        <label for="quantity-input" class="block mb-2 text-xl font-medium text-gray-900 dark:text-white">Количество:</label>
                        <x-input name="product_id" id="default-search" class="hidden" value="{{ $product->id }}" />
                        <div class="relative flex items-center max-w-[8rem]">
                            <button type="button" id="decrement-button-{{ $product->id }}" data-product-id="{{ $product->id }}" data-input-counter-decrement="quantity-input-{{ $product->id }}" class="decrement-button bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 border border-gray-300 rounded-s-lg p-3 h-11 focus:ring-gray-100 dark:focus:ring-gray-700 focus:ring-2 focus:outline-none">
                                <svg class="w-3 h-3 text-gray-900 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 2">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h16" />
                                </svg>
                            </button>
                            <input type="text" id="quantity-input-{{ $product->id }}" data-product-id="{{ $product->id }}" data-input-counter data-input-counter-min="0" aria-describedby="helper-text-explanation" class="quantity-input bg-gray-50 border-x-0 border-gray-300 h-11 text-center text-gray-900 text-sm focus:ring-blue-500 focus:border-blue-500 block w-full py-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="{{ $product->quantity }}" required>
                            <button type="button" id="increment-button-{{ $product->id }}" data-product-id="{{ $product->id }}" data-input-counter-increment="quantity-input-{{ $product->id }}" class="increment-button bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 border border-gray-300 rounded-e-lg p-3 h-11 focus:ring-gray-100 dark:focus:ring-gray-700 focus:ring-2 focus:outline-none">
                                <svg class="w-3 h-3 text-gray-900 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16" />
                                </svg>
                            </button>
                        </div>
                        <label class="text-xl block mb-2 mt-3 text-sm font-medium text-gray-900 dark:text-white ">Цена: </label>
                        <x-input class="price ps-2 mb-4" type="text" value="{{ $product->price }}"></x-input> <br />

                        @if (!$product->active)
                        <cr class="unactive-product mt-2 text-red-800 dark:text-red-500 font-bold">Този продукт е неактивен!</cr>
                        <br />
                        @endif

                        @if ($product->quantity === 0)
                        <cr class="sold-product mt-2 text-red-800 dark:text-red-500 font-bold">Този продукт е изчерпан!</cr>
                        <br />
                        @endif


                        <span class="activity-state state text-xxl font-medium text-gray-900 dark:text-gray-300">{{ $product->active ? 'Активен' : 'Неактивен'}}</span>
                        <br />

                        <label class="mt-3 relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" value="" class="sr-only peer activity-toggle" {{ $product->active ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                        </label>
                        <br />

                        <x-button class="save-changes mt-3" data-product-id="{{ $product->id }}">
                            Запази промените
                        </x-button>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    $('.quantity-input, .price, .name').on("keydown", function(event) {
        if (event.keyCode === 13) {
            event.preventDefault();
        }
    });

    $('.activity-toggle').on('change', function() {
        let cardForm = $(this).closest('.card-form');
        let activityState = cardForm.find('.activity-state');

        //  maybe could be used for smth
        let message = cardForm.find('.unactive-product');

        if (this.checked) {
            activityState.text('Активен');
        } else {
            activityState.text('Неактивен');

        }

    });

    $('.save-changes').on('click', function() {
        let cardForm = $(this).closest('.card-form');
        let productId = cardForm.find('.quantity-input').data('product-id');
        let currentValue = parseInt(cardForm.find('.quantity-input').val());
        let name = cardForm.find('.name').val();
        let description = cardForm.find('.description').val();
        let price = cardForm.find('.price').val();
        let activityState = cardForm.find('.activity-state').text();
        let state = 0;

        if (activityState == "Активен") {
            state = 1;
        }

        updateProduct(productId, currentValue, name, description, price, state);
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
    });

    function updateProduct(productId, newQuantity, newName, newDescription, newPrice, newState) {
        $.ajax({
            url: '/edit-product',
            method: 'POST',
            data: {
                product_id: productId,
                quantity: newQuantity,
                name: newName,
                description: newDescription,
                price: newPrice,
                state: newState,
                "_token": "{{ csrf_token() }}"
            },
            success: function(response) {
                console.log('success');
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                console.error('Status:', status);
                console.error('Response Text:', xhr.responseText);
            }
        });
    }
</script>