@php
use App\Models\Product;
@endphp

<x-app-layout>
    @section('title', $title)
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Минали покупки') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div id="accordion-collapse" data-accordion="open">

                @foreach($orders as $order)

                <h2 id="accordion-collapse-heading-{{ $order->id }}">
                    <button type="button" aria-expanded="false" class="mt-3 flex items-center justify-between w-full p-5 font-medium rtl:text-right text-gray-500 border border-gray-200 rounded-xl focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 gap-3" data-accordion-target="#accordion-collapse-body-{{ $order->id }}" aria-expanded="true" aria-controls="accordion-collapse-body-{{ $order->id }}">
                        <span>
                            Поръчка № {{ $order->id }}

                        </span>
                        @if ($order->is_sent && !$order->is_delivered)
                        <p class="tracking-tighter text-gray-500 md:text-lg dark:text-gray-400">
                            <x-paid-log>Изпратена</x-paid-log>
                        </p>
                        @elseif ($order->is_sent && $order->is_delivered)
                        <p class="tracking-tighter text-gray-500 md:text-lg dark:text-gray-400">
                            <x-paid-log>Получена</x-paid-log>
                        </p>
                        @elseif (!$order->is_sent && !$order->is_delivered && $order->is_paid)
                        <p class="tracking-tighter text-gray-500 md:text-lg dark:text-gray-400">
                            <x-unpaid-log>Чакащо изпращане</x-unpaid-log>
                        </p>
                        @endif
                        @if($order->is_paid)
                        <strong class="text-green-600 dark:text-green-400 me-10">Платена</strong>
                        @else
                        <strong class="text-red-600 dark:text-red-400 me-10">Неплатена</strong>
                        @endif
                        <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5" />
                        </svg>
                    </button>
                </h2>
                <div id="accordion-collapse-body-{{ $order->id }}" class="hidden" aria-labelledby="accordion-collapse-heading-{{ $order->id }}">
                    <div class="p-5 border border-t-0 border-gray-200 dark:border-gray-700 dark:bg-gray-900 rounded-xl">

                        @foreach($logs as $log)

                        @if($order->is_paid && $log->order_id == $order->id)
                        <form method="POST" action="{{ route('mark-log-as-delivered', $log->id) }}" class="inline">
                            @csrf
                            <p class="tracking-tighter text-gray-500 md:text-lg dark:text-gray-400 mb-1">
                                <x-paid-log>{{ Product::where('id', $log->product)->first()->name }}</x-paid-log> x <x-paid-log>{{ $log->quantity }}</x-paid-log> броя. Закупено на <x-paid-log>{{ $log->created_at }}</x-paid-log> за <x-paid-log>{{ Product::where('id', $log->product)->first()->price * $log->quantity }}</x-paid-log>лв.
                                @if ($log->is_sent && !$log->is_delivered)
                                <a href="#" class="mx-1 my-2 text text-green-600 dark:text-green-400 border rounded-lg py-1 px-2 border-green-600 dark:border-green-400" onclick="event.preventDefault(); this.closest('form').submit();">
                                    Маркирай като получен
                                </a>
                                @elseif ($log->is_sent && $log->is_delivered)
                                <x-paid-log>Получен</x-paid-log>
                                @endif
                            </p>

                        </form>


                        @elseif ($log->order_id == $order->id)
                        <p class="tracking-tighter text-gray-500 md:text-lg dark:text-gray-400 mb-1">
                            <x-unpaid-log>{{ Product::where('id', $log->product)->first()->name }}</x-unpaid-log> x <x-unpaid-log>{{ $log->quantity }}</x-unpaid-log> броя. Закупено на <x-unpaid-log>{{ $log->created_at }}</x-unpaid-log> за <x-unpaid-log>{{ Product::where('id', $log->product)->first()->price * $log->quantity }}</x-unpaid-log>лв.
                        </p>
                        @endif

                        @endforeach

                        <h1 class="text-xl text-gray-800 dark:text-gray-300">
                            Информация за доставка:
                            <br />
                            Получател: <strong class="text-sky-600 dark:text-sky-300">{{ $order->full_name }}</strong>
                            <br />
                            Телефонен номер: <strong class="text-sky-600 dark:text-sky-300">{{ $order->phone }}</strong>
                            <br />
                            Адрес за доставка: <strong class="text-sky-600 dark:text-sky-300">{{ $order->address}}</strong>
                            <br />
                            Обща сума: <strong class="text-sky-600 dark:text-sky-300">{{ $order->total_price }}лв</strong>
                        </h1>

                        @if(!$order->is_paid)

                        <form method="POST" action="{{ route('pay-order', $order->id) }}" class="md:inline ">
                            @csrf
                            <x-success-button type="submit" class="mt-3 mx-1">
                                Плати Поръчка
                            </x-success-button>
                        </form>

                        <form method="GET" action="{{ route('edit-order', $order->id) }}" class="md:inline">
                            @csrf
                            <x-basic-button type="submit" class="mx-1">
                                Промени поръчка
                            </x-basic-button>
                        </form>

                        <form method="POST" action="{{ route('delete-order', $order->id) }}" class="md:inline">
                            @csrf
                            <x-danger-button type="submit" class="mx-1">
                                Изтрий поръчка
                            </x-danger-button>
                        </form>

                        @endif


                    </div>
                </div>


                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>