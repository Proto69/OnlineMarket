<x-app-layout>
    @section('title', 'Данни за доставка')
    <x-slot name="header">
        <div class="grid grid-cols-5 gap-4 text-gray-800 dark:text-gray-200">

            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight col-span-4">
                Данни за доставка
            </h2>
            <x-success-button class="col-end-7 col-span-1 shrinkable-button" type="submit" data-modal-target="createProductModal" data-modal-toggle="createProductModal">
                Създай данни за доставка
            </x-success-button>

            <!-- Create product modal -->
            <div id="createProductModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
                <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
                    <!-- Modal content -->
                    <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                        <form id="newAddressData" action="{{ route('new-address') }}" method="POST">
                            @csrf
                            <!-- Modal header -->
                            <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                    Добавяне на данни за доставка
                                </h3>
                                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="createProductModal">
                                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="sr-only">Close modal</span>
                                </button>
                            </div>
                            <!-- Modal body -->
                            <div class="grid gap-4 mb-4 sm:grid-cols-1">
                                <div>
                                    <label for="full_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Пълно име</label>
                                    @error('full_name')
                                    <p class="text-red-500 text-sm mt-1 mb-1">{{ $message }}</p>
                                    @enderror
                                    <x-modal-input type="text" name="full_name" id="full_name" placeholder="Пълно име на получател" value="{{ old('full_name') }}" required />
                                </div>
                                <div class="relative">
                                    <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Телефонен номер</label>
                                    @error('phone')
                                    <p class="text-red-500 text-sm mt-1 mb-1">{{ $message }}</p>
                                    @enderror
                                    <x-modal-input type="text" name="phone" id="phone" placeholder="+35987654321" value="{{ old('phone') }}" required />
                                </div>
                                <div>
                                    <label for="address" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Адрес за доставка</label>
                                    @error('address')
                                    <p class="text-red-500 text-sm mt-1 mb-1">{{ $message }}</p>
                                    @enderror
                                    <x-modal-input value="{{ old('address') }}" type="text" name="address" id="address" placeholder="ул. Иван Вазов №1" required />
                                </div>
                            </div>
                            <x-success-button type="submit">
                                <svg class="mr-1 -ml-1 w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                                </svg>
                                Създай
                            </x-success-button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div id="accordion-collapse" data-accordion="open">

                @if (!$addresses->isEmpty())
                @foreach($addresses as $address)
                <h2 id="accordion-collapse-heading-{{ $address->id }}">
                    <button type="button" aria-expanded="false" class="mt-3 flex items-center justify-between w-full p-5 font-medium rtl:text-right text-gray-500 border border-gray-200 rounded-xl focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 gap-3" data-accordion-target="#accordion-collapse-body-{{ $address->id }}" aria-expanded="true" aria-controls="accordion-collapse-body-{{ $address->id }}">
                        <span>
                            {{ $address->full_name }}
                        </span>
                        <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5" />
                        </svg>

                    </button>
                </h2>
                <div id="accordion-collapse-body-{{ $address->id }}" class="hidden" aria-labelledby="accordion-collapse-heading-{{ $address->id }}">
                    <div class="p-5 border border-t-0 border-gray-200 dark:border-gray-700 dark:bg-gray-900 rounded-xl">
                        <h1 class="text-xl text-gray-800 dark:text-gray-300">
                            Информация за доставка:
                            <br />
                            Име на получател: <strong class="text-sky-600 dark:text-sky-300">{{ $address->full_name }}</strong>
                            <br />
                            Телефонен номер: <strong class="text-sky-600 dark:text-sky-300">{{ $address->phone }}</strong>
                            <br />
                            Адрес за доставка: <strong class="text-sky-600 dark:text-sky-300">{{ $address->address}}</strong>
                        </h1>


                        <x-basic-button id="updateProductButton-{{ $address->id }}" data-modal-target="updateProductModal-{{ $address->id }}" data-modal-toggle="updateProductModal-{{ $address->id }}" class="mt-3">
                            Промени адрес
                        </x-basic-button>

                        <!-- Main modal -->
                        <div id="updateProductModal-{{ $address->id }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
                            <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
                                <!-- Modal content -->
                                <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                                    <!-- Modal header -->
                                    <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                            Промяна на адрес
                                        </h3>
                                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="updateProductModal-{{ $address->id }}">
                                            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span class="sr-only">Close modal</span>
                                        </button>
                                    </div>
                                    <!-- Modal body -->
                                    <form action="{{ route('edit-billing-address', $address->id) }}" method="POST">
                                        @csrf
                                        <div class="grid gap-4 mb-4 sm:grid-cols-2">
                                            <div>
                                                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Пълно име</label>
                                                <input type="text" name="full_name" id="full_name" value="{{ $address->full_name }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Пълно име на купувача">
                                            </div>
                                            <div>
                                                <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Телефонен номер</label>
                                                <input type="text" name="phone" id="phone" value="{{ $address->phone }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="0898765432">
                                            </div>
                                            <div class="sm:col-span-2">
                                                <label for="address" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Адрес за доставка</label>
                                                <input type="text" value="{{ $address->address }}" name="address" id="address" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="ул. Иван Вазов №1 гр. София област София">
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-4">
                                            <x-success-button type="submit" class="text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                                                Запази промените
                                            </x-success-button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('delete-billing-address', $address->id) }}" class="md:inline mt-3">
                            @csrf
                            <x-danger-button type="submit" class="mx-1">
                                Изтрий адрес
                            </x-danger-button>
                        </form>
                    </div>
                </div>
                @endforeach
                @else
                <h2 class="mt-3 flex items-center justify-between w-full p-5 font-medium rtl:text-right text-gray-500 border border-gray-200 rounded-xl focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 gap-3">
                    Нямате запазени данни за доставка!
                </h2>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>