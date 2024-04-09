<x-app-layout>
	@section('title', $title)
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="fixed top-44 left-2 bottom-12 min-w-[320px] items-center mr-16 bg-white border border-lime-500 rounded-lg shadow-md dark:bg-gray-800 dark:border-lime-400 dark:hover:bg-gray-700 sm:rounded-lg pt-3 w-1/4">
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

            <div class="fixed top-44 right-2 bottom-12 min-w-[320px] items-center mr-16 bg-white border border-lime-500 rounded-lg shadow-md dark:bg-gray-800 dark:border-lime-400 dark:hover:bg-gray-700 sm:rounded-lg pt-3 w-1/4">
                <div class="px-4">
                    <h2 class="dark:text-white text-black font-bold px-20 text-xl pb-3">
                        Данни за доставка
                    </h2>
                </div>
                
            </div>
        </div>
    </div>
</x-app-layout>