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
                            <x-button class="mt-3"> Buy</x-button>
                            @else
                            <x-button class="mt-3" disabled> Buy</x-button>
                            @endif
                        </div>
                    </form>
                    @endforeach
                </div>
                @if (session('success'))
                <x-alert color="bg-green-100 border-green-400 text-green-700" title="Success!" message="{{ session('success') }}" iconColor="text-green-500" />
                @endif
                @if (session('error'))
                <x-alert color="bg-red-100 border-red-400 text-red-700" title="Error!" message="{{ session('error') }}" iconColor="text-red-500" />
                @endif
            </div>
        </div>
    </div>
</x-app-layout>