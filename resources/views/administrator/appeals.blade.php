@php
use App\Models\Punishment;
@endphp
<x-app-layout>
    @section('title', "Обжалвания")
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight inline">
                {{ __('Обжалвания') }}
            </h2>

            <form action="{{ route('search-appeals') }}" method="GET" class="inline">
                @csrf
                <div class="flex items-center">
                    <x-input type="search" name="keyWord" id="default-search" class="w-96 p-3 ps-5" placeholder="Търси акаунт . . ." required />
                </div>
            </form>
        </div>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (count($appeals) == 0)
            <div class="overflow-hidden shadow-xl sm:rounded-lg text-center pb-5">

                <x-paid-log class="text-3xl text-center">Няма подадени обжалвания!</x-paid-log>

            </div>

            @else
            <div class="overflow-hidden shadow-xl sm:rounded-lg text-center">
                <div class="bg-transparent bg-opacity-25 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 lg:gap-6 p-6">
                    @foreach($appeals as $appeal)

                    <div class="card-form relative min-w-80 bg-white dark:bg-gray-800 border border-gray-300 p-4 rounded-lg flex flex-col h-full items-center">

                        <div class="mb-2 flex-grow">
                            <!-- Seller Name -->
                            <h5 class="text-xl font-semibold tracking-tight text-gray-900 dark:text-white">{{ $appeal->name }}</h5>
                        </div>

                        <x-paid-log>{{ $appeal->text }}</x-paid-log>

                        <div class="mt-auto mb-2 flex items-center justify-between">
                            <form action="{{ route('activate-account-admin', $appeal->user_id) }}" method="POST">
                                @csrf
                                <x-success-button type="submit" class="mt-3">
                                    Активирай акаунт
                                </x-success-button>
                            </form>
                        </div>
                    </div>

                    @endforeach
                </div>
            </div>
            @endif

        </div>
    </div>
</x-app-layout>