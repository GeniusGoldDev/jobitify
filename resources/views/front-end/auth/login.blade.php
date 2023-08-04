<!-- login START -->
<x-guest-layout :title="__('general.login')">
    <x-auth-card :description="__('auth.signin_desciption')" :auth_bg="$auth_bg" :sitelogo="$sitelogo">
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />
        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />
        <!-- Login Form -->
        <x-login-form />
    </x-auth-card>
</x-guest-layout>
