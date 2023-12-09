<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Shopping') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="bg-gray-200 dark:bg-gray-800 bg-opacity-25 grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 p-6 lg:p-8">

                    @foreach($products as $product)
                    <form method="POST" action="{{ route('add.to.shopping.list', $product->id) }}">
                        @csrf
                        <div>
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-6 h-6 stroke-gray-400">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                                </svg>
                                <h2 class="ml-3 text-xl font-semibold text-gray-900 dark:text-white">
                                    <a href="https://laravel.com/docs">{{ $product->name}}</a>
                                </h2>
                            </div>
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                                {{ $product->description }}
                                <br />
                                Available quantity: {{ $product->quantity }}
                            </p>

                            @if ($product->active)
                            <x-button id="buy-button" class="mt-3"> Buy</x-button>
                            @else
                            <x-button class="mt-3" disabled> Buy</x-button>
                            @endif
                        </div>
                    </form>
                    @endforeach
                </div>
                @if (session('success'))
                <div id="toast-success" class="fixed bottom-5 right-5 flex items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800" role="alert">
                    <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200">
                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                        </svg>
                        <span class="sr-only">Check icon</span>
                    </div>
                    <div class="ms-3 text-sm font-normal">Item moved successfully.</div>
                    <button type="button" id="close-toast-button" class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" data-dismiss-target="#toast-success" aria-label="Close">
                        <span class="sr-only">Close</span>
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                    </button>
                </div>
                @endif
                @if (session('error'))
                <x-alert color="bg-red-100 border-red-400 text-red-700" title="Error!" message="{{ session('error') }}" iconColor="text-red-500" />
                @endif
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    // Get the toast element
    const button = document.getElementById('close-toast-button');

    // Set a timeout to hide the toast after 3 seconds
    setTimeout(() => {
        button.click(); // Hide the toast by changing its display property
    }, 3000); // 3000 milliseconds = 3 seconds

    // Assuming you have a button click or some event triggering the AJAX request
    document.getElementById('buy-button').addEventListener('click', function() {
        // Your AJAX request
        fetch('/add.to.shopping.list/' + productId, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Assuming you use CSRF protection
                },
                body: JSON.stringify({})
            })
            .then(response => {
                if (response.ok) {
                    // Update the session message if the request was successful
                    fetch('/get-session-message')
                        .then(response => response.json())
                        .then(data => {
                            // Use data.success to display a success message
                            console.log('Session success message:', data.success);
                        });
                } else {
                    console.log('Error occurred during request.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    });
</script>