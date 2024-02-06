<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Продажби') }}
        </h2>

        <!-- For testing -->
        <form action="{{ route('test') }}" method="POST">
            @csrf
            <x-success-button type="submit">
                Test
            </x-success-button>
        </form>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden py-1 shadow-xl sm:rounded-lg mx-10 border-2 border-gray-200 rounded-lg dark:border-gray-700 mt-3">
                <p class="text-center tracking-tighter text-gray-500 md:text-lg dark:text-gray-400"><strong>Smartphone</strong> x <strong>12</strong> броя. Продадено на <strong>2024.02.01</strong> за <strong>7200</strong>лв.</p>
            </div>
        </div>
    </div>
</x-app-layout>