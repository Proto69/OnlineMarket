@php
use App\Models\Product;
use App\Models\Log;
use Illuminate\Support\Facades\Auth;
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
            <div id="accordion-collapse" data-accordion="open">
                @foreach($formattedOrders as $formattedOrder)


                <h2 id="accordion-collapse-heading-{{ $formattedOrder['order']->id }}">
                    <button type="button" aria-expanded="false" class="mt-3 flex items-center justify-between w-full p-5 font-medium rtl:text-right text-gray-500 border border-gray-200 rounded-xl focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 gap-3" data-accordion-target="#accordion-collapse-body-{{ $formattedOrder['order']->id }}" aria-expanded="true" aria-controls="accordion-collapse-body-{{ $formattedOrder['order']->id }}">
                        <span>
                            Поръчка № {{ $formattedOrder['order']->id }}
                        </span>

                        @php

                        $is_sent = true;
                        $is_delivered = true;
                        $logs = Log::where('order_id', $formattedOrder['order']->id)->where('sellers_user_id', Auth::user()->id)->get();
                        
                        foreach($logs as $log){
                            if (!$log->is_sent){
                                $is_sent = false;
                            }
                            if (!$log->is_delivered){
                                $is_delivered = false;
                            }
                        }
                        @endphp

                        @if (!$is_sent && !$is_delivered)
                        <p class="tracking-tighter text-gray-500 md:text-lg dark:text-gray-400">
                            <x-unpaid-log class="text-green-600 dark:text-green-400 ">Поръчката чака изпращане!</x-unpaid-log>
                        </p>
                        @elseif ($is_sent && !$is_delivered)
                        <p class="tracking-tighter text-gray-500 md:text-lg dark:text-gray-400">
                            <x-paid-log class="text-green-600 dark:text-green-400 ">Поръчката е изпратена успешно!</x-paid-log>
                        </p>
                        @elseif ($is_sent && $is_delivered)
                        <p class="tracking-tighter text-gray-500 md:text-lg dark:text-gray-400">
                            <x-paid-log class="text-green-600 dark:text-green-400">Поръчката е получена успешно!</x-paid-log>
                        </p>
                        @endif
                        <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5" />
                        </svg>
                    </button>
                </h2>
                <div id="accordion-collapse-body-{{ $formattedOrder['order']->id }}" class="hidden" aria-labelledby="accordion-collapse-heading-{{ $formattedOrder['order']->id }}">
                    <div class="p-5 border border-t-0 border-gray-200 dark:border-gray-700 dark:bg-gray-900 rounded-xl">

                        @foreach($formattedOrder['products'] as $product)

                        <p class="tracking-tighter text-gray-500 md:text-lg dark:text-gray-400 mb-1">
                            <x-paid-log class="text-green-600 dark:text-green-400">{{ Product::find($product['product_id'])->name }}</x-paid-log> x <x-paid-log class="text-green-600 dark:text-green-400">{{ $product['quantity'] }}</x-paid-log> броя за <x-paid-log class="text-green-600 dark:text-green-400">{{ $formattedOrder['total_amount'] }}</x-paid-log>лв.
                        </p>

                        @endforeach

                        <h1 class="text-xl text-gray-800 dark:text-gray-300">
                            Информация за доставка:
                            <br />
                            Получател: <strong class="text-sky-600 dark:text-sky-300">{{ $formattedOrder['order']->full_name }}</strong>
                            <br />
                            Телефонен номер: <strong class="text-sky-600 dark:text-sky-300">{{ $formattedOrder['order']->phone }}</strong>
                            <br />
                            Адрес за доставка: <strong class="text-sky-600 dark:text-sky-300">{{ $formattedOrder['order']->address}}</strong>
                            <br />
                            Обща сума: <strong class="text-sky-600 dark:text-sky-300">{{ $formattedOrder['total_amount'] }}лв</strong>
                        </h1>

                        @if (!$is_sent && !$is_delivered)

                        <form method="POST" action="{{ route('mark-order-as-sent', $formattedOrder['order']->id) }}" class="md:inline ">
                            @csrf
                            <x-success-button type="submit" class="mt-3 mx-1">
                                Изпрати поръчка
                            </x-success-button>
                        </form>
                        @endif

                    </div>
                </div>


                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>