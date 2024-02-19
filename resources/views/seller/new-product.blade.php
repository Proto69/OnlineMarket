<x-app-layout>
    @section('title', $title)
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="card-form bg-white dark:bg-gray-800 border border-gray-300 p-4 rounded-lg">
                    <form id="newProductForm" enctype="multipart/form-data" action="{{ route('new-product-add') }}" method="POST">
                        @csrf
                        <!-- Име -->
                        <div class="flex items-center">
                            <h2 class="text-xxl font-semibold text-gray-900 dark:text-white">
                                <label for="quantity-input" class="block mb-1 text-xl font-medium text-gray-900 dark:text-white">Име:</label>
                                @error('name')
                                <p class="text-red-500 text-sm mt-1 mb-1">{{ $message }}</p>
                                @enderror
                                <x-input type="text" name="name" class="name" value="{{ old('name') }}"></x-input>
                            </h2>
                        </div>

                        <!-- Описание -->
                        <label for="quantity-input" class="block mt-3 text-xl font-medium text-gray-900 dark:text-white">Описание:</label>
                        @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <textarea name="description" class="ps-2 pe-2 description border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 mb-3" cols="20" rows="5">{{ old('description') }}</textarea>

                        <!-- Количество -->
                        <label for="quantity-input" class="block mb-1 text-xl font-medium text-gray-900 dark:text-white">Количество:</label>
                        @error('quantity')
                        <p class="text-red-500 text-sm mt-1 mb-1">{{ $message }}</p>
                        @enderror
                        <x-input type="text" name="quantity" id="quantity" class="h-11 text-center text-sm py-2.5" value="{{ old('quantity', '1') }}" required></x-input>

                        <!-- Въвеждане на цена -->
                        <label class="text-xl block mb-1 mt-3 text-sm font-medium text-gray-900 dark:text-white">Цена: </label>
                        @error('price')
                        <p class="text-red-500 text-sm mt-1 mb-1">{{ $message }}</p>
                        @enderror
                        <x-input name="price" class="ps-2 mb-4 text-center" type="text" value="{{ old('price', '0.00') }}"></x-input> <br />

                        <!-- Качване на снимка -->
                        <label class="text-xl block mb-1 mt-3 text-sm font-medium text-gray-900 dark:text-white">Снимка </label>
                        <img class="mt-1 mb-2 productImage" id="file-preview">
                        @error('image')
                        <p class="text-red-500 text-sm mt-1 mb-1">{{ $message }}</p>
                        @enderror
                        <x-input name="image" type="file" id="file-input"></x-input> <br />

                        <!-- Добавяне на продукт -->
                        <x-success-button class="mt-3 me-2" type="submit">
                            Добави продукт
                        </x-success-button>
                    </form>

                    <form action="{{ route('dashboard') }}" method="GET">
                        <x-danger-button class="mt-3" type="submit">
                            Отказ
                        </x-danger-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    const input = document.getElementById('file-input');
    const previewPhoto = () => {
        const file = input.files;
        if (file) {
            const fileReader = new FileReader();
            const preview = document.getElementById('file-preview');
            fileReader.onload = function(event) {
                preview.setAttribute('src', event.target.result);
            }
            fileReader.readAsDataURL(file[0]);
        }
    }
    input.addEventListener("change", previewPhoto);
</script>