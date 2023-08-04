<x-guest-layout :title="__('general.verify_account')">
    <x-auth-card   :sitelogo="$sitelogo" :auth_bg="$auth_bg">
        <div class="tk-verifyemail_info">
            {{ __('auth.verify_email_desc') }}
        </div>
        
        @if (session('status') == 'verification-link-sent')
            <div class="tk-verifyemail_alert">
                {{ __('auth.verify_email_link') }}
            </div>
        @endif

        <div class="tk-verify-email">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <div>
                    <x-button>
                        {{ __('auth.resend_verification_email') }}
                    </x-button>
                </div>
            </form>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="tk-btn-solid-lg">
                    {{ __('auth.logout') }}
                </button>
            </form>
        </div>
    </x-auth-card>
</x-guest-layout>
