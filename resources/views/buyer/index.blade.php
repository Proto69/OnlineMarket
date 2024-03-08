<x-app-layout>
    @section('title', $title)
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Пазаруване') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-transparent dark:bg-transparent overflow-hidden shadow-xl sm:rounded-lg">
                <div class="bg-transparent bg-opacity-25 grid grid-cols-1 md:grid-cols-4 gap-4 p-3 ">

                    @foreach($products as $product)
                    @if ($product->active)


                    <div id="readProductButton" data-modal-target="readProductModal-{{ $product->id }}" data-modal-toggle="readProductModal-{{ $product->id }}" class="hover:cursor-pointer card-form relative min-w-80 bg-white dark:bg-gray-800 border border-gray-300 p-4 rounded-lg flex flex-col h-full items-center">

                        <div class="mb-2 flex flex-col items-center">
                            <!-- Product Image -->
                            @if ($product->getImageURL())
                            <div class="h-52 w-full bg-contain bg-no-repeat bg-center rounded-md" style="background-image: url('{{ $product->getImageURL() }}')"></div>
                            @else
                            <img class="rounded-lg mb-2 productImage max-h-60" src="https://upload.wikimedia.org/wikipedia/commons/6/65/No-Image-Placeholder.svg">
                            @endif
                            <!-- Product Name -->
                            <h5 class="text-xl font-semibold tracking-tight text-gray-900 dark:text-white">{{ $product->name }}</h5>
                        </div>

                        <div class="mt-auto mb-2 flex items-center justify-between">
                            <!-- Product Price -->
                            <span class="text-3xl font-bold mt-3 pr-2 text-gray-900 dark:text-white">{{ $product->price }}лв</span> <br />
                            <!-- Add to Cart Button -->
                            <x-basic-button class="mt-3 add-to-cart" data-product-id="{{ $product->id }}" onclick="event.stopPropagation()">
                                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 4h1.5L9 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-8.5-3h9.3L19 7h-1M8 7h-.7M13 5v4m-2-2h4" />
                                </svg>
                            </x-basic-button>
                            <!-- Hidden Input for Product ID -->
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                        </div>
                    </div>

                    <!-- Main modal -->
                    <div id="readProductModal-{{ $product->id }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
                        <div class="relative p-4 w-full max-w-xl h-full md:h-auto">
                            <!-- Modal content -->
                            <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                                <!-- Modal header -->
                                <form action="{{ route('add-to-cart-quantity', $product->id) }}" method="POST">
                                    @csrf
                                    <div class="flex justify-between mb-4 rounded-t sm:mb-5">
                                        <div class="text-lg text-gray-900 md:text-xl dark:text-white">
                                            <h3 class="font-semibold ">
                                                {{ $product->name }}
                                            </h3>
                                            <p class="font-bold">
                                                {{ $product->price }}лв
                                            </p>
                                        </div>
                                        <div>
                                            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 inline-flex dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="readProductModal-{{ $product->id }}">
                                                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                </svg>
                                                <span class="sr-only">Close modal</span>
                                            </button>
                                        </div>
                                    </div>
                                    <dl>
                                        <dt class="mb-2 font-semibold leading-none text-gray-900 dark:text-white">Детайли</dt>
                                        <dd class="mb-4 font-light text-gray-500 sm:mb-5 dark:text-gray-400">{{ $product->description }}</dd>
                                        <!-- <dt class="mb-2 font-semibold leading-none text-gray-900 dark:text-white">Категория</dt>
                                    <dd class="mb-4 font-light text-gray-500 sm:mb-5 dark:text-gray-400">Electronics/PC</dd> -->
                                        @if ($product->getImageURL())
                                        <div class="h-52 w-full bg-contain bg-no-repeat bg-center rounded-md" style="background-image: url('{{ $product->getImageURL() }}')"></div>
                                        @else
                                        <div class="h-52 w-full bg-contain bg-no-repeat bg-center rounded-md" style="background-image: url(https://upload.wikimedia.org/wikipedia/commons/6/65/No-Image-Placeholder.svg)"></div>
                                        @endif
                                    </dl>
                                    <div class="flex items-center mt-3">
                                        <div class="relative flex items-center max-w-[9rem]">
                                            <button type="button" id="decrement-button-{{ $product->id }}" data-product-id="{{ $product->id }}" data-input-counter-decrement="quantity-input-{{ $product->id }}" class="decrement-button bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 border border-gray-300 rounded-s-lg p-3 h-11 focus:ring-gray-100 dark:focus:ring-gray-700 focus:ring-2 focus:outline-none">
                                                <svg class="w-3 h-3 text-gray-900 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 2">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h16" />
                                                </svg>
                                            </button>
                                            <input type="text" name="quantity" id="quantity-input-{{ $product->id }}" data-product-id="{{ $product->id }}" data-input-counter data-input-counter-min="1" data-input-counter-max="{{ $product->quantity }}" aria-describedby="helper-text-explanation" class="quantity-input bg-gray-50 border-x-0 border-gray-300 h-11 text-center text-gray-900 text-sm focus:ring-blue-500 focus:border-blue-500 block w-full py-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="1" required>
                                            <button type="button" id="increment-button-{{ $product->id }}" data-product-id="{{ $product->id }}" data-input-counter-increment="quantity-input-{{ $product->id }}" class="increment-button bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 border border-gray-300 rounded-e-lg p-3 h-11 focus:ring-gray-100 dark:focus:ring-gray-700 focus:ring-2 focus:outline-none">
                                                <svg class="w-3 h-3 text-gray-900 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16" />
                                                </svg>
                                            </button>
                                        </div>
                                        <x-success-button type="submit" class="ms-3" >
                                            <svg class="w-6 me-2 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 10V6a3 3 0 0 1 3-3v0a3 3 0 0 1 3 3v4m3-2 1 12c0 .5-.5 1-1 1H6a1 1 0 0 1-1-1L6 8h12Z" />
                                            </svg>
                                            Покупка
                                        </x-success-button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    @endif
                    @endforeach

                </div>
            </div>
        </div>
    </div>
    <div id="toast-container" class="toast-container" />
