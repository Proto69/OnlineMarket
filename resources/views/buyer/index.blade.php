<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Пазаруване') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-xl sm:rounded-lg">
                <div class="bg-transparent bg-opacity-25 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 lg:gap-6 p-6">

                    @foreach($products as $product)
                    @if ($product->active)
                    <div class="w-full max-w-sm bg-white border border-gray-300 rounded-lg shadow dark:bg-gray-800 p-4">
                        <img class="mt-1 mb-2 ms-5" src="{{ $product->getImageURL() }}">

                        <div class="px-5 pb-5">
                            <a href="#">
                                <h5 class="text-xl font-semibold tracking-tight text-gray-900 dark:text-white">{{ $product->name }}</h5>
                            </a>
                            <div class="flex items-center mt-2.5 mb-5">
                                <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                                    {{ $product->description }}
                                    <br />
                                    Налично количество: {{ $product->quantity }}
                                </p>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-3xl font-bold text-gray-900 dark:text-white">${{ $product->price }}</span>
                                @if ($product->quantity !== 0)
                                <x-button class="add-to-cart mt-3" data-product-id="{{ $product->id }}">Добави в количка</x-button>
                                @else
                                <x-button class="mt-3" disabled>Изчерпан</x-button>
                                @endif

                                <input type="hidden" name="product_id" value="{{ $product->id }}">
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
    function createToast() {
        // Create a new toast element
        var toast = document.createElement('div');
        var toastId = 'toast-' + Date.now(); // Unique ID for each toast
        toast.setAttribute('id', toastId);
        toast.classList.add('fixed', 'right-5', 'flex', 'items-center', 'w-full', 'max-w-xs', 'p-4', 'mb-4', 'text-gray-500', 'bg-white', 'rounded-lg', 'shadow', 'dark:text-gray-400', 'dark:bg-gray-800', 'toast');
        toast.setAttribute('role', 'alert');
        toast.style.transition = 'opacity 0.3s ease-in-out';

        toast.style.position = 'absolute';
        toast.style.bottom = '1px'; // Adjust this value to set the distance between toasts
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
                createToast();
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                console.error('Status:', status);
                console.error('Response Text:', xhr.responseText);
            }

        });
    });
</script>