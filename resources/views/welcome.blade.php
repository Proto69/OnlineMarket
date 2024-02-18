<x-guest-layout>
    @section('title', "Both Sides of the Coin")
    <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-gradient-to-br from-indigo-900 to-blue-700">
        @if (Route::has('login'))
        <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
            @auth
            <a href="{{ url('/dashboard') }}" class="border rounded-2xl px-3 pb-2 p-1 font-semibold bg-transparent font-semibold text-gray-300 hover:text-gray-100 ">Табло</a>
            @else
            <a href="{{ route('login') }}" class="border rounded-2xl px-3 pb-2 p-1 font-semibold bg-transparent text-gray-300 hover:text-gray-100 ">Вход</a>

            @if (Route::has('register'))
            <a href="{{ route('register') }}" class="border rounded-2xl px-3 pb-2 p-1 font-semibold bg-transparent ml-4 font-semibold text-gray-300 hover:text-gray-100 ">Регистрация</a>
            @endif
            @endauth
        </div>
        @endif

        <div class="max-w-7xl mx-auto p-6 lg:p-8">
            <div class="flex justify-center">
                <x-authentication-card-logo></x-authentication-card-logo>
            </div>

            <div class="mt-16">

                <div class="grid grid-cols-1 gap-6 lg:gap-8">

                    <section class="">
                        <div class="gap-8 items-center py-8 px-4 mx-auto max-w-screen-xl xl:gap-16 md:grid md:grid-cols-2 sm:py-16 lg:px-6">
                            <img class="w-full hidden sm:block" src="{{ asset('shopping-mockup.png') }}" alt="dashboard image">
                            <div class="mt-4 md:mt-0">
                                <h2 class="mb-4 text-4xl tracking-tight font-extrabold bg-gradient-to-r from-amber-200 to-yellow-500 bg-clip-text text-transparent">Пазарувайте лесно и наволя!</h2>
                                <p class="mb-6 font-light text-zinc-50 md:text-lg ">Опростената работа на сайта, Ви позволява да пазарувате само с кликането на един бутон! По всяко време можете да редактирате количката си преди да завършите поръчката си!</p>
                                <img class="w-full sm:hidden mb-2" src="{{ asset('shopping-mockup.png') }}" alt="dashboard image">
                                <form action="{{ route('shopping') }}">
                                    @csrf
                                    <button type="submit" class="bg-gradient-to-r from-amber-300 to-yellow-600 inline-flex items-center text-white font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                        Започнете
                                        <svg class="ml-2 -mr-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </section>

                    <!--  -->

                    <section class="mt-1">
                        <div class="gap-8 items-center py-8 px-4 mx-auto max-w-screen-xl xl:gap-16 md:grid md:grid-cols-2 sm:py-16 lg:px-6">
                            <div class="mt-4 md:mt-0">
                                <h2 class="mb-4 text-4xl tracking-tight font-extrabold bg-gradient-to-r from-teal-200 to-teal-500 bg-clip-text text-transparent">Следете поръчките си!</h2>
                                <p class="mb-6 font-light text-zinc-50 md:text-lg ">След като попълните данните си и платите поръчката, можете да следите нея и нейната доставка от страницата "Минали поръчки"! Ако не заплатите поръчката си, можете да го направите по-късно!</p>
                                <img class="w-full sm:hidden mb-2" src="{{ asset('previous-purchases-mockup.png') }}" alt="dashboard image">
                                <form action="{{ route('previous-purchases') }}">
                                    @csrf
                                    <button type="submit" class="bg-gradient-to-r from-teal-400 to-teal-700 inline-flex items-center text-white font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                        Започнете
                                        <svg class="ml-2 -mr-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                            <img class="w-full hidden sm:block" src="{{ asset('previous-purchases-mockup.png') }}" alt="dashboard image">
                        </div>
                    </section>


                    <!-- За продавачи -->
                    <section class="">
                        <div class="gap-8 items-center py-8 px-4 mx-auto max-w-screen-xl xl:gap-16 md:grid md:grid-cols-2 sm:py-16 lg:px-6">
                            <img class="w-full hidden sm:block" src="{{ asset('stripe-connect.png') }}" alt="dashboard image">
                            <div class="mt-4 md:mt-0">
                                <h2 class="mb-4 text-4xl tracking-tight font-extrabold bg-gradient-to-r from-fuchsia-600 to-pink-600 bg-clip-text text-transparent">Бързо и сигурно получаване на пари!</h2>
                                <p class="mb-6 font-light text-zinc-50 md:text-lg ">
                                    Ако искате да продавате продукти, получаването на пари е улеснено чрез употребата на Stripe! След като се регистрирате можете да свържете акаунта си със Stripe където да получавате парите си! <strong class="bg-gradient-to-r from-fuchsia-600 to-pink-600 bg-clip-text text-transparent font-extrabold text-xl">Сигурно, лесно и бързо!</strong>
                                    <br /> Ако искате само да тествате сайта, можете просто да се върнете назад и ще бъдете в тестов режим, където няма да получавате пари!
                                </p>
                                <img class="w-full sm:hidden mb-2" src="{{ asset('stripe-connect.png') }}" alt="dashboard image">
                                <form action="{{ route('dashboard') }}">
                                    @csrf
                                    <button type="submit" class="bg-gradient-to-r from-fuchsia-600 to-pink-600 inline-flex items-center text-white font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                        Започнете
                                        <svg class="ml-2 -mr-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </section>

                    <section class="mt-1">
                        <div class="gap-8 items-center py-8 px-4 mx-auto max-w-screen-xl xl:gap-16 md:grid md:grid-cols-2 sm:py-16 lg:px-6">
                            <div class="mt-4 md:mt-0">
                                <h2 class="mb-4 text-4xl tracking-tight font-extrabold bg-gradient-to-r from-emerald-300 to-emerald-700 bg-clip-text text-transparent">Опростен контрол над продуктите!</h2>
                                <p class="mb-6 font-light text-zinc-50 md:text-lg ">
                                    Можете да създавате и редактирате продукти супер просто чрез натискането на един бутон! Ако пък вече не продавате този продукт, може да го деактивирате!
                                </p>
                                <img class="w-full sm:hidden mb-2" src="{{ asset('dashboard-mockup.png') }}" alt="dashboard image">
                                <form action="{{ route('dashboard') }}">
                                    @csrf
                                    <button type="submit" class="bg-gradient-to-r from-emerald-400 to-emerald-700 inline-flex items-center text-white font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                        Започнете
                                        <svg class="ml-2 -mr-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                            <img class="w-full hidden sm:block" src="{{ asset('dashboard-mockup.png') }}" alt="dashboard image">
                        </div>
                    </section>

                    <section class="">
                        <div class="gap-8 items-center py-8 px-4 mx-auto max-w-screen-xl xl:gap-16 md:grid md:grid-cols-2 sm:py-16 lg:px-6">
                            <img class="w-full hidden sm:block" src="{{ asset('sells-mockup.png') }}" alt="dashboard image">
                            <div class="mt-4 md:mt-0">
                                <h2 class="mb-4 text-4xl tracking-tight font-extrabold bg-gradient-to-r from-red-500 to-orange-500 bg-clip-text text-transparent">Следене на продажбите!</h2>
                                <p class="mb-6 font-light text-zinc-50 md:text-lg ">
                                    В една страница можете да наблюдавате всички ваши продажби, както и статуса им на доставка! Това е полезно при сверяване на данни и количества!
                                </p>
                                <img class="w-full sm:hidden mb-2" src="{{ asset('sells-mockup.png') }}" alt="dashboard image">
                                <form action="{{ route('sells') }}">
                                    @csrf
                                    <button type="submit" class="bg-gradient-to-r from-red-500 to-orange-500 inline-flex items-center text-white font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                        Започнете
                                        <svg class="ml-2 -mr-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </section>

                </div>
            </div>

            <div class="flex justify-center mt-16">
                <div class="text-sm text-center text-gray-500 dark:text-gray-400 sm:text-right">
                    © 2024 <strong class="text-red-400">Both Sides of the Coin</strong>. Всички права запазени
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>