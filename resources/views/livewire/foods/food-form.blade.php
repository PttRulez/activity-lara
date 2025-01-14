<?php

use Livewire\Volt\Component;

new class extends Component {

    public function submit(): void
    {
        $this->dispatch('close-food-form');
    }

    public function cancel(): void
    {
        $this->dispatch('close-food-form');
    }
}; ?>

<form wire:submit="submit" class='pt-3'>
  <div class='flex flex-col gap-2'>
    <section>
      <x-input-field
        wire:model="form.name"
        label="{{ __('Name') }}"
        placeholder="{{ __('type food name') }}"
      />
    </section>

    <section class='flex justify-between gap-2'>
      <x-input-field
        wire:model="form.calories"
        label="{{ __('Calories per 100 gram') }}"
        placeholder="{{ __('type calories per 100g') }}"
      />

      <x-input-field
        wire:model="form.protein"
        label="{{ __('Proteins per 100 gram') }}"
        placeholder="{{ __('type proteins per 100g') }}"
      />

    </section>

    <section class='flex justify-between gap-2'>
      <x-input-field
        wire:model="form.fat"
        label="{{ __('Fats per 100 gram') }}"
        placeholder="{{ __('type fats per 100g') }}"
      />

      <x-input-field
        wire:model="form.carbs"
        label="{{ __('Carbs per 100 gram') }}"
        placeholder="{{ __('type carbs per 100g') }}"
      />


    </section>

    <div class='flex justify-end gap-3 pt-5'>
      <button type='submit' class='btn btn-primary'>
        {{ __('Save') }}
      </button>
      <div id='btn' class='btn' wire:click="cancel">
        {{ __('Cancel') }}
      </div>
    </div>
  </div>
</form>
