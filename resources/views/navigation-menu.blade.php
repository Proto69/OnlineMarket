@php
use Illuminate\Support\Facades\Auth;
use App\Models\Seller;

$typeOfAccount = Auth::user()->type;

$existingSeller = Seller::where('user_id', Auth::user()->id)->first();
@endphp




<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                @if ($typeOfAccount == "Seller")
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-mark class="block h-9 w-auto" />
                    </a>
                </div>
                @else
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('shopping') }}">
                        <x-application-mark class="block h-9 w-auto" />
                    </a>
                </div>
                @endif

                @if ($typeOfAccount == "Seller")
                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                        {{ __('Manage products') }}
                    </x-nav-link>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link href="{{ route('sells') }}" :active="request()->routeIs('sells')">
                        {{ __('Sells') }}
                    </x-nav-link>
                </div>

                @else

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link href="{{ route('shopping') }}" :active="request()->routeIs('shopping')">
                        {{ __('Shopping') }}
                    </x-nav-link>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link href="{{ route('previous-purchases') }}" :active="request()->routeIs('previous-purchases')">
                        {{ __('Previous purchases') }}
                    </x-nav-link>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link href="{{ route('shopping-cart') }}" :active="request()->routeIs('shopping-cart')">
                        {{ __('Shopping cart') }}
                    </x-nav-link>
                </div>
                @endif


            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-3">

                <!-- Search input -->
                <form class="me-3">
                    <x-label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</x-label>
                    <div class="relative">
                        
                        <x-input type="search" id="default-search" class="block w-96 p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search . . ." required />
                        <x-button type="submit" class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <svg class="w-4 h-4 text-gray-100 dark:text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                        </x-button>
                    </div>
                </form>


                <!-- Button to set dark theme -->
                <button id="mode-toggle-light" class="dark:display-flex dark:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-sun align-middle">
                        <circle cx="12" cy="12" r="5"></circle>
                        <line x1="12" y1="1" x2="12" y2="3"></line>
                        <line x1="12" y1="21" x2="12" y2="23"></line>
                        <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
                        <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
                        <line x1="1" y1="12" x2="3" y2="12"></line>
                        <line x1="21" y1="12" x2="23" y2="12"></line>
                        <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
                        <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
                    </svg>
                </button>

                <!-- Button to set light theme-->
                <button id="mode-toggle-dark" class="text-black dark:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-moon align-middle">
                        <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
                    </svg>
                </button>

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
                                {{ __('Manage Account') }}
                            </div>

                            <x-dropdown-link href="{{ route('profile.show') }}">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <form id="switchAcc" method="POST" action="{{ route('switch.account') }}">
                                @csrf
                                @if ($typeOfAccount === "Buyer")
                                <input type="hidden" name="newType" value="Seller">
                                <input type="hidden" name="stripe_key" id="stripe_key">
                                @if (!$existingSeller)
                                <x-dropdown-link id="openPopup" href="{{ route('dashboard') }}" onclick="event.preventDefault();">
                                    {{ __('Switch to Seller') }}
                                </x-dropdown-link>
                                @else
                                <x-dropdown-link href="{{ route('dashboard') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Switch to Seller') }}
                                </x-dropdown-link>
                                @endif
                                @else ($typeOfAccount === "Seller")
                                <input type="hidden" name="newType" value="Buyer">
                                <x-dropdown-link href="{{ route('dashboard') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Switch to Buyer') }}
                                </x-dropdown-link>
                                @endif
                            </form>

                            <div class="border-t border-gray-200 dark:border-gray-600"></div>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf

                                <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <!-- Popup -->
            <div id="popup" style="display: none;position: fixed;top: 0;left: 0;width: 100%;height: 100%;background-color: rgba(17, 24, 39, 0.7); backdrop-filter: blur(10px);">
                <div style="position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);background-color: rgba(17, 24, 39);;padding: 20px;border-radius: 5px;text-align: center;">
                    <h2 style="color: #fff">Enter your Stripe Key</h2>
                    <x-input type="text" id="inputField" placeholder="Enter your Stripe Key" style="width: 80%;padding: 10px;" class="mt-1 mb-4" />
                    <x-secondary-button id="submitInput" type="button">Save</x-secondary-button>
                    <x-danger-button id="closePopup" type="button">Cancel</x-danger-button>
                </div>
            </div>

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
            <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
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
                <x-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                <x-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')">
                    {{ __('API Tokens') }}
                </x-responsive-nav-link>
                @endif

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf

                    <x-responsive-nav-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>

<script>
    // Get references to elements
    const openButton = document.getElementById('openPopup');
    const closeButton = document.getElementById('closePopup');
    const popup = document.getElementById('popup');
    const submitButton = document.getElementById('submitInput');
    const inputField = document.getElementById('inputField');
    const stripeField = document.getElementById('stripe_key');
    const accForm = document.getElementById('switchAcc');

    // Function to open the pop-up
    function openPopup() {
        popup.style.display = 'block';
    }

    // Function to close the pop-up
    function closePopup() {
        popup.style.display = 'none';
    }

    // Event listeners
    openButton.addEventListener('click', openPopup);
    closeButton.addEventListener('click', closePopup);

    // Handle submit button click
    submitButton.addEventListener('click', function() {
        const userInput = inputField.value;
        closePopup();
        stripeField.value = userInput;
        accForm.submit();
    });

    const modeButtonDark = document.getElementById('mode-toggle-dark');
    const modeButtonLight = document.getElementById('mode-toggle-light');

    if (localStorage.theme === "light") {
        modeButtonLight.classList.add('hidden');
    }

    modeButtonDark.addEventListener('click', function() {
        console.log('clicked');
        localStorage.theme = 'dark';
        location.reload();
    });

    modeButtonLight.addEventListener('click', function() {
        console.log('clicked');
        localStorage.theme = 'light';
        location.reload();
    });
</script>