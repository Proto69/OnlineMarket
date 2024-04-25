@php
use App\Models\Category;
@endphp
<x-app-layout class="items-center">
    <!-- Edit product modal -->
    <div id="updateProductModal-{{ $product->id }}" class="overflow-y-auto overflow-x-hidden flex z-50 justify-center items-center w-full md:inset-0">
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
                        <div class="sm:col-span-1">
                        <label class="block text-sm font-medium text-gray-900 dark:text-white">Снимки</label>

                            @if (!$product->images()->isEmpty())
                            <div>
                                <div class="relative h-56 overflow-hidden rounded-lg md:h-96">
                                    <ul id="imageList" class="space-y-2">
                                        @foreach($product->images() as $image)
                                        <li hidden data-image-url="{{ url('storage/' . $image->image) }}">Image 1</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>


                            @elseif ($product->getImageURL())
                            <div>
                                <div class="relative h-56 overflow-hidden rounded-lg md:h-96">
                                    <ul id="imageList" class="space-y-2">
                                        <li hidden data-image-url="{{ $product->getImageURL() }}">
                                    </ul>
                                </div>
                            </div>
                        </div>
                        @endif
                        <div>
                            <div class="relative h-56 overflow-hidden rounded-lg md:h-96">
                                <div id="imageDisplay" class="w-full h-full"></div>
                            </div>
                        </div>

                    </div>
                    <div class="sm:col-span-1">

                        <ul id="imageList" class="space-y-2"></ul>

                        <!-- File input for adding pictures -->
                        <input type="file" id="fileInput" class="hidden" multiple accept="image/*" onchange="handleFiles(this.files)">
                        <x-basic-button type="button" class="my-2" onclick="document.getElementById('fileInput').click()">Добави снимка</x-basic-button>
                        <ul id="imageList" class="space-y-2"></ul>
                    </div>
            </div>
            <br />
            <div class="sm:col-span-2">
                <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Описание</label>
                @error('description')
                <p class="text-red-500 text-sm mt-1 mb-1">{{ $message }}</p>
                @enderror
                <textarea required name="description" rows="5" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Напишете описание на продукта тук ...">{{ $product->description }}</textarea>
            </div>
            <div class="flex items-center mt-2 space-x-4">
                <x-success-button type="submit">
                    Запази промените
                </x-success-button>
            </div>
        </div>

        </form>
    </div>
    </div>
    </div>
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const imageList = document.getElementById('imageList');
        const imageElements = imageList.querySelectorAll('[data-image-url]');

        // Array to store uploaded image names
        const uploadedImages = [];

        imageElements.forEach((element, index) => {
            const imageUrl = element.getAttribute('data-image-url');
            const label = `Снимка ${index + 1}`;

            // Push image name to the uploadedImages array
            uploadedImages.push(label);

            // Create a label element for each image
            const labelElement = document.createElement('span');
            labelElement.textContent = label;
            labelElement.className = 'cursor-pointer text-blue-500 mr-2';
            labelElement.addEventListener('click', () => {
                displayImage(imageUrl, label);
            });

            // Create a trash icon for each image
            const trashIcon = document.createElement('span');
            trashIcon.innerHTML = '&times;';
            trashIcon.className = 'cursor-pointer text-red-500';
            trashIcon.addEventListener('click', () => {
                // Remove the parent of the trash icon, which is the list item (li)
                const li = trashIcon.parentNode;
                li.parentNode.removeChild(li);
                // Remove the image name from the uploadedImages array
                const indexToRemove = uploadedImages.indexOf(label);
                if (indexToRemove !== -1) {
                    uploadedImages.splice(indexToRemove, 1);
                }
            });

            // Create a list item for each image
            const li = document.createElement('li');
            li.className = 'flex items-center';

            // Append the label, image, and trash icon to the list item
            li.appendChild(labelElement);
            li.appendChild(trashIcon);

            // Append the list item to the image list
            imageList.appendChild(li);
        });

        // Store uploadedImages array in a hidden input field
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'uploaded_images';
        hiddenInput.value = JSON.stringify(uploadedImages);
        document.getElementById('updateForm').appendChild(hiddenInput);
    });

    // Function to display the clicked image
    function displayImage(imageUrl, label) {
        const imageDisplay = document.getElementById('imageDisplay');
        imageDisplay.innerHTML = ''; // Clear previous content

        // Create an image element
        const image = document.createElement('img');
        image.src = imageUrl;
        image.alt = label;
        image.className = 'w-full h-auto';

        // Append the image to the image display div
        imageDisplay.appendChild(image);
    }

    // Function to handle file uploads and display them
    function handleFiles(files) {
        const imageList = document.getElementById('imageList');

        for (let i = 0, numFiles = files.length; i < numFiles; i++) {
            const file = files[i];
            const label = file.name;

            // Create a list item for each file
            const li = document.createElement('li');

            const labelElement = document.createElement('span');
            labelElement.textContent = label;
            labelElement.className = 'cursor-pointer text-blue-500 mr-2';
            labelElement.addEventListener('click', () => {
                displayImage(URL.createObjectURL(file), label);
            });

            // Add class to the list item
            li.className = 'flex items-center';

            const trashIcon = document.createElement('span');
            trashIcon.innerHTML = '&times;';
            trashIcon.className = 'cursor-pointer text-red-500';
            trashIcon.addEventListener('click', () => {
                // Remove the parent of the trash icon, which is the list item (li)
                const li = trashIcon.parentNode;
                li.parentNode.removeChild(li);
            });

            // Append the label and trash icon to the list item
            li.appendChild(labelElement);
            li.appendChild(trashIcon);

            // Append the list item to the image list
            imageList.appendChild(li);
        }
    }

    // Function to remove an image from the list
    function removeImage(element) {
        element.parentNode.removeChild(element);
    }
</script>