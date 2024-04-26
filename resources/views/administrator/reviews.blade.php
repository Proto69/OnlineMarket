@php
use App\Models\User;
@endphp
<x-app-layout>
    @section('title', "Всички ревюта")
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight inline">
                {{ __('Всички ревюта') }}
            </h2>
        </div>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="overflow-hidden shadow-xl sm:rounded-lg">
                <div class="bg-transparent bg-opacity-25 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 lg:gap-6 p-6">

                    @foreach($reviews as $review)

                    <div class="card-form relative min-w-80 bg-white dark:bg-gray-800 border border-gray-300 p-4 rounded-lg flex flex-col h-full items-center">

                        <div class="mb-2 flex-grow">
                            <!-- Seller Name -->
                            <h5 class="text-xl font-semibold tracking-tight text-gray-900 dark:text-white">{{ $review->text }}</h5>
                        </div>

                        <div class="mt-auto mb-2 flex items-center justify-between">
                            @if ($review->is_deleted)
                            <form action="{{ route('activate-comment-admin', $review->id) }}" method="POST">
                                @csrf
                                <x-success-button type="submit" class="mt-3">
                                    Активирай ревю
                                </x-success-button>
                            </form>
                            @else
                            <form action="{{ route('deactivate-comment-admin', $review->id) }}" method="POST">
                                @csrf
                                <x-danger-button type="submit" class="mt-3">
                                    Деактивирай ревю
                                </x-danger-button>
                            </form>
                            @endif
                        </div>
                    </div>

                    @endforeach

                </div>
            </div>
        </div>
    </div>
</x-app-layout>