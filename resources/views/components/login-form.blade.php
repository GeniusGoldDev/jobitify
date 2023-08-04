<form  class="tk-themeform" method="POST" action="{{ route('login') }}">
    @csrf
    <fieldset>
        <div class="tk-themeform__wrap">
            <div class="form-group">
                <div class="tk-placeholderholder">
                    <x-input id="email"   type="email" name="email" :value="old('email')" placeholder="{{ __('auth.email') }}" required autofocus />
                </div>
            </div>
            <div class="form-group">
                <div class="tk-placeholderholder">
                    <x-input id="password"
                        type="password"
                        name="password"
                        placeholder="{{ __('auth.password') }}"
                        required autocomplete="current-password"
                    />
                </div>
            </div>
            <!-- Remember me -->
           <div class="form-group">
                <div class="tk-form-checkbox">
                    <input id="remember_me" type="checkbox" class="form-check-input form-check-input-lg" name="remember">
                    <label for="remember_me" class="form-check-label">
                        <span> {{ __('auth.remember_me') }}  </span>
                    </label>
                </div>
            </div>
            <div class="tk-popup-terms">
                <x-button>
                    {{ __('auth.login') }}
                </x-button>
            </div>
            <div class="tk-lost-password">
                <a href="{{route('register')}}">{{__('auth.join_us_today')}}</a>
                @if (Route::has('password.request'))
                    <a class="tk-password-clr_light" href="{{ route('password.request') }}">
                        {{ __('auth.lost_password') }}
                    </a>
                @endif
            </div>
        </div>
    </fieldset> 
</form>
  