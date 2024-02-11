<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <div class="shadow-md rounded-lg p-6">
            <div class="flex items-center justify-center mb-6">
                <svg class="w-[48px] h-[48px] text-red-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" d="M2 12a10 10 0 1 1 20 0 10 10 0 0 1-20 0Zm11-4a1 1 0 1 0-2 0v5a1 1 0 1 0 2 0V8Zm-1 7a1 1 0 1 0 0 2 1 1 0 1 0 0-2Z" clip-rule="evenodd" />
                </svg>


                <h1 class="text-4xl font-bold text-center text-gray-800 dark:text-gray-100 mx-4">Покупката не е завършена!</h1>

                <svg class="w-[48px] h-[48px] text-red-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" d="M2 12a10 10 0 1 1 20 0 10 10 0 0 1-20 0Zm11-4a1 1 0 1 0-2 0v5a1 1 0 1 0 2 0V8Zm-1 7a1 1 0 1 0 0 2 1 1 0 1 0 0-2Z" clip-rule="evenodd" />
                </svg>
            </div>

            <div class="text-center text-3xl text-gray-700 dark:text-gray-200 mb-6">
                Плащането е <strong class="text-red-600">неуспешно</strong>!

                <form action="{{ route('pay-order', $orderId) }}" method="POST">
                    @csrf
                    <x-success-button type="submit" class="mt-6">
                        <g class="text-xl">Завърши поръчка</g>
                    </x-success-button>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>