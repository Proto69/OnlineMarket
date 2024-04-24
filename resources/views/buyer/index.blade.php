@php
use App\Models\Category;
use App\Models\User;
@endphp
<x-app-layout>
    @section('title', $title)
    <x-slot name="header">
        <div class="grid grid-cols-5 gap-4 text-gray-800 dark:text-gray-200">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Пазаруване') }}
            </h2>

            <x-basic-button class="col-end-7 col-span-1" type="button" data-drawer-target="drawer-example" data-drawer-show="drawer-example" aria-controls="drawer-example">
                Филтри
                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M18.8 4H5.2a1 1 0 0 0-.7 1.7l5.3 6 .2.7v4.8c0 .2 0 .4.2.4l3 2.3c.3.2.8 0 .8-.4v-7.1c0-.3 0-.5.2-.7l5.3-6a1 1 0 0 0-.7-1.7Z" />
                </svg>
            </x-basic-button>
        </div>

    </x-slot>



    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-transparent dark:bg-transparent overflow-hidden shadow-xl sm:rounded-lg">
                <div class="bg-transparent bg-opacity-25 grid grid-cols-1 md:grid-cols-4 gap-4 p-3 ">

                    <!-- drawer component -->
                    <form action="{{ route('shopping-filters') }}" method="GET" id="drawer-example" class="fixed top-0 left-0 z-40 w-full h-screen max-w-xs p-4 overflow-y-auto transition-transform -translate-x-full bg-white dark:bg-gray-800">
                        <h5 id="drawer-label" class="inline-flex items-center mb-4 text-base font-semibold text-gray-500 uppercase dark:text-gray-400">
                            Прилагане на филтри
                        </h5>
                        <button type="button" data-drawer-dismiss="drawer-example" aria-controls="drawer-example" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 absolute top-2.5 right-2.5 inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="sr-only">Затвори</span>
                        </button>

                        <div class="flex flex-col justify-between flex-1">
                            <div class="space-y-6">

                                <!-- Prices -->
                                <div class="space-y-2">
                                    <h6 class="text-base font-medium text-black dark:text-white">
                                        Ценови диапазон
                                    </h6>

                                    <div x-data="range()" x-init="mintrigger(); maxtrigger()" class="relative max-w-xl w-full">
                                        <div class="mb-2">
                                            <input type="range" step="100" x-bind:min="min" x-bind:max="max" x-on:input="mintrigger" x-model="minprice" class="absolute pointer-events-none appearance-none z-20 h-2 w-full opacity-0 cursor-pointer">

                                            <input type="range" step="100" x-bind:min="min" x-bind:max="max" x-on:input="maxtrigger" x-model="maxprice" class="absolute pointer-events-none appearance-none z-20 h-2 w-full opacity-0 cursor-pointer">

                                            <div class="relative z-10 h-2">

                                                <div class="absolute z-10 left-0 right-0 bottom-0 top-0 rounded-md bg-gray-200"></div>

                                                <div class="absolute z-20 top-0 bottom-0 rounded-md dark:bg-teal-400" x-bind:style="'right:'+maxthumb+'%; left:'+minthumb+'%'"></div>

                                                <div class="absolute z-30 w-6 h-6 top-0 left-0 dark:bg-teal-400 rounded-full -mt-2 -ml-1" x-bind:style="'left: '+minthumb+'%'"></div>

                                                <div class="absolute z-30 w-6 h-6 top-0 right-0 dark:bg-teal-400 rounded-full -mt-2 -mr-3" x-bind:style="'right: '+maxthumb+'%'"></div>

                                            </div>

                                            <script>
                                                function range() {
                                                    return {
                                                        minprice: '{{ $priceFrom ?? 300 }}',
                                                        maxprice: '{{ $priceTo ?? 6000 }}',
                                                        min: 0,
                                                        max: 10000,
                                                        minthumb: 0,
                                                        maxthumb: 0,

                                                        mintrigger() {
                                                            this.minprice = Math.min(this.minprice, this.maxprice - 100);
                                                            this.minthumb = ((this.minprice - this.min) / (this.max - this.min)) * 100;
                                                        },

                                                        maxtrigger() {
                                                            this.maxprice = Math.max(this.maxprice, this.minprice + 100);
                                                            this.maxthumb = 100 - (((this.maxprice - this.min) / (this.max - this.min)) * 100);
                                                        },
                                                    }
                                                }
                                            </script>
                                        </div>
                                        <div class="flex items-center justify-between col-span-2 space-x-3">
                                            <div class="w-full">
                                                <label for="min-experience-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                                    От
                                                </label>
                                                <input type="number" maxlength="5" x-on:input="mintrigger" x-model="minprice" name="price-from" id="price-from" value="{{ $priceFrom ?? 300 }}" min="0" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="" required>
                                            </div>
                                            <div class="w-full">
                                                <label for="price-to" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                                    До
                                                </label>
                                                <input type="number" maxlength="5" x-on:input="maxtrigger" x-model="maxprice" name="price-to" id="price-to" value="{{ $priceTo ?? 3500 }}" min="0" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="bottom-0 left-0 flex justify-center w-full pb-4 mt-6 space-x-4 md:px-4 md:absolute">
                                <button type="submit" class="w-full px-5 py-2 text-sm font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 dark:bg-primary-700 dark:hover:bg-primary-800 dark:focus:ring-primary-800">
                                    Приложи
                                </button>
                                <a href="/shopping" class="w-full px-5 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg focus:outline-none hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                    Махни всички
                                </a>

                            </div>
                        </div>
                    </form>

                    @foreach($products as $product)
                    @if ($product->active)

                    <div id="readProductButton" data-modal-target="readProductModal-{{ $product->id }}" data-modal-toggle="readProductModal-{{ $product->id }}" class="hover:cursor-pointer card-form relative min-w-80 bg-white dark:bg-gray-800 border border-gray-300 p-4 rounded-lg flex flex-col h-full items-center">

                        <div class="mb-2 flex flex-col items-center">
                            <!-- Product Image -->
                            @if ($product->getImageURL())
                            <div class="h-52 w-full bg-contain bg-no-repeat bg-center rounded-md" style="background-image: url('{{ $product->getImageURL() }}')"></div>
                            @else
                            <img class="rounded-lg mb-2 productImage max-h-60" src="https://upload.wikimedia.org/wikipedia/commons/6/65/No-Image-Placeholder.svg">
                            @endif
                            <!-- Product Name -->
                            <h5 class="text-xl font-semibold tracking-tight text-gray-900 dark:text-white">{{ $product->name }}</h5>
                            <h6 class="text-xl font-semibold tracking-tight text-gray-900 dark:text-white">Рейтинг: {{ $product->rating }}</h6>
                        </div>


                        <!-- Review modal -->
                        <div id="commentModal-{{ $product->id }}" onclick="event.stopPropagation()" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
                            <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
                                <!-- Modal content -->
                                <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                                    <!-- Modal header -->
                                    <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                            Добави ревю
                                        </h3>
                                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="commentModal-{{ $product->id }}" onclick="event.stopPropagation()">
                                            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span class="sr-only">Close modal</span>
                                        </button>
                                    </div>
                                    <!-- Modal body -->
                                    <form action="{{ route('new-comment', $product->id) }}" method="POST">
                                        @csrf
                                        <div class="grid gap-4 mb-4 sm:grid-cols-2">
                                            <div>
                                                <label for="rating" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Оценка</label>
                                                <div class="flex items-center">
                                                    @error('rating')
                                                    <p class="text-red-500 text-sm mt-1 mb-1">{{ $message }}</p>
                                                    @enderror
                                                    <input type="number" hidden class="rating-input" name="rating" id="rating-{{ $product->id }}" value="0">
                                                    <span class="star" data-value="1">
                                                        <svg class="star" data-value="1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M10 0l2.93 6.775L20 7.665l-5 5.15 1.18 7.19L10 15.25l-6.18 4.75 1.18-7.19-5-5.15 7.07-1.89L10 0zm0 2.5L7.67 7.665 2.5 8.55l4.29 4.4L5.65 17.5 10 14.25l4.35 3.25-1.14-6.55L17.5 8.55 12.33 7.67 10 2.5z" clip-rule="evenodd" />
                                                        </svg>
                                                    </span>
                                                    <span class="star" data-value="2">
                                                        <svg class="star" data-value="2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M10 0l2.93 6.775L20 7.665l-5 5.15 1.18 7.19L10 15.25l-6.18 4.75 1.18-7.19-5-5.15 7.07-1.89L10 0zm0 2.5L7.67 7.665 2.5 8.55l4.29 4.4L5.65 17.5 10 14.25l4.35 3.25-1.14-6.55L17.5 8.55 12.33 7.67 10 2.5z" clip-rule="evenodd" />
                                                        </svg>
                                                    </span>
                                                    <span class="star" data-value="3">
                                                        <svg class="star" data-value="3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M10 0l2.93 6.775L20 7.665l-5 5.15 1.18 7.19L10 15.25l-6.18 4.75 1.18-7.19-5-5.15 7.07-1.89L10 0zm0 2.5L7.67 7.665 2.5 8.55l4.29 4.4L5.65 17.5 10 14.25l4.35 3.25-1.14-6.55L17.5 8.55 12.33 7.67 10 2.5z" clip-rule="evenodd" />
                                                        </svg>
                                                    </span>
                                                    <span class="star" data-value="4">
                                                        <svg class="star" data-value="4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M10 0l2.93 6.775L20 7.665l-5 5.15 1.18 7.19L10 15.25l-6.18 4.75 1.18-7.19-5-5.15 7.07-1.89L10 0zm0 2.5L7.67 7.665 2.5 8.55l4.29 4.4L5.65 17.5 10 14.25l4.35 3.25-1.14-6.55L17.5 8.55 12.33 7.67 10 2.5z" clip-rule="evenodd" />
                                                        </svg>
                                                    </span>
                                                    <span class="star" data-value="5">
                                                        <svg class="star" data-value="5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M10 0l2.93 6.775L20 7.665l-5 5.15 1.18 7.19L10 15.25l-6.18 4.75 1.18-7.19-5-5.15 7.07-1.89L10 0zm0 2.5L7.67 7.665 2.5 8.55l4.29 4.4L5.65 17.5 10 14.25l4.35 3.25-1.14-6.55L17.5 8.55 12.33 7.67 10 2.5z" clip-rule="evenodd" />
                                                        </svg>
                                                    </span>
                                                </div>
                                            </div>
                                            <br />
                                            <div class="sm:col-span-2">
                                                @error('header')
                                                <p class="text-red-500 text-sm mt-1 mb-1">{{ $message }}</p>
                                                @enderror
                                                <label for="header" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Заглавие</label>
                                                <x-input type="text" name="header" class="w-full" id="header" placeholder="Отлично"></x-input>
                                            </div>

                                            <div class="sm:col-span-2">
                                                @error('comment')
                                                <p class="text-red-500 text-sm mt-1 mb-1">{{ $message }}</p>
                                                @enderror
                                                <label for="comment" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Коментар</label>
                                                <textarea id="comment" name="comment" rows="4" class=" border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm w-full block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Напиши коментар"></textarea>
                                            </div>
                                            <x-success-button type="submit" class="w-40 flex items-center justify-center">
                                                Добави ревю
                                            </x-success-button>

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="mt-auto mb-2 flex items-center justify-between">
                            <!-- Product Price -->
                            <span class="text-3xl font-bold mt-3 pr-2 text-gray-900 dark:text-white">{{ $product->price }}лв</span> <br />

                            <!-- Add to Cart Button -->
                            <x-basic-button class="mt-3 add-to-cart" data-product-id="{{ $product->id }}" onclick="event.stopPropagation()">
                                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 4h1.5L9 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-8.5-3h9.3L19 7h-1M8 7h-.7M13 5v4m-2-2h4" />
                                </svg>
                            </x-basic-button>
                            <!-- Review button -->
                            <x-basic-button type="button" class="mt-3 ms-2" id="commentModalButton-{{ $product->id }}" onclick="event.stopPropagation()" data-modal-target="commentModal-{{ $product->id }}" data-modal-toggle="commentModal-{{ $product->id }}">
                                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAACXBIWXMAAAsTAAALEwEAmpwYAAABFElEQVR4nGNgGAWkAIVpn9sUpn76qTjt839ysMLUTz8Vpn5uxW0BBYYrwiyZ9ukHTgsIadad8wWMCakj24KmIz/+Nx75QRsLdGZ/+X/tzZ//N97+IegLoi0wX/jlf/7u7/+7Tvz4v+3ur/+PP/0FYxAbJAaSA6kh2wLVGZ//L72KMBgdr7r+67/6TAqDSGXG5/+LL2NaAhIDyVElDlK3fcOwIGXbN+pFctuxH2BD9zz4DcYgNkiMahZ0Hv/xP3Hrt/9K0z6DMYgNEqN6PlAkEtPUAgVKigpFYgq7aZ9biLJAYeqnrTK9/zkZqAngFkz9tNx45n9WqhoOt2Dq5xkM9f+ZqG44CChO+9zB8P8/I5gzCugFAI6m4qjeOG0UAAAAAElFTkSuQmCC">
                            </x-basic-button>

                            <!-- Hidden Input for Product ID -->
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                        </div>

                    </div>


                    <!-- Read modal -->
                    <div id="readProductModal-{{ $product->id }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0">
                        <div class="relative p-8 bg-white rounded-lg shadow-lg dark:bg-gray-800 overflow-y-auto sm:p-10 max-h-[80vh] max-w-screen-xl w-3/4">
                            <!-- Modal content -->
                            <form action="{{ route('add-to-cart-quantity', $product->id) }}" method="POST">
                                @csrf
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 overflow-y-auto">
                                    <!-- Product image/carousel -->
                                    <div class="col-span-1">
                                        @if (!$product->images()->isEmpty())
                                        <div>
                                            <div id="controls-carousel" class="relative w-full" data-carousel="static">
                                                <!-- Carousel wrapper -->
                                                <div class="relative h-56 overflow-hidden rounded-lg md:h-96">
                                                    <!-- Item 1 -->
                                                    @foreach($product->images() as $image)
                                                    <div class="hidden duration-700 ease-in-out" data-carousel-item>
                                                        <img src="storage/{{ $image->image }}" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
                                                    </div>
                                                    @endforeach
                                                </div>
                                                <!-- Slider controls -->
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
                                    <!-- Product information -->
                                    <div class="col-span-2">
                                        <!-- Header: Product name and price -->
                                        <div>
                                            <h3 class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $product->name }}</h3>
                                            @php
                                            $integerPart = floor($product->rating);
                                            $fractionalPart = $product->rating - $integerPart;
                                            @endphp

                                            <!-- FIXME: stars (sent in discord) -->
                                            <div class="flex items-center mb-1 space-x-1 rtl:space-x-reverse">
                                                <!-- Full stars -->
                                                @for ($i = 1; $i <= $integerPart; $i++) <svg class="w-4 h-4 text-yellow-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                                    <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                                                    </svg>
                                                    @endfor

                                                    <!-- Half star -->
                                                    @if ($fractionalPart > 0)
                                                    <svg class="w-4 h-4 text-yellow-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                                        <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                                                    </svg>
                                                    @endif

                                                    <!-- Gray stars for remaining empty stars -->
                                                    @for ($i = ceil($product->rating); $i < 5; $i++) <svg class="w-4 h-4 text-gray-300 dark:text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                                        <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                                                        </svg>
                                                        @endfor

                                                        <span class="ms-2 dark:text-white text-gray">
                                                            ({{ $product->rating }})
                                                        </span>
                                            </div>
                                            <p class="text-lg text-gray-700 dark:text-gray-300">{{ $product->price }}лв</p>
                                        </div>
                                        <!-- Description -->
                                        <div class="mt-4">
                                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Детайли</h4>
                                            <p class="text-base text-gray-700 dark:text-gray-300">{{ $product->description }}</p>
                                        </div>
                                        <!-- Characteristics table -->
                                        @if (!$product->characteristics()->isEmpty())
                                        <div class="mt-4">
                                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Характеристики</h4>
                                            <table class="w-full mt-2 border-collapse text-base">
                                                <tbody>
                                                    @foreach ($product->characteristics() as $characteristic)
                                                    <tr class="border-b border-gray-200 dark:border-gray-700">
                                                        <td class="py-2 px-4 text-gray-700 dark:text-gray-300">{{ $characteristic->name }}</td>
                                                        <td class="py-2 px-4 text-gray-700 dark:text-gray-300">{{ $characteristic->description }}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        @endif
                                        <!-- Buy button and quantity -->
                                        <div class="mt-8 flex items-center">
                                            <div class="relative flex items-center max-w-[9rem]">
                                                <button type="button" id="decrement-button-{{ $product->id }}" data-product-id="{{ $product->id }}" data-input-counter-decrement="quantity-input-{{ $product->id }}" class="decrement-button bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 border border-gray-300 rounded-s-lg p-3 h-11 focus:ring-gray-100 dark:focus:ring-gray-700 focus:ring-2 focus:outline-none">
                                                    <svg class="w-3 h-3 text-gray-900 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 2">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h16" />
                                                    </svg>
                                                </button>
                                                <input type="text" name="quantity" id="quantity-input-{{ $product->id }}" data-product-id="{{ $product->id }}" data-input-counter data-input-counter-min="1" data-input-counter-max="{{ $product->quantity }}" aria-describedby="helper-text-explanation" class="quantity-input bg-gray-50 border-x-0 border-gray-300 h-11 text-center text-gray-900 text-sm focus:ring-blue-500 focus:border-blue-500 block w-full py-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="1" required>
                                                <button type="button" id="increment-button-{{ $product->id }}" data-product-id="{{ $product->id }}" data-input-counter-increment="quantity-input-{{ $product->id }}" class="increment-button bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 border border-gray-300 rounded-e-lg p-3 h-11 focus:ring-gray-100 dark:focus:ring-gray-700 focus:ring-2 focus:outline-none">
                                                    <svg class="w-3 h-3 text-gray-900 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16" />
                                                    </svg>
                                                </button>
                                            </div>
                                            <x-success-button type="submit" class="ms-3">
                                                <svg class="w-6 me-2 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 10V6a3 3 0 0 1 3-3v0a3 3 0 0 1 3 3v4m3-2 1 12c0 .5-.5 1-1 1H6a1 1 0 0 1-1-1L6 8h12Z" />
                                                </svg>
                                                Покупка
                                            </x-success-button>
                                        </div>
                                    </div>
                                </div>
                                <!-- Comments section -->
                                <div class="mt-8">
                                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white">
                                        @if ($product->comments()->isEmpty())
                                        Няма ревюта
                                        @else
                                        Ревюта
                                        @endif
                                    </h4>
                                    <div class="divide-y divide-gray-200 dark:divide-gray-700 mt-4">
                                        @foreach ($product->comments() as $comment)
                                        <div class="py-4">
                                            <article>
                                                <div class="flex items-center mb-4">
                                                    <div class="font-medium dark:text-white">
                                                        @php
                                                        $user = User::find($comment->user_id);
                                                        @endphp
                                                        <p>{{ $user->name }}
                                                            <time datetime="{{ $user->created_at }}" class="block text-sm text-gray-500 dark:text-gray-400">
                                                                Присъединил се {{ \Carbon\Carbon::parse($user->created_at)->locale('bg')->diffForHumans() }}
                                                            </time>
                                                        </p>
                                                    </div>
                                                </div>
                                                <h3 class="text-sm font-semibold text-gray-900 dark:text-white inline-flex items-center">
                                                    {{ $comment->header }}
                                                    @if ($comment->is_bought)
                                                    <svg class="w-6 h-6 text-green-800 dark:text-green-400 ml-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8.032 12 1.984 1.984 4.96-4.96m4.55 5.272.893-.893a1.984 1.984 0 0 0 0-2.806l-.893-.893a1.984 1.984 0 0 1-.581-1.403V7.04a1.984 1.984 0 0 0-1.984-1.984h-1.262a1.983 1.983 0 0 1-1.403-.581l-.893-.893a1.984 1.984 0 0 0-2.806 0l-.893.893a1.984 1.984 0 0 1-1.403.581H7.04A1.984 1.984 0 0 0 5.055 7.04v1.262c0 .527-.209 1.031-.581 1.403l-.893.893a1.984 1.984 0 0 0 0 2.806l.893.893c.372.372.581.876.581 1.403v1.262a1.984 1.984 0 0 0 1.984 1.984h1.262c.527 0 1.031.209 1.403.581l.893.893a1.984 1.984 0 0 0 2.806 0l.893-.893a1.985 1.985 0 0 1 1.403-.581h1.262a1.984 1.984 0 0 0 1.984-1.984V15.7c0-.527.209-1.031.581-1.403Z" />
                                                    </svg>
                                                    <span class="ml-1">Потвърдена покупка</span>
                                                    @endif
                                                </h3>

                                                <div class="flex items-center mb-1 space-x-1 rtl:space-x-reverse">
                                                    @for ($i = 1; $i <= $comment->rating; $i++)
                                                        <svg class="w-4 h-4 text-yellow-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                                            <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                                                        </svg>
                                                        @endfor
                                                        @for ($i = $comment->rating + 1; $i <= 5; $i++) <svg class="w-4 h-4 text-gray-300 dark:text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                                            <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                                                            </svg>
                                                            @endfor
                                                </div>
                                                <footer class="mb-5 text-sm text-gray-500 dark:text-gray-400">
                                                    <p>Написано <time datetime="{{ $comment->updated_at }}">{{ \Carbon\Carbon::parse($comment->updated_at)->locale('bg')->diffForHumans() }}</time></p>
                                                </footer>
                                                <p class="mb-2 text-gray-500 dark:text-gray-400">{{ $comment->comment }}</p>
                                            </article>

                                        </div>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Close modal button -->
                                <div class="absolute top-4 right-4">
                                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-lg p-2 inline-flex dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="readProductModal-{{ $product->id }}">
                                        <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="sr-only">Close modal</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    @endif
                    @endforeach

                </div>
            </div>
        </div>
    </div>
    <div id="toast-container" class="toast-container" />