</x-app-layout>

<script>
    function createSuccessToast() {
        // Create a new toast element
        var toast = document.createElement('div');
        var toastId = 'toast-' + Date.now(); // Unique ID for each toast
        toast.setAttribute('id', toastId);
        toast.classList.add('fixed', 'right-5', 'flex', 'items-center', 'w-full', 'max-w-xs', 'p-4', 'mb-4', 'text-gray-500', 'bg-white', 'rounded-lg', 'shadow', 'dark:text-gray-400', 'dark:bg-gray-800', 'toast');
        toast.setAttribute('role', 'alert');
        toast.style.transition = 'opacity 0.3s ease-in-out';

        toast.style.position = 'fixed';
        toast.style.bottom = '1rem'; // Adjust this value to set the distance between toasts
        toast.style.right = '1rem'; // Adjust this value to set the distance between toasts
        toast.style.transform = 'translateX(+0%) translateY(-' + (document.querySelectorAll('.toast').length * 35) + 'px)'; // Adjust this value to control the vertical stacking
        toast.style.opacity = '0';
        // Construct toast content
        toast.innerHTML = `
        <!-- Your toast content -->
        <div class="toast inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200">
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
            </svg>
            <span class="sr-only">Check icon</span>
        </div>
        <div class="ms-3 text-sm font-normal">Успешно добавено в количката!</div>
        <button type="button" class="close-toast-button" aria-label="Close">
            <!-- Your close button content -->
        </button>
    `;

        // Append the toast to the container
        var toastContainer = document.getElementById('toast-container');
        toastContainer.appendChild(toast);

        // Animate the toast appearance
        setTimeout(function() {
            toast.style.opacity = '1';
        }, 100); // Adding a slight delay for smoother animation

        // Remove the toast after 3 seconds
        setTimeout(function() {
            toast.style.opacity = '0';
            setTimeout(function() {
                toast.remove();
            }, 300); // Additional delay to ensure the fade-out transition completes
        }, 3000);
    }

    function createFailToast() {
        // Create a new toast element
        var toast = document.createElement('div');
        var toastId = 'toast-' + Date.now(); // Unique ID for each toast
        toast.setAttribute('id', toastId);
        toast.classList.add('fixed', 'right-5', 'flex', 'items-center', 'w-full', 'max-w-xs', 'p-4', 'mb-4', 'text-gray-500', 'bg-white', 'rounded-lg', 'shadow', 'dark:text-gray-400', 'dark:bg-gray-800', 'toast');
        toast.setAttribute('role', 'alert');
        toast.style.transition = 'opacity 0.3s ease-in-out';

        toast.style.position = 'fixed';
        toast.style.bottom = '1rem'; // Adjust this value to set the distance between toasts
        toast.style.right = '1rem'; // Adjust this value to set the distance between toasts
        toast.style.transform = 'translateX(+0%) translateY(-' + (document.querySelectorAll('.toast').length * 35) + 'px)'; // Adjust this value to control the vertical stacking
        toast.style.opacity = '0';
        // Construct toast content
        toast.innerHTML = `
        <!-- Your toast content -->
        <div class="toast inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-orange-500 bg-orange-100 rounded-lg dark:bg-orange-700 dark:text-orange-200">
        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM10 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm1-4a1 1 0 0 1-2 0V6a1 1 0 0 1 2 0v5Z"/>
        </svg>
        <span class="sr-only">Warning icon</span>
    </div>
        <div class="ms-3 text-sm font-normal">Максимално количество достигнато!</div>
        <button type="button" class="close-toast-button" aria-label="Close">
            <!-- Your close button content -->
        </button>
    `;

        // Append the toast to the container
        var toastContainer = document.getElementById('toast-container');
        toastContainer.appendChild(toast);

        // Animate the toast appearance
        setTimeout(function() {
            toast.style.opacity = '1';
        }, 100); // Adding a slight delay for smoother animation

        // Remove the toast after 3 seconds
        setTimeout(function() {
            toast.style.opacity = '0';
            setTimeout(function() {
                toast.remove();
            }, 300); // Additional delay to ensure the fade-out transition completes
        }, 3000);
    }


    $('.add-to-cart').on('click', function() {
        let productId = $(this).data('product-id');
        $.ajax({
            url: '/add-to-cart',
            method: 'POST',
            data: {
                product_id: productId,
                "_token": "{{ csrf_token() }}"
            },
            success: function(response) {
                createSuccessToast();
            },
            error: function(xhr, status, error) {
                if (xhr.status === 422) {
                    // Display the error message from the response
                    createFailToast();
                } else {
                    // Handle other errors
                    console.error('Error:', error);
                    console.error('Status:', status);
                    console.error('Response Text:', xhr.responseText);
                }
            }


        });
    });
</script>