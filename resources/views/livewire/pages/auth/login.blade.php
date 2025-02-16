<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] #[Title('Login')] class extends Component {
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('diaries', absolute: false), navigate: true);
    }
}; ?>

<div class="flex items-center justify-center h-screen">
  <div class='max-w-screen-sm w-full bg-base-300 py-10 px-16 rounded-xl'>
    <h1 class='text-center text-primary text-3xl mb-10'>{{ __('auth.Login') }}</h1>
    <form wire:submit="login" class="space-y-5">
      <x-input wire:model="form.email" placeholder="{{ __('auth.type your email') }}" />
      <x-password wire:model="form.password"
        placeholder="{{ __('auth.type your password') }}" />
      <x-checkbox label="{{ __('auth.Remember me') }}" wire:model="form.remember" />

      <!-- Buttons -->
      <button type='submit' class='btn btn-primary w-full'>
        {{ __('auth.login') }} <i class='fa-solid fa-arrow-right'></i>
      </button>
      <div class='divider'>{{ __('OR') }}</div>
      <a href='/register' class='btn btn-outline w-full'>
        {{ __('auth.Register') }}
      </a>

      <div class="flex items-center justify-end mt-4 gap-3">
        @if (Route::has('password.request'))
          <a class="underline text-sm text-gray-600 hover:text-primary rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            href="{{ route('password.request') }}" wire:navigate>
            {{ __('auth.Forgot your password?') }}
          </a>
        @endif
      </div>
    </form>
  </div>
</div>
