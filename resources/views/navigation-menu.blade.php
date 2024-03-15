@php
use Illuminate\Support\Facades\Auth;
use App\Models\Seller;
use App\Models\Category;
use App\Models\MainCategory;

$user = Auth::user();
$typeOfAccount = $user->type;

$existingSeller = Seller::where('user_id', Auth::user()->id)->first();
@endphp




<nav id="navMenu" x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">

    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center hidden dark:block dark:mt-2.5">
                    <a href="{{ route('welcome') }}">
                        <x-application-mark-dark class="block h-9 w-auto" />
                    </a>
                </div>
                <div class="shrink-0 flex items-center dark:hidden">
                    <a href="{{ route('welcome') }}">
                        <x-application-mark-light class="block h-9 w-auto" />
                    </a>
                </div>

                @if ($typeOfAccount == "Seller")
                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                        {{ __('Управляване на продукти') }}
                    </x-nav-link>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link href="{{ route('sells') }}" :active="request()->routeIs('sells')">
                        {{ __('Продажби') }}
                    </x-nav-link>
                </div>

                <!-- <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link href="{{ route('stats') }}" :active="request()->routeIs('stats')">
                        {{ __('Статистики') }}
                    </x-nav-link>
                </div> -->

                @elseif ($typeOfAccount == "Buyer")

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link href="{{ route('shopping') }}" id="dropdownHoverButton" data-dropdown-toggle="dropdownHover" data-dropdown-trigger="hover" :active="request()->routeIs('shopping')">
                        {{ __('Пазаруване') }}
                    </x-nav-link>
                </div>
                @php
                $mainCategories = MainCategory::all();
                @endphp

                <!-- Dropdown menu -->
                <div id="dropdownHover" class="dropdown-content z-10 hidden w-72 bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600">
                    <ul class="p-3 space-y-3 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownHoverButton">
                        @foreach ($mainCategories as $mainCategory)
                        <li>
                            <button id="doubleDropdownButton-{{ $mainCategory->id }}" data-dropdown-toggle="doubleDropdown-{{ $mainCategory->id }}" data-dropdown-placement="right-start" data-dropdown-trigger="hover" type="button" class="flex items-center rounded-lg justify-between w-full px-4 py-1 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white text-sm">{{ $mainCategory->name }}<svg class="w-2.5 h-2.5 ms-3 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                                </svg></button>
                            <div id="doubleDropdown-{{ $mainCategory->id }}" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-72 ms-2 dark:bg-gray-700">
                                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="doubleDropdownButton-{{ $mainCategory->id }}">
                                    @foreach (Category::where('main_category', $mainCategory->id)->get() as $category)
                                    <li>
                                        <a href="/shopping/{{ $category->name }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">{{ $category->name }}</a>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link href="{{ route('previous-purchases') }}" :active="request()->routeIs('previous-purchases')">
                        {{ __('Минали покупки') }}
                    </x-nav-link>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link href="{{ route('shopping-cart') }}" :active="request()->routeIs('shopping-cart')">
                        {{ __('Количка') }}
                        <svg class="ms-1 w-5 h-5 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9V4a3 3 0 0 0-6 0v5m9.92 10H2.08a1 1 0 0 1-1-1.077L2 6h14l.917 11.923A1 1 0 0 1 15.92 19Z" />
                        </svg>
                    </x-nav-link>
                </div>

                @elseif ($typeOfAccount == "Admin")

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link href="{{ route('products') }}" :active="request()->routeIs('products')">
                        {{ __('Всички продукти') }}
                    </x-nav-link>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link href="{{ route('users') }}" :active="request()->routeIs('users')">
                        {{ __('Всички акаунти') }}
                    </x-nav-link>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link href="{{ route('appeals') }}" :active="request()->routeIs('appeals')">
                        {{ __('Обжалвания') }}
                    </x-nav-link>
                </div>
                @endif
            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-3">

                @if ($typeOfAccount === "Buyer")
                <!-- Search input -->
                <form action="/search" method="GET" class="me-3">
                    @csrf
                    <x-label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Търси</x-label>
                    <div class="relative">
                        <x-input type="search" name="keyWord" id="default-search" class="block w-96 p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Търси продукт . . ." required />
                        <x-button type="submit" class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <svg class="w-4 h-4 text-gray-100 dark:text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                        </x-button>
                    </div>
                </form>
                @endif

                <button id="theme-toggle" type="button" class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5">
                    <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                    </svg>
                    <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path>
                    </svg>
                </button>

                @if($typeOfAccount == "Seller")
                <x-paid-log class="ms-2">
                    Баланс: {{ Seller::where('user_id', $user->id)->first()->balance }}лв
                </x-paid-log>
                @endif

                <!-- Settings Dropdown -->
                <div class="ml-3 relative ">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                            <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                            </button>
                            @else
                            <span class="inline-flex rounded-md">
                                <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none focus:bg-gray-50 dark:focus:bg-gray-700 active:bg-gray-50 dark:active:bg-gray-700 transition ease-in-out duration-150">
                                    {{ Auth::user()->name }}

                                    <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                    </svg>
                                </button>
                            </span>
                            @endif
                        </x-slot>

                        <x-slot name="content">
                            <!-- Account Management -->
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Управляване на акаунт') }}
                            </div>

                            <x-dropdown-link href="{{ route('profile') }}">
                                {{ __('Профил') }}
                            </x-dropdown-link>

                            <form id="switchAcc" method="POST" action="{{ route('switch.account') }}">
                                @csrf
                                @if ($typeOfAccount === "Buyer")
                                <input type="hidden" name="newType" value="Seller">

                                <x-dropdown-link href="{{ route('dashboard') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Премини към продавач') }}
                                </x-dropdown-link>

                                @elseif ($typeOfAccount === "Seller")
                                <input type="hidden" name="newType" value="Buyer">

                                <x-dropdown-link href="{{ route('dashboard') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Премини към купувач') }}
                                </x-dropdown-link>
                                @endif
                            </form>

                            <div class="border-t border-gray-200 dark:border-gray-600"></div>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf

                                <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                                    {{ __('Изход') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <!-- TODO: Responsive dropdown needed -->
            <x-basic-button class="my-2 px-3 text-center sm:hidden" >
                Категории
            </x-basic-button>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">

        <div class="pt-2 pb-3 space-y-1">
            @if ($typeOfAccount == "Buyer")

            <x-responsive-nav-link href="{{ route('shopping') }}" :active="request()->routeIs('shopping')">
                {{ __('Пазаруване') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link href="{{ route('previous-purchases') }}" :active="request()->routeIs('previous-purchases')">
                {{ __('Минали покупки') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link href="{{ route('shopping-cart') }}" :active="request()->routeIs('shopping-cart')">
                {{ __('Количка') }}
            </x-responsive-nav-link>

            @elseif ($typeOfAccount == "Seller")

            <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                {{ __('Управляване на продукти') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link href="{{ route('sells') }}" :active="request()->routeIs('sells')">
                {{ __('Продажби') }}
            </x-responsive-nav-link>

            <!-- <x-responsive-nav-link href="{{ route('stats') }}" :active="request()->routeIs('stats')">
                {{ __('Статистики') }}
            </x-responsive-nav-link> -->


            @elseif ($typeOfAccount == "Admin")

            <x-responsive-nav-link href="{{ route('products') }}" :active="request()->routeIs('products')">
                {{ __('Всички продукти') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link href="{{ route('users') }}" :active="request()->routeIs('users')">
                {{ __('Всички акаунти') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link href="{{ route('appeals') }}" :active="request()->routeIs('appeals')">
                {{ __('Обжалвания') }}
            </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="flex items-center px-4">
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                <div class="shrink-0 mr-3">
                    <img class="h-10 w-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                </div>
                @endif

                <div>
                    <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Account Management -->
                <x-responsive-nav-link href="{{ route('profile') }}" :active="request()->routeIs('profile')">
                    {{ __('Профил') }}
                </x-responsive-nav-link>

                <form id="switchAcc" method="POST" action="{{ route('switch.account') }}">
                    @csrf
                    @if ($typeOfAccount === "Buyer")
                    <input type="hidden" name="newType" value="Seller">

                    <x-responsive-nav-link href="{{ route('dashboard') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Премини към продавач') }}
                    </x-responsive-nav-link>

                    @elseif ($typeOfAccount === "Seller")
                    <input type="hidden" name="newType" value="Buyer">

                    <x-responsive-nav-link href="{{ route('dashboard') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Премини към купувач') }}
                    </x-responsive-nav-link>
                    @endif
                </form>

                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf
                    <x-responsive-nav-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                        {{ __('Изход') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>

<script>
    var themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
    var themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

    // Change the icons inside the button based on previous settings
    if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        themeToggleLightIcon.classList.remove('hidden');
    } else {
        themeToggleDarkIcon.classList.remove('hidden');
    }

    var themeToggleBtn = document.getElementById('theme-toggle');

    themeToggleBtn.addEventListener('click', function() {

        // toggle icons inside button
        themeToggleDarkIcon.classList.toggle('hidden');
        themeToggleLightIcon.classList.toggle('hidden');

        // if set via local storage previously
        if (localStorage.getItem('color-theme')) {
            if (localStorage.getItem('color-theme') === 'light') {
                document.documentElement.classList.add('dark');
                localStorage.setItem('color-theme', 'dark');
            } else {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('color-theme', 'light');
            }

            // if NOT set via local storage previously
        } else {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('color-theme', 'light');
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('color-theme', 'dark');
            }
        }

    });
</script>