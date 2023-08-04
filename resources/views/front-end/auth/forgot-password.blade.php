<x-guest-layout :title="__('general.reset_password')">
    <x-auth-card :description="__('auth.forget_desciption')" :auth_bg="$auth_bg" :sitelogo="$sitelogo">
        
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <fieldset>
                <div class="tk-themeform__wrap">
                    <div class="form-group">
                        <div class="tk-placeholderholder">
                            <x-input id="email" class="form-control" type="email" placeholder="{{ __('auth.email_or_username') }}" name="email" :value="old('email')" required autofocus />
                        </div>
                    </div>
                    <div class="tk-popup-terms">
                        <x-button>
                              {{ __('auth.reset_link') }}
                        </x-button>
                    </div>
                    <div class="tk-lost-password">
                    <a href="{{route('register')}}">{{__('auth.join_us_today')}}</a>
                    <a href="{{route('login')}}">{{ __('auth.signin') }}</a>
                    </div>
                </div>
            </fieldset>
        </form>
    </x-auth-card>
</x-guest-layout>