</x-app-layout>

<script>
    function createSuccessToast() {
        // Create a new toast element
        var toast = document.createElement('div');
        var toastId = 'toast-' + Date.now(); // Unique ID for each toast
        toast.setAttribute('id', toastId);
        toast.classList.add('fixed', 'right-5', 'flex', 'items-center', 'w-full', 'max-w-xs', 'p-4', 'mb-4', 'text-gray-500', 'bg-white', 'rounded-lg', 'shadow', 'dark:text-gray-400', 'dark:bg-gray-800', 'toast');
        toast.setAttribute('role', 'alert');
        toast.style.transition = 'opacity 0.3s ease-in-out';

        toast.style.position = 'fixed';
        toast.style.bottom = '1rem'; // Adjust this value to set the distance between toasts
        toast.style.right = '1rem'; // Adjust this value to set the distance between toasts
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
        <div class="ms-3 text-sm font-normal">Успешно добавено в количката!</div>
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

    function createFailToast() {
        // Create a new toast element
        var toast = document.createElement('div');
        var toastId = 'toast-' + Date.now(); // Unique ID for each toast
        toast.setAttribute('id', toastId);
        toast.classList.add('fixed', 'right-5', 'flex', 'items-center', 'w-full', 'max-w-xs', 'p-4', 'mb-4', 'text-gray-500', 'bg-white', 'rounded-lg', 'shadow', 'dark:text-gray-400', 'dark:bg-gray-800', 'toast');
        toast.setAttribute('role', 'alert');
        toast.style.transition = 'opacity 0.3s ease-in-out';

        toast.style.position = 'fixed';
        toast.style.bottom = '1rem'; // Adjust this value to set the distance between toasts
        toast.style.right = '1rem'; // Adjust this value to set the distance between toasts
        toast.style.transform = 'translateX(+0%) translateY(-' + (document.querySelectorAll('.toast').length * 35) + 'px)'; // Adjust this value to control the vertical stacking
        toast.style.opacity = '0';
        // Construct toast content
        toast.innerHTML = `
        <!-- Your toast content -->
        <div class="toast inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-orange-500 bg-orange-100 rounded-lg dark:bg-orange-700 dark:text-orange-200">
        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM10 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm1-4a1 1 0 0 1-2 0V6a1 1 0 0 1 2 0v5Z"/>
        </svg>
        <span class="sr-only">Warning icon</span>
    </div>
        <div class="ms-3 text-sm font-normal">Максимално количество достигнато!</div>
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


    $('.add-to-cart').on('click', function() {
        let productId = $(this).data('product-id');
        $.ajax({
            url: '/add-to-cart',
            method: 'POST',
            data: {
                product_id: productId,
                "_token": "{{ csrf_token() }}"
            },
            success: function(response) {
                createSuccessToast();
            },
            error: function(xhr, status, error) {
                if (xhr.status === 422) {
                    // Display the error message from the response
                    createFailToast();
                } else {
                    // Handle other errors
                    console.error('Error:', error);
                    console.error('Status:', status);
                    console.error('Response Text:', xhr.responseText);
                }
            }
        });
    });

    const priceFromInput = document.getElementById('price-from');
    const priceToInput = document.getElementById('price-to');

    // Add event listener to priceFromInput
    priceFromInput.addEventListener('change', function() {
        // Ensure priceFromInput is less than priceToInput
        if (parseFloat(priceFromInput.value) >= parseFloat(priceToInput.value)) {
            priceFromInput.value = parseFloat(priceToInput.value) - 1;
        }
    });

    // Add event listener to priceToInput
    priceToInput.addEventListener('change', function() {
        // Ensure priceToInput is greater than priceFromInput
        if (parseFloat(priceToInput.value) <= parseFloat(priceFromInput.value)) {
            priceToInput.value = parseFloat(priceFromInput.value) + 1;
        }
    });

    // Get all star elements
    const stars = document.querySelectorAll('.star');

    // Initialize the rating value
    let ratingValue = 0;

    // Add event listeners for hover and click
    stars.forEach((star, index) => {
        star.addEventListener('mouseenter', () => {
            // Highlight stars up to the hovered star
            for (let i = 0; i <= index; i++) {
                stars[i].classList.add('highlight');
            }
        });

        star.addEventListener('mouseleave', () => {
            // Remove highlight from all stars
            const closestInput = star.closest('.flex').querySelector('input');
            const starValue = star.getAttribute('data-value');
            if (closestInput.value == 0) {
                stars.forEach((s) => s.classList.remove('highlight'));
            }
            if (closestInput.value != starValue) {
                stars.forEach((s) => {
                    if (s.getAttribute('data-value') > closestInput.value) {
                        s.classList.remove('highlight');
                    }
                })
            }
        });

        star.addEventListener('click', () => {
            event.stopPropagation();
            // Set the rating value based on the clicked star
            starValue = star.getAttribute('data-value');

            // Update the input value
            closestInput = star.closest('.flex').querySelector('input');
            if (starValue == closestInput.value) {
                closestInput.value = 0;
                starValue = 0;
            } else {
                closestInput.value = starValue;
            }

            nearStars = star.closest('.flex').querySelectorAll('.star');
            nearStars.forEach((st) => {
                const sValue = parseInt(st.getAttribute('data-value'));
                if (sValue <= starValue) {
                    st.classList.add('highlight');
                } else {
                    st.classList.remove('highlight');
                }
            });
            console.log(closestInput.value);
        });
    });
</script>

<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<style>
    input[type=range]::-webkit-slider-thumb {
        pointer-events: all;
        width: 24px;
        height: 24px;
        -webkit-appearance: none;
        /* @apply w-6 h-6 appearance-none pointer-events-auto; */
    }

    .star {
        width: 2rem;
        height: 2rem;
        cursor: pointer;
        transition: color 0.3s;
    }

    .star.highlight {
        fill: yellow;
    }
</style>