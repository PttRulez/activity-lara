<?php

use Livewire\Volt\Component;

new class extends Component {
    public string $date;
    public float $steps;

    public function mount()
    {
        $this->date = now()->toDateString();
    }

    public function submit(): void
    {
        $validated = $this->validate([
            'date' => 'required|date',
            'steps' => 'required|int'
        ]);

        auth()->user()->steps()->upsert($validated, uniqueBy: ['date', 'user_id'], update: ['steps']);

        redirect()->route('diaries');

        session()->flash('toast', __('Steps saved'));
    }
}; ?>

<form wire:submit="submit" class='pt-3'>
  <h3 class='text-lg font-bold'>{{ __('Add steps') }}</h3>

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
        wire:model="steps"
        :errorMessages="$errors->get('steps')"
        label="{{ __('Steps') }}"
        placeholder="{{ __('type steps') }}"
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