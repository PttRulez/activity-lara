<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] #[Title('Register')] class extends Component {
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered(($user = User::create($validated))));

        Auth::login($user);

        $this->redirect(route('diaries', absolute: false), navigate: true);
    }
}; ?>


<div class="flex items-center justify-center h-screen">
  <div class='max-w-screen-sm w-full bg-base-300 py-10 px-16 rounded-xl'>
    <h1 class='text-center text-primary text-3xl mb-10'>{{ __('auth.Register') }}</h1>
    <form wire:submit="register" class="space-y-5">
      <x-input wire:model="name" placeholder="{{ __('name or nickname') }}" />
      <x-input wire:model="email" placeholder="{{ __('auth.type your email') }}" />
      <x-password wire:model="password"
        placeholder="{{ __('auth.type your password') }}" />
      <x-password wire:model="password_confirmation"
        placeholder="{{ __('auth.confirm_password') }}" />

      <!-- Buttons -->
      <button type='submit' class='btn btn-primary w-full'>
        {{ __('auth.register') }} <i class='fa-solid fa-arrow-right'></i>
      </button>
      <div class='divider'>{{ __('OR') }}</div>
      <a href='/login' class='btn btn-outline w-full'>
        {{ __('auth.Login') }}
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
