<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;

new
#[Layout('layouts.guest')]
#[Title('Login')]
class extends Component {
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        session()->put('strava_info', [
            'access_token' => 'abcghf',
        ]);

        $this->redirectIntended(default: route('home', absolute: false), navigate: true);
    }
}; ?>

<div class="flex items-center justify-center h-screen">
  <x-auth-session-status class="mb-4" :status="session('status')"/>

  <div class='max-w-screen-sm w-full bg-base-300 py-10 px-16 rounded-xl'>
    <h1 class='text-center text-primary text-3xl mb-10'>Login</h1>
    <form wire:submit="login" class="space-y-5">
{{--      <label class='form-control w-full'>--}}
{{--        <div class='label'>--}}
{{--          <span class='label-text'>Email</span>--}}
{{--        </div>--}}
{{--        <input--}}
{{--          wire:model="form.email"--}}
{{--          type='email'--}}
{{--          placeholder='type your email'--}}
{{--          class='input input-bordered w-full'--}}
{{--          autoComplete='off'--}}
{{--          required--}}
{{--        />--}}
{{--        <x-input-error :messages="$errors->get('form.email')" class="mt-2"/>--}}
{{--    </label>--}}

      <x-input-field
        wire:model="form.email"
        label="{{ __('Email') }}"
        placeholder="{{ __('type your email') }}"
      />

      <x-input-field
        wire:model="form.password"
        type="password"
        label="{{ __('Password') }}"
        placeholder="{{ __('type your password') }}"
      />

      <!-- Remember Me -->
      <div class="block mt-4">
        <label for="remember" class="inline-flex items-center">
          <input wire:model="form.remember" id="remember" type="checkbox"
                 class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
          <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
        </label>
      </div>

      <!-- Buttons -->
      <button type='submit' class='btn btn-primary w-full'>
        login <i class='fa-solid fa-arrow-right'></i>
      </button>
      <div class='divider'>OR</div>
      <a href='/register' class='btn btn-outline w-full'>
        {{  __('Register') }}
      </a>

      <div class="flex items-center justify-end mt-4 gap-3">
        @if (Route::has('password.request'))
          <a
            class="underline text-sm text-gray-600 hover:text-primary rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            href="{{ route('password.request') }}" wire:navigate>
            {{ __('Forgot your password?') }}
          </a>
        @endif
      </div>
    </form>
  </div>
</div>
