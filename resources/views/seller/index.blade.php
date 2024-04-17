@php
use App\Models\Category;
@endphp
<x-app-layout>
    @section('title', $title)
    <x-slot name="header">
        <div class="grid grid-cols-5 gap-4 text-gray-800 dark:text-gray-200">
            <h2 class="font-semibold text-xl leading-tight">
                {{ __('Табло') }}

            </h2>
            @if(!$errors->isEmpty())
            <x-danger-button class="col-end-7 col-span-1" type="submit" data-modal-target="createProductModal" data-modal-toggle="createProductModal">
                Неуспешно създаване
            </x-danger-button>
            @else
            <x-success-button class="col-end-7 col-span-1" type="submit" data-modal-target="createProductModal" data-modal-toggle="createProductModal">
                Създай продукт
            </x-success-button>
            @endif



            <!-- Create product modal -->
            <div id="createProductModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
                <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
                    <!-- Modal content -->
                    <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                        <form id="newProductForm" enctype="multipart/form-data" action="{{ route('new-product-add') }}" onsubmit="submitForm(event)" method="POST">
                            @csrf
                            <!-- Modal header -->
                            <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                    Добавяне на продукт
                                </h3>
                                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="createProductModal">
                                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="sr-only">Close modal</span>
                                </button>
                            </div>
                            <!-- Modal body -->
                            <div class="grid gap-4 mb-4 sm:grid-cols-2">
                                <div>
                                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Име</label>
                                    @error('name')
                                    <p class="text-red-500 text-sm mt-1 mb-1">{{ $message }}</p>
                                    @enderror
                                    <x-modal-input type="text" name="name" id="name" placeholder="Име на продукта" value="{{ old('name') }}" required />
                                </div>
                                <div>
                                    <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Цена</label>
                                    @error('price')
                                    <p class="text-red-500 text-sm mt-1 mb-1">{{ $message }}</p>
                                    @enderror
                                    <x-modal-input value="{{ old('price') }}" step="0.01" type="number" name="price" id="price" placeholder="2999" required />
                                </div>
                                <div>
                                    <label for="quantity" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Количество</label>
                                    @error('quantity')
                                    <p class="text-red-500 text-sm mt-1 mb-1">{{ $message }}</p>
                                    @enderror
                                    <x-modal-input value="{{ old('quantity') }}" type="number" name="quantity" id="quantity" placeholder="1000" required />
                                </div>
                                <div>
                                    <label for="category" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Категория</label>
                                    @error('category')
                                    <p class="text-red-500 text-sm mt-1 mb-1">{{ $message }}</p>
                                    @enderror
                                    <select id="category" name="category" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block sm:w-full w-80 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                        @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="sm:col-span-2">
                                    <label class="block text-sm font-medium text-gray-900 dark:text-white">Характеристики</label>
                                    <x-basic-button id="addCharacteristic" class="my-2">Добави</x-basic-button>

                                    <div id="newCharacteristics" class="sm:col-span-2">
                                    </div>
                                </div>

                                <script>
                                    // JavaScript to handle adding and removing input fields
                                    document.addEventListener('DOMContentLoaded', function() {
                                        const addCharacteristicBtn = document.getElementById('addCharacteristic');
                                        const newCharacteristicsContainer = document.getElementById('newCharacteristics');

                                        // Function to add new input field
                                        function addInputField() {
                                            const inputField = document.createElement('div');
                                            inputField.classList.add('sm:inline-flex', 'items-center', 'my-1');
                                            inputField.innerHTML = `
                                            <input required class=" characteristic-name-create inline-block mx-1 my-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-64 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" type="text" name="characteristics[][name-c]" placeholder="Име" />
                                            <input required class=" characteristic-description-create inline-block mx-1 my-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-64 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" type="text" name="characteristics[][description-c]" placeholder="Описание" />
                                        <x-danger-button type="button" class="mx-1 my-1 removeCharacteristic">
                                            <svg class="w-6 h-6 text-red-800 dark:text-red-300 removeCharacteristic" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" class="removeCharacteristic" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                            </svg>
                                        </x-danger-button>
                                        <br />
                                        `;
                                            newCharacteristicsContainer.appendChild(inputField);
                                        }

                                        // Event listener for adding characteristic
                                        addCharacteristicBtn.addEventListener('click', function() {
                                            addInputField();
                                        });

                                        // Event listener for removing characteristic
                                        newCharacteristicsContainer.addEventListener('click', function(event) {
                                            if (event.target.classList.contains('removeCharacteristic')) {
                                                event.target.closest('div').remove();
                                            }
                                        });
                                    });
                                </script>

                                <div>
                                    <input type="file" id="fileInput" multiple onchange="handleFiles(this.files)">
                                    <button type="button" onclick="document.getElementById('fileInput').click()">Add picture</button>
                                    <ul id="fileList"></ul>
                                </div>

                                <br />
                                <div class="sm:col-span-2">
                                    <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Описание</label>
                                    @error('description')
                                    <p class="text-red-500 text-sm mt-1 mb-1">{{ $message }}</p>
                                    @enderror
                                    <textarea required id="description" name="description" rows="4" class="block p-2.5 sm:w-full w-80 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Напишете описанието на продукта тук...">{{ old('description') }}</textarea>
                                </div>
                            </div>
                            <x-success-button type="submit">
                                <svg class="mr-1 -ml-1 w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                                </svg>
                                Създай продукт
                            </x-success-button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    @if (!$errors->isEmpty())
    <div id="alert-border-2" class="mt-2 max-w-7xl mx-auto sm:px-6 lg:px-8 flex items-center p-4 mb-4 text-red-800 border-t-4 border-red-300 bg-red-50 dark:text-red-400 dark:bg-gray-800 dark:border-red-800" role="alert">
        <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
        </svg>
        <div class="ms-3 font-medium">
            Неуспешно действие! Подадени са невалидни данни!
        </div>
        <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-gray-700" data-dismiss-target="#alert-border-2" aria-label="Close">
            <span class="sr-only">Dismiss</span>
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
            </svg>
        </button>
    </div>
    @endif

    @if ($seller->is_test)
    <div id="alert-border-4" class="mt-2 max-w-7xl mx-auto sm:px-6 lg:px-8 flex items-center p-4 mb-3 text-yellow-800 border-t-4 border-yellow-300 bg-yellow-50 dark:text-yellow-300 dark:bg-gray-800 dark:border-yellow-800" role="alert">
        <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
        </svg>
        <div class="ms-3 font-medium">
            Вие сте в тестов режим! <a href="/connect-stripe" class="font-semibold underline hover:no-underline">Свържете Stripe акаунт</a> ако искате да излезете.
        </div>
    </div>
    @endif

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-transparent dark:bg-transparent overflow-hidden shadow-xl sm:rounded-lg">
                <div class="bg-transparent bg-opacity-25 grid grid-cols-1 md:grid-cols-4 gap-4 p-3 ">

                    @foreach ($products as $product)


                    <div data-modal-target="readProductModal-{{ $product->id }}" data-modal-toggle="readProductModal-{{ $product->id }}" class="hover:cursor-pointer card-form relative min-w-80 bg-white dark:bg-gray-800 border border-gray-300 p-4 rounded-lg flex flex-col h-full items-center">

                        <input type="hidden" class="productId" value="{{ $product->id }}">

                        <div class="mb-2 flex flex-col items-center">
                            <!-- Показване на снимка  -->
                            <div class="h-52 w-full bg-contain bg-no-repeat bg-center rounded-md" style="background-image: url('{{ $product->getImageURL() }}')"></div>

                            <!-- Име на продукта -->
                            <div>
                                <label class="block mb-2 text-xl font-medium text-gray-900 dark:text-white">{{ $product->name }}</label>
                            </div>
                        </div>

                        <div class="mt-auto mb-2">
                            <!-- Количество -->
                            <label for="quantity-input" class="block mb-2 text-xl font-medium text-gray-900 dark:text-white">Количество: {{ $product->quantity }}</label>
                            <!-- Цена -->
                            <label class="text-xl block mt-3 font-medium text-gray-900 dark:text-white">Цена: {{ $product->price }}</label> <br />

                            <!-- Изчерпан продукт -->
                            @if ($product->quantity === 0)
                            <cr class="sold-product mt-2 text-red-800 dark:text-red-500 font-bold">Този продукт е изчерпан!</cr> <br />
                            @endif

                            <!-- Активен/Неактивен switch -->
                            <div class="flex items-center">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" value="" class="sr-only peer activity-toggle" {{ $product->active ? 'checked' : '' }} {{ $product->quantity == 0 ? 'disabled' : ''}}>
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                </label>
                                <span class="ml-3 activity-state state text-xxl font-medium text-gray-900 dark:text-gray-300">{{ $product->active ? 'Активен' : 'Неактивен'}}</span>
                            </div>

                            <x-success-button id="updateProductButton-{{ $product->id }}" onclick="event.stopPropagation()" data-modal-target="updateProductModal-{{ $product->id }}" data-modal-toggle="updateProductModal-{{ $product->id }}" class="mt-3 self-center">
                                Промени продукт
                            </x-success-button>
                        </div>
                    </div>


                    <!-- Edit product modal -->
                    <div id="updateProductModal-{{ $product->id }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
                        <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
                            <!-- Modal content -->
                            <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                                <!-- Modal header -->
                                <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                        Редактиране на продукт
                                    </h3>
                                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="updateProductModal-{{ $product->id }}">
                                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="sr-only">Close modal</span>
                                    </button>
                                </div>
                                <!-- Modal body -->
                                <form id="updateForm-{{ $product->id }}" enctype="multipart/form-data" action="{{ route('edit-product-save', $product->id) }}" method="POST">
                                    @csrf
                                    <div class="grid gap-4 mb-4 sm:grid-cols-2">
                                        <div>
                                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Име</label>
                                            @error('name')
                                            <p class="text-red-500 text-sm mt-1 mb-1">{{ $message }}</p>
                                            @enderror
                                            <input required type="text" name="name" id="name" value="{{ $product->name }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Име на продукта">
                                        </div>
                                        <div>
                                            <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Цена</label>
                                            @error('price')
                                            <p class="text-red-500 text-sm mt-1 mb-1">{{ $message }}</p>
                                            @enderror
                                            <input required type="number" value="{{ $product->price }}" name="price" id="price" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="2999">
                                        </div>
                                        <div>
                                            <label for="quantity" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Количество</label>
                                            @error('quantity')
                                            <p class="text-red-500 text-sm mt-1 mb-1">{{ $message }}</p>
                                            @enderror
                                            <input required type="text" name="quantity" id="quantity" value="{{ $product->quantity }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="1000">
                                        </div>
                                        <div>
                                            <label for="category" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Категория</label>
                                            <select id="category" name="category" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                                @if ($product->category)
                                                <option value="{{ $product->category }}">{{ Category::find($product->category)->name }}</option>
                                                @endif
                                                @foreach ($categories as $category)
                                                @if (!($category->name == $product->category))
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endif
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="sm:col-span-2">
                                            <label class="block text-sm font-medium text-gray-900 dark:text-white">Характеристики</label>
                                            <x-basic-button id="addCharacteristic-{{ $product->id }}" class="my-2">Добави</x-basic-button>

                                            <div id="newCharacteristics-{{ $product->id }}" class="sm:col-span-2">
                                                @if (!$product->characteristics()->isEmpty())
                                                @foreach ($product->characteristics() as $characteristic)
                                                <div class="sm:inline-flex items-center my-1">
                                                    <input required value="{{ $characteristic->name }}" class="inline-block mx-1 my-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-64 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" type="text" name="characteristics[][name-c]" placeholder="Име" />
                                                    <input required value="{{ $characteristic->description }}" class="inline-block mx-1 my-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-64 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" type="text" name="characteristics[][description-c]" placeholder="Описание" />
                                                    <x-danger-button type="button" class="mx-1 my-1 removeCharacteristic-{{ $product->id }}">
                                                        <svg class="w-6 h-6 text-red-800 dark:text-red-300 removeCharacteristic-{{ $product->id }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                            <path stroke="currentColor" class="removeCharacteristic-{{ $product->id }}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                                        </svg>
                                                    </x-danger-button>
                                                </div>
                                                @endforeach
                                                @endif
                                            </div>
                                        </div>

                                        <script>
                                            // JavaScript to handle adding and removing input fields
                                            document.addEventListener('DOMContentLoaded', function() {
                                                const addCharacteristicBtn = document.getElementById('addCharacteristic-' + `{{$product->id}}`);
                                                const newCharacteristicsContainer = document.getElementById('newCharacteristics-' + `{{$product->id}}`);

                                                // Function to add new input field
                                                function addInputField() {
                                                    const inputField = document.createElement('div');
                                                    inputField.classList.add('sm:inline-flex', 'items-center', 'my-1');
                                                    inputField.innerHTML = `
                                            <input required class="inline-block mx-1 my-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-64 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" type="text" name="characteristics[][name-c]" placeholder="Име" />
                                            <input required class="inline-block mx-1 my-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-64 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" type="text" name="characteristics[][description-c]" placeholder="Описание" />
                                        <x-danger-button type="button" class="mx-1 my-1 removeCharacteristic-` + '{{$product->id}}' + `">
                                            <svg class="w-6 h-6 text-red-800 dark:text-red-300 removeCharacteristic-` + '{{$product->id}}' + `" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" class="removeCharacteristic-` + '{{$product->id}}' + `" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                            </svg>
                                        </x-danger-button>
                                        <br />
                                        `;
                                                    newCharacteristicsContainer.appendChild(inputField);
                                                }

                                                // Event listener for adding characteristic
                                                addCharacteristicBtn.addEventListener('click', function() {
                                                    addInputField();
                                                });

                                                // Event listener for removing characteristic
                                                newCharacteristicsContainer.addEventListener('click', function(event) {
                                                    if (event.target.classList.contains('removeCharacteristic-' + `{{$product->id}}`)) {
                                                        event.target.closest('div').remove();
                                                    }
                                                });
                                            });
                                        </script>
                                        <div>
                                            <img class="mt-1 mb-2 filePreview max-h-[150px] rounded-md" src="{{ $product->getImageURL() }}">
                                            <label for="image" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Снимка</label>
                                            @error('image')
                                            <p class="text-red-500 text-sm mt-1 mb-1">{{ $message }}</p>
                                            @enderror
                                            <x-input type="file" name="image" class="fileInput" accept=".jpg, .jpeg, .png"></x-input>
                                        </div>
                                        <br />
                                        <div class="sm:col-span-2">
                                            <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Описание</label>
                                            @error('description')
                                            <p class="text-red-500 text-sm mt-1 mb-1">{{ $message }}</p>
                                            @enderror
                                            <textarea required name="description" rows="5" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Напишете описание на продукта тук ...">{{ $product->description }}</textarea>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-4">
                                        <x-success-button type="button" onclick="submitForm('{{ $product->id }}')">
                                            Запази промените
                                        </x-success-button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Read modal -->
                    <div id="readProductModal-{{ $product->id }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
                        <div class="relative p-4 w-full max-w-xl h-full md:h-auto">
                            <!-- Modal content -->
                            <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                                <!-- Modal header -->
                                <div class="flex justify-between mb-4 rounded-t sm:mb-5">
                                    <div class="text-lg text-gray-900 md:text-xl dark:text-white">
                                        <h3 class="font-semibold ">
                                            {{ $product->name }}
                                        </h3>
                                        <p class="font-bold">
                                            {{ $product->price }}лв
                                        </p>
                                    </div>
                                    <div>
                                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 inline-flex dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="readProductModal-{{ $product->id }}">
                                            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span class="sr-only">Close modal</span>
                                        </button>
                                    </div>
                                </div>
                                <dl>
                                    <dt class="mb-2 font-semibold leading-none text-gray-900 dark:text-white">Описание</dt>
                                    <dd class="mb-4 font-light text-gray-500 sm:mb-5 dark:text-gray-400">{{ $product->description }}</dd>
                                    <dt class="mb-2 font-semibold leading-none text-gray-900 dark:text-white">Категория</dt>
                                    @if($product->category)
                                    <dd class="mb-4 font-light text-gray-500 sm:mb-5 dark:text-gray-400">{{ Category::find($product->category)->name }}</dd>
                                    @else
                                    <dd class="mb-4 font-light text-gray-500 sm:mb-5 dark:text-gray-400">Category Not Found</dd>
                                    @endif

                                    @if (!$product->characteristics()->isEmpty())
                                    <table class="min-w-full leading-normal sm:col-span-2 my-2">
                                        <tbody>
                                            @foreach ($product->characteristics() as $characteristic)
                                            <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                                <td class="px-6 py-5 border-b border-gray-300 text-sm dark:border-gray-700 dark:text-gray-300">
                                                    {{ $characteristic->name }}
                                                </td>
                                                <td class="px-6 py-5 border-b border-gray-300 text-sm dark:border-gray-700 dark:text-gray-300">
                                                    {{ $characteristic->description }}
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @endif

                                    @if ($product->getImageURL())
                                    <div class="h-52 w-full bg-contain bg-no-repeat bg-center rounded-md" style="background-image: url('{{ $product->getImageURL() }}')"></div>
                                    @else
                                    <div class="h-52 w-full bg-contain bg-no-repeat bg-center rounded-md" style="background-image: url(https://upload.wikimedia.org/wikipedia/commons/6/65/No-Image-Placeholder.svg)"></div>
                                    @endif
                                </dl>
                            </div>
                        </div>
                    </div>


                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div id="toast-container" class="toast-container" />

</x-app-layout>
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
    function submitForm(productId) {
        // Get the form element by ID
        var form = document.getElementById('updateForm-' + productId);

        // Submit the form
        form.submit();
    }

    function createToast(state) {
        // Create a new toast element
        var toast = document.createElement('div');
        var toastId = 'toast-' + Date.now(); // Unique ID for each toast
        toast.setAttribute('id', toastId);
        toast.classList.add('fixed', 'right-5', 'flex', 'items-center', 'w-full', 'max-w-xs', 'p-4', 'mb-4', 'text-gray-500', 'bg-white', 'rounded-lg', 'shadow', 'dark:text-gray-400', 'dark:bg-gray-800', 'toast');
        toast.setAttribute('role', 'alert');
        toast.style.transition = 'opacity 0.3s ease-in-out';

        toast.style.position = 'fixed';
        toast.style.bottom = '1rem'; // Adjust this value to set the distance between toasts
        toast.style.right = '1rem';
        toast.style.transform = 'translateX(+0%) translateY(-' + (document.querySelectorAll('.toast').length * 35) + 'px)'; // Adjust this value to control the vertical stacking
        toast.style.opacity = '0';
        // Construct toast content
        toast.innerHTML = `
        <!-- Your toast content -->
        <div class="toast inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200">
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
            </svg>
            <span class="sr-only">Check icon</span>
        </div>
        <div class="ms-3 text-sm font-normal">Успешно <strong>` + state + `</strong>  продукт!</div>
        <button type="button" class="close-toast-button" aria-label="Close">
            <!-- Your close button content -->
        </button>
    `;

        // Append the toast to the container
        var toastContainer = document.getElementById('toast-container');
        toastContainer.appendChild(toast);

        // Animate the toast appearance
        setTimeout(function() {
            toast.style.opacity = '1';
        }, 100); // Adding a slight delay for smoother animation

        // Remove the toast after 3 seconds
        setTimeout(function() {
            toast.style.opacity = '0';
            setTimeout(function() {
                toast.remove();
            }, 300); // Additional delay to ensure the fade-out transition completes
        }, 3000);
    }

    $('.activity-toggle').on('change', function() {
        let cardForm = $(this).closest('.card-form');
        let activityState = cardForm.find('.activity-state');
        let id = cardForm.find('.productId').val();

        //  maybe could be used for smth
        let message = cardForm.find('.unactive-product');

        if (this.checked) {
            activityState.text('Активен');
            updateStatus(id, 1);
            createToast('активирахте');
        } else {
            activityState.text('Неактивен');
            updateStatus(id, 0);
            createToast('деактивирахте');
        }
    });


    function updateStatus(productId, status) {
        $.ajax({
            url: '/change-status/' + productId + '/' + status,
            method: 'POST',
            data: {
                "_token": "{{ csrf_token() }}"
            },
            success: function(response) {
                console.log('success');
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                console.error('Status:', status);
                console.error('Response Text:', xhr.responseText);
            }
        });
    }

    let filesArray = [];

    // Function to handle file uploads and display them
    function handleFiles(files) {
        const fileList = document.getElementById('fileList');
        for (let i = 0, numFiles = files.length; i < numFiles; i++) {
            const file = files[i];
            filesArray.push(file); // Add new file to the array

            // Create a list item for each file
            const li = document.createElement('li');
            li.textContent = file.name;

            // Create a remove button for each file
            const removeButton = document.createElement('button');
            removeButton.textContent = 'X';
            removeButton.onclick = function() {
                // Remove the file from the array and the list
                filesArray = filesArray.filter(f => f.name !== file.name);
                fileList.removeChild(li);
            };

            li.appendChild(removeButton);
            fileList.appendChild(li);
        }
    }

    // Function to handle form submission
    function submitForm(event) {
        event.preventDefault(); // Prevent the default form submission

        let formData = new FormData(document.getElementById('newProductForm'));
        filesArray.forEach((file, index) => {
            formData.append('images[]', file); // Use 'pictures[]' to send an array of files
        });

        // Use fetch to submit the form data to the server
        fetch('{{ route('new-product-add') }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest', // Required for Laravel when submitting the form with fetch
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Add CSRF token for Laravel
                    }
                })
            .then(response => response.json())
            .then(data => {
                console.log(data); // Handle the response data

                location.reload();
            })
            .catch(error => {
                console.error('Error:', error); // Handle any errors
            });
    }
</script>