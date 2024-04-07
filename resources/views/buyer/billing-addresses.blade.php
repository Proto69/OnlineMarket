<x-app-layout>
    @section('title', 'Данни за доставка')
    <x-slot name="header">
        <div class="grid grid-cols-5 gap-4 text-gray-800 dark:text-gray-200">

            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Данни за доставка') }}
            </h2>
            <x-success-button class="col-end-7 col-span-1" type="submit" data-modal-target="createProductModal" data-modal-toggle="createProductModal">
                СЪздай данни за доставка
            </x-success-button>

            <!-- Create product modal -->
            <div id="createProductModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
                <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
                    <!-- Modal content -->
                    <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                        <form id="newProductForm" enctype="multipart/form-data" action="{{ route('new-product-add') }}" method="POST">
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
                                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Пълно име</label>
                                    @error('name')
                                    <p class="text-red-500 text-sm mt-1 mb-1">{{ $message }}</p>
                                    @enderror
                                    <x-modal-input type="text" name="name" id="name" placeholder="Пълно име на получател" value="{{ old('name') }}" required />
                                </div>
                                <div class="relative">
                                    @error('phone')
                                    <p class="text-red-500 text-sm mt-1 mb-1">{{ $message }}</p>
                                    @enderror
                                    <span class="absolute start-0 bottom-3 text-gray-500 dark:text-gray-400">
                                        <svg class="w-4 h-4 rtl:rotate-[270deg]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 19 18">
                                            <path d="M18 13.446a3.02 3.02 0 0 0-.946-1.985l-1.4-1.4a3.054 3.054 0 0 0-4.218 0l-.7.7a.983.983 0 0 1-1.39 0l-2.1-2.1a.983.983 0 0 1 0-1.389l.7-.7a2.98 2.98 0 0 0 0-4.217l-1.4-1.4a2.824 2.824 0 0 0-4.218 0c-3.619 3.619-3 8.229 1.752 12.979C6.785 16.639 9.45 18 11.912 18a7.175 7.175 0 0 0 5.139-2.325A2.9 2.9 0 0 0 18 13.446Z" />
                                        </svg>
                                    </span>
                                    <input type="text" id="floating-phone-number" name="phone" class="block py-2.5 ps-6 pe-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" pattern="[0-9]{10}" placeholder=" " />
                                    <label for="floating-phone-number" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-placeholder-shown:start-6 peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">Телефонен номер</label>
                                </div>
                                <div>
                                    <label for="quantity" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Адрес за доставка</label>
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
                <h2 id="accordion-collapse-heading-{{ $address->full_name }}-{{ $address->address }}-{{ $address->phone }}">
                    <button type="button" aria-expanded="false" class="mt-3 flex items-center justify-between w-full p-5 font-medium rtl:text-right text-gray-500 border border-gray-200 rounded-xl focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 gap-3" data-accordion-target="#accordion-collapse-body-{{ $address->full_name }}-{{ $address->address }}-{{ $address->phone }}" aria-expanded="true" aria-controls="accordion-collapse-body-{{ $address->full_name }}-{{ $address->address }}-{{ $address->phone }}">
                        <span>
                            {{ $address->full_name }}
                        </span>
                    </button>
                </h2>
                <div id="accordion-collapse-body-{{ $address->full_name }}-{{ $address->address }}-{{ $address->phone }}" class="hidden" aria-labelledby="accordion-collapse-heading-{{ $address->full_name }}-{{ $address->address }}-{{ $address->phone }}">
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