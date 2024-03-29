<x-guest-layout>
@section('title', "Регистрация")
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <x-label for="name" value="{{ __('Име') }}" />
                <x-input id="name" class="block mt-1 w-full p-1" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            </div>

            <div class="mt-4">
                <x-label for="email" value="{{ __('Имейл') }}" />
                <x-input id="email" class="block mt-1 w-full p-1" type="email" name="email" :value="old('email')" required autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Парола') }}" />
                <x-input id="password" class="block mt-1 w-full p-1" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-label for="password_confirmation" value="{{ __('Потвърди парола') }}" />
                <x-input id="password_confirmation" class="block mt-1 w-full p-1" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            <x-label for="accountTypeBuyer" class="flex items-center mt-3">
                <input id="accountTypeBuyer" class="form-radio h-5 w-5" type="radio" name="accountTypeBuyer" value="Seller" />
                <span class="ml-2 text-gray-700 dark:text-gray-300">Купувач</span>
            </x-label>

            <x-label for="accountTypeSeller" class="flex items-center mt-3">
                <input id="accountTypeSeller" class="form-radio h-5 w-5 text-indigo-600" type="radio" name="accountTypeBuyer" value="Buyer" />
                <span class="ml-2 text-gray-700 dark:text-gray-300">Продавач</span>
            </x-label>

            <div class="mt-4" style="display: block">
                <x-input id="type" class="block mt-1 w-full" type="hidden" name="type" autocomplete="type" />
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-label for="terms">
                        <div class="flex items-center">
                            <x-checkbox name="terms" id="terms" required />

                            <div class="ml-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-label>
                </div>
            @endif

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                    {{ __('Имаш акаунт?') }}
                </a>

                <x-button class="ml-4">
                    {{ __('Регистрация') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>

<script>
    const accountTypeBuyer = document.getElementById('accountTypeBuyer');
    const accountTypeSeller = document.getElementById('accountTypeSeller');
    const sellerInfoDiv = document.getElementById('sellerInfo');
    const accountTypeDiv = document.getElementById('type');

    accountTypeBuyer.checked = true;
    accountTypeDiv.value = "Buyer"
                           
    accountTypeSeller.addEventListener('change', () => {
        if (accountTypeSeller.checked) {
            accountTypeDiv.value = "Seller"
        } 
    });

    accountTypeBuyer.addEventListener('change', () => {
        if (accountTypeBuyer.checked) {
            accountTypeDiv.value = "Buyer"
        }
    });
</script>

