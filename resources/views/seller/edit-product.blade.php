@php
use App\Models\Category;
@endphp
<x-app-layout>
    <!-- Edit product modal -->
    <div id="updateProductModal-{{ $product->id }}" class="overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0">
        <div class="relative p-8 bg-white rounded-lg shadow-lg dark:bg-gray-800 overflow-y-auto sm:p-10 max-h-[80vh] max-w-screen-xl w-3/4">
            <!-- Modal content -->
            <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                <!-- Modal header -->
                <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Редактиране на продукт
                    </h3>
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
                        <div class="col-span-1">
                            @if (!$product->images()->isEmpty())
                            <div>
                                <div id="controls-carousel" class="relative w-full" data-carousel="static">

                                    <div class="relative h-56 overflow-hidden rounded-lg md:h-96">
                                        @foreach($product->images() as $image)
                                        <div class="hidden duration-700 ease-in-out" data-carousel-item>
                                            <img src="storage/{{ $image->image }}" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
                                        </div>
                                        @endforeach
                                    </div>

                                    <button type="button" class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
                                        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                                            <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4" />
                                            </svg>
                                            <span class="sr-only">Previous</span>
                                        </span>
                                    </button>
                                    <button type="button" class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
                                        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                                            <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                                            </svg>
                                            <span class="sr-only">Next</span>
                                        </span>
                                    </button>
                                </div>
                            </div>

                            @elseif ($product->getImageURL())
                            <div class="h-52 w-full bg-contain bg-no-repeat bg-center rounded-md" style="background-image: url('{{ $product->getImageURL() }}')"></div>
                            @else
                            <div class="h-52 w-full bg-contain bg-no-repeat bg-center rounded-md" style="background-image: url(https://upload.wikimedia.org/wikipedia/commons/6/65/No-Image-Placeholder.svg)"></div>
                            @endif
                        </div>
                        <div class="sm:col-span-1">
                            <input type="file" class="hidden" class="fileInput" multiple onchange="handleFiles(this.files)">
                            <x-basic-button type="button" class="my-2" onclick="document.getElementById('fileInput').click()">Добави снимка</x-basic-button>
                            <ul class="fileList"></ul>
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
                        <x-success-button type="submit">
                            Запази промените
                        </x-success-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
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

            // Add class to the remove button
            removeButton.className = "inline-flex items-center px-4 py-2 my-2 bg-white dark:bg-gray-800 border border-red-300 dark:border-red-500 rounded-md font-semibold text-xs text-red-700 dark:text-red-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-lime-800 disabled:opacity-25 transition ease-in-out duration-150 mx-1";

            removeButton.onclick = function() {
                // Remove the file from the array and the list
                filesArray = filesArray.filter(f => f.name !== file.name);
                fileList.removeChild(li);
            };

            // Create space between file name and remove button
            const space = document.createTextNode(' ');
            li.appendChild(space);

            // Append the remove button to the list item
            li.appendChild(removeButton);

            // Append the list item to the file list
            fileList.appendChild(li);
        }
    }
</script>