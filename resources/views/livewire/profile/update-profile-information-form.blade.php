<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component {
    public string $name = '';
    public string $email = '';
    public int $bmr = 0;
    public int $caloriesPer100Steps = 0;
    public string $color1;
    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
        $this->bmr = Auth::user()->bmr;
        $this->caloriesPer100Steps = Auth::user()->calories_per_100_steps;
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->dispatch('profile-updated', name: $user->name);
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function sendVerification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<x-card title="{{ __('pages/profile.information') }}" separator progress-indicator>

  <x-form wire:submit.prevent class="mt-6 space-y-6">
    <x-input wire:model="name" placeholder="{{ __('auth.type your name') }}"
      :label="__('name or nickname')" />

    <div>
      <x-input wire:model="email" placeholder="{{ __('auth.type your email') }}"
        :label="__('email')" />

      @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail &&
              !auth()->user()->hasVerifiedEmail())
        <div>
          <p class="text-sm mt-2 text-gray-800">
            {{ __('Your email address is unverified.') }}

            <button wire:click.prevent="sendVerification"
              class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
              {{ __('Click here to re-send the verification email.') }}
            </button>
          </p>

          @if (session('status') === 'verification-link-sent')
            <p class="mt-2 font-medium text-sm text-green-600">
              {{ __('A new verification link has been sent to your email address.') }}
            </p>
          @endif
        </div>
      @endif
    </div>

    <div class="flex items-center gap-4">
      <x-button :label="__('Save')" class="btn-primary"
        wire:click="updateProfileInformation" spinner="updateProfileInformation" />
    </div>
  </x-form>
</x-card>
