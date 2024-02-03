<x-app-layout>
    <x-slot name="header">
        <div class="grid grid-cols-5 gap-4 text-gray-800 dark:text-gray-200">
            <h2 class="font-semibold text-xl leading-tight">
                {{ __('Табло') }}
            </h2>
            <form class="col-end-7 col-span-1" action="{{ route('new-product') }}" method="GET">
                <x-success-button type="submit">
                    Добави нов продукт
                </x-success-button>
            </form>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-transparent dark:bg-transparent overflow-hidden shadow-xl sm:rounded-lg">
                <div class="bg-transparent bg-opacity-25 grid grid-cols-1 md:grid-cols-4 gap-4 p-3">

                    @foreach ($products as $product)
                    <form method="GET" action="{{ route('edit-product', $product->id) }}">
                        @csrf
                        <div class="card-form bg-white dark:bg-gray-800 border border-gray-300 p-4 rounded-lg">
                            <!-- Показване и качване на снимка  -->
                            <img class="mt-1 mb-2 productImage" src="{{ $product->getImageURL() }}">
                            <input type="hidden" class="productId" value="{{ $product->id }}"></input>

                            <!-- Име на продукта -->
                            <div class="flex items-center">
                                <label class="block mb-2 text-xl font-medium text-gray-900 dark:text-white">{{ $product->name }}</label>
                            </div>

                            <!-- Описание -->
                            <p class="text-gray-500 dark:text-gray-400 text-xl bg-white">
                                {{ $product->description }}
                            </p>

                            <!-- Количество -->
                            <label for="quantity-input" class="block mb-2 text-xl font-medium text-gray-900 dark:text-white">Количество: {{ $product->quantity }}</label>

                            <!-- Цена -->
                            <label class="text-xl block mt-3 text-sm font-medium text-gray-900 dark:text-white ">Цена: {{ $product->price }}</label>
                            <br />

                            <!-- Изчерпан продукт -->
                            @if ($product->quantity === 0)
                            <cr class="sold-product mt-2 text-red-800 dark:text-red-500 font-bold">Този продукт е изчерпан!</cr>
                            <br />
                            @endif


                            <!-- Активен/Неактивен switch -->
                            <span class="activity-state state text-xxl font-medium text-gray-900 dark:text-gray-300">{{ $product->active ? 'Активен' : 'Неактивен'}}</span>
                            <br />
                            <label class="mt-3 relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" value="" class="sr-only peer activity-toggle" {{ $product->active ? 'checked' : '' }}>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                            </label>
                            <br />

                            <x-success-button class="mt-3" type="submit" data-product-id="{{ $product->id }}">
                                Промени продукт
                            </x-success-button>
                        </div>
                    </form>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div id="toast-container" class="toast-container" />
</x-app-layout>

<script>
    function createToast(state) {
        // Create a new toast element
        var toast = document.createElement('div');
        var toastId = 'toast-' + Date.now(); // Unique ID for each toast
        toast.setAttribute('id', toastId);
        toast.classList.add('fixed', 'right-5', 'flex', 'items-center', 'w-full', 'max-w-xs', 'p-4', 'mb-4', 'text-gray-500', 'bg-white', 'rounded-lg', 'shadow', 'dark:text-gray-400', 'dark:bg-gray-800', 'toast');
        toast.setAttribute('role', 'alert');
        toast.style.transition = 'opacity 0.3s ease-in-out';

        toast.style.position = 'fixed';
        toast.style.bottom = '1rem'; // Adjust this value to set the distance between toasts
        toast.style.right = '1rem';
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
        <div class="ms-3 text-sm font-normal">Успешно <strong>` + state + `</strong>  продукт!</div>
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

    $('.activity-toggle').on('change', function() {
        let cardForm = $(this).closest('.card-form');
        let activityState = cardForm.find('.activity-state');
        let id = cardForm.find('.productId').val();

        //  maybe could be used for smth
        let message = cardForm.find('.unactive-product');

        if (this.checked) {
            activityState.text('Активен');
            updateStatus(id, 1);
            createToast('активирахте');
        } else {
            activityState.text('Неактивен');
            updateStatus(id, 0);
            createToast('деактивирахте');
        }
    });


    function updateStatus(productId, status) {
        $.ajax({
            url: '/change-status/' + productId + '/' + status,
            method: 'POST',
            data: {
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