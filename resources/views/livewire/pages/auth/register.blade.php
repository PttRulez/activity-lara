<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;

new
#[Layout('layouts.guest')]
#[Title('Register')]
class extends Component {
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

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        $this->redirect(route('diaries', absolute: false), navigate: true);
    }
}; ?>


<div class="flex items-center justify-center h-screen">
  <div class='max-w-screen-sm w-full bg-base-300 py-10 px-16 rounded-xl'>
    <h1 class='text-center text-primary text-3xl mb-10'>Register</h1>
    <form wire:submit="register" class="space-y-5">
      <label class='form-control w-full'>
        <div class='label'>
          <span class='label-text'>Name</span>
        </div>
        <input
          wire:model="name"
          type='text'
          placeholder='type your name'
          class='input input-bordered w-full'
          autoComplete='off'

        />
        <x-input-error :messages="$errors->get('name')" class="mt-2"/>
      </label>

      <label class='form-control w-full'>
        <div class='label'>
          <span class='label-text'>Email</span>
        </div>
        <input
          wire:model="email"
          type='email'
          placeholder='type your email'
          class='input input-bordered w-full'
          autoComplete='off'

        />
        <x-input-error :messages="$errors->get('email')" class="mt-2"/>
      </label>

      <label class='form-control w-full'>
        <div class='label'>
          <span class='label-text'>Password</span>
        </div>
        <input
          wire:model="password"
          type='password'
          placeholder='type your password'
          class='input input-bordered w-full'
          autoComplete='off'

        />
        <x-input-error :messages="$errors->get('password')" class="mt-2"/>
      </label>

      <label class='form-control w-full'>
        <div class='label'>
          <span class='label-text'>Confirm Password</span>
        </div>
        <input
          wire:model="password_confirmation"
          type='password'
          placeholder='type your password'
          class='input input-bordered w-full'
          autoComplete='off'

        />
        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2"/>
      </label>


      <!-- Buttons -->
      <button type='submit' class='btn btn-primary w-full'>
        register <i class='fa-solid fa-arrow-right'></i>
      </button>
      <div class='divider'>OR</div>
      <a href='/login' class='btn btn-outline w-full'>
        {{  __('Login') }}
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

