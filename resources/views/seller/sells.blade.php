@php
use App\Models\Product;
use App\Models\Order;
@endphp

<x-app-layout>
    @section('title', $title)
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Продажби') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @foreach($logs as $log)
            <div class="bg-white dark:bg-gray-800 overflow-hidden py-1 shadow-xl sm:rounded-lg mx-10 border-2 border-gray-200 rounded-lg dark:border-gray-700 mt-3">
                <p class="text-center tracking-tighter text-gray-500 md:text-lg dark:text-gray-400">
                    <strong class="text-green-600 dark:text-green-400">{{ Product::find($log->product)->name }}</strong> x <strong class="text-green-600 dark:text-green-400">{{ $log->quantity }}</strong> броя. Продадено на <strong class="text-green-600 dark:text-green-400">{{ $log->created_at }}</strong> за <strong class="text-green-600 dark:text-green-400">{{ Product::where('id', $log->product)->first()->price * $log->quantity }}</strong>лв. 
                    <br />
                    Доставка на <strong class="text-green-600 dark:text-green-400">{{ Order::find($log->order_id)->address}}</strong>. Телефон за връзка с <strong class="text-green-600 dark:text-green-400">{{ Order::find($log->order_id)->full_name }}</strong>: <strong class="text-green-600 dark:text-green-400">{{ Order::find($log->order_id)->phone}}</strong>
                </p>

            </div>
            @endforeach

        </div>
    </div>
</x-app-layout>