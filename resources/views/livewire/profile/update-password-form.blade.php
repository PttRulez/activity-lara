<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Volt\Component;

new class extends Component {
    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Update the password for the currently authenticated user.
     */
    public function updatePassword(): void
    {
        $validated = $this->validate([
            'current_password' => ['required', 'string', 'current_password'],
            'password' => ['required', 'string', Password::defaults(), 'confirmed'],
        ]);

        Auth::user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        $this->reset('current_password', 'password', 'password_confirmation');

        $this->dispatch('password-updated');
    }
}; ?>

<x-card title="{{ __('pages/profile.update_password_title') }}" separator
  progress-indicator>

  <x-form form wire:submit.prevent class="mt-6 space-y-6">

    <x-password wire:model="current_password" :label="__('pages/profile.current_password')" />

    <x-password wire:model="password" :label="__('pages/profile.new_password')" />

    <x-password wire:model="password_confirmation" :label="__('pages/profile.password_confirmation')" />

    <div class="flex items-center gap-4">
      <x-button :label="__('Save')" class="btn-primary" wire:click="updatePassword" />
    </div>
  </x-form>
</x-card>
