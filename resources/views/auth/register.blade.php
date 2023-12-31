<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500"></x-application-logo>
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors"></x-auth-validation-errors>

        <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
            <div>
                <x-label for="name" :value="__('Name')"></x-label>

                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus></x-input>
            </div>


            <!-- Surname -->
            <div class="mt-4">
                <x-label for="surname" :value="__('Surname')"></x-label>

                <x-input id="surname" class="block mt-1 w-full" type="text" name="surname" :value="old('surname')" required autofocus></x-input>
            </div>


            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('Email')"></x-label>

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required></x-input>
            </div>


{{--            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')"></x-label>

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password"></x-input>
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Confirm Password')"></x-label>

                <x-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required></x-input>
            </div>--}}





        <!-- Birthday -->
            <div class="mt-4">
                <x-label for="birthday" :value="__('Birthday')"></x-label>

                <x-input id="birthday" class="block mt-1 w-full" type="date" name="birthday" :value="old('birthday')" required autofocus></x-input>
            </div>


            <!-- Phone -->
            <div class="mt-4">
                <x-label for="phone" :value="__('Phone')"></x-label>

                <x-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" required autofocus></x-input>
            </div>


            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ml-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
