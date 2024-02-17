<x-guest-layout>
    @section('title', "Both Sides of the Coin")
    <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-gradient-to-br from-stone-600 to-cyan-900">
        @if (Route::has('login'))
        <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
            @auth
            <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Табло</a>
            @else
            <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Вход</a>

            @if (Route::has('register'))
            <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Регистрация</a>
            @endif
            @endauth
        </div>
        @endif

        <div class="max-w-7xl mx-auto p-6 lg:p-8">
            <div class="flex justify-center">
                <x-authentication-card-logo></x-authentication-card-logo>
            </div>

            <div class="mt-16">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">

                    <!-- За купувачи -->
                    <div>
                        <h1 class="text-3xl text-center">За купувачи</h1>
                        <!--  -->
                        <a href="https://laravel-news.com" class="mt-2 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 scale-100 p-6 rounded-lg flex motion-safe:hover:scale-[1.01] transition-all duration-250">
                            <div>
                                <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">Пазаруване</h2>

                                <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                                    Добавете продукти в количката си от страницата за пазаруване! <br />
                                    След това си въведете данните и натиснете бутона, за да преминете към плащането! <br />
                                    Толкова е лесно!!!
                                </p>
                            </div>
                        </a>

                        <!--  -->
                        <a href="https://laravel-news.com" class="mt-2 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 scale-100 p-6 rounded-lg flex motion-safe:hover:scale-[1.01] transition-all duration-250">
                            <div>
                                <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">Следене на поръчки</h2>

                                <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                                    Ако не заплатите поръчката си, можете да го направите по късно от страницата за минали поръчки! <br />
                                    Там можете да следите и платените си покупки и техните доставки!
                                </p>
                            </div>
                        </a>

                    </div>

                    <!-- За продавачи -->
                    <div>
                        <h1 class="text-3xl text-center">За продавачи</h1>
                        <!--  -->
                        <a href="https://laravel-news.com" class="mt-2 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 scale-100 p-6 rounded-lg flex motion-safe:hover:scale-[1.01] transition-all duration-250">
                            <div>
                                <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">Свързване на акаунт</h2>

                                <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                                    За да получавате парите си директно в Stripe, при регистрация ще бъдете препратени към сайта им! <br />
                                    Там след като преминете през всичко, акаунтът Ви ще е напълно готов! <br />
                                    Ако искате само да тествате, може да се върнете назад към нашия сайт и така ще бъдете в тестов режим!
                                </p>
                            </div>
                        </a>

                        <!--  -->
                        <a href="https://laravel-news.com" class="mt-2 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 scale-100 p-6 rounded-lg flex motion-safe:hover:scale-[1.01] transition-all duration-250">
                            <div>
                                <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">Продукти и продажби</h2>

                                <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                                    Можете да създавате и редактирате продуктите си с едно натискане на бутона! <br />
                                    Ако вече не предлагате даден продукт можете да го деактивирате и готово! <br />
                                    Можете да следите продажбите си в страницата с продажби! Там ще намерите нужната информация за купувача!
                                </p>
                            </div>
                        </a>


                    </div>
                </div>
            </div>

            <div class="flex justify-center mt-16 px-0 sm:items-center sm:justify-between">

                <div class="ml-4 text-center text-sm text-gray-500 dark:text-gray-400 sm:text-right sm:ml-0">
                    © 2024 <strong class="text-teal-400">Both Sides of the Coin</strong>. All Rights Reserved
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>