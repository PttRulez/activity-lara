<?php

use Livewire\Volt\Component;

new class extends Component {
    public string $date;
    public float $weight;

    public function mount()
    {
        $this->date = now()->toDateString();
    }

    public function submit(): void
    {
        $validated = $this->validate([
            'date' => 'required|date',
            'weight' => 'required|decimal:0,1'
        ]);

        auth()->user()->weights()->upsert($validated, uniqueBy: ['date', 'user_id'], update: ['weight']);

        session()->flash('toast', __('Weight saved'));

        redirect()->route('diaries');
    }
}; ?>

<form wire:submit="submit" class='pt-3'>
  <h3 class='text-lg font-bold'>{{ __('Morning weight') }}</h3>

  <div class='flex flex-col gap-2'>
    <section>
      <input
        type='date'
        class='input input-bordered w-full'
        autoComplete='off'
        wire:model='date'
      />
      <x-input-error :messages="$errors->get('date')" class="mt-2"/>
    </section>

    <section>
      <x-input-field
        type="number"
        step=".1"
        wire:model="weight"
        :errorMessages="$errors->get('weight')"
        label="{{ __('Weight') }}"
        placeholder="{{ __('type weight') }}"
      />
    </section>

    <div class='flex justify-end gap-3 pt-5 modal-action'>
      <button type='submit' class='btn btn-primary'>
        {{ __('Save') }}
      </button>
      <button id='btn' class='btn' wire:click.prevent="cancel">
        {{ __('Cancel') }}
      </button>
    </div>
  </div>
</form>