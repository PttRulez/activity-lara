<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Validate;
use Illuminate\Validation\Rule;
use App\Models\Food;
use Livewire\Attributes\On;

new class extends Component {
    public ?Food $food = null;

    public string $foodName;
    public string $calories;
    public string $protein;
    public string $fat;
    public string $carbs;

    public function rules(): array
    {
        $foodNameRules = ['required', 'string', 'max:255'];
        if ($this->food) {
            $foodNameRules[] = Rule::unique('foods', 'name')
                ->ignore($this->food->id)
                ->where(function ($query) {
                    return $query->where('user_id', \Auth::id());
                });
        } else {
            $foodNameRules[] = Rule::unique('foods', 'name')->where(function ($query) {
                return $query->where('user_id', auth()->id());
            });
        }

        return [
            'foodName' => $foodNameRules,
            'calories' => ['required', 'integer'],
            'protein' => ['required', 'integer'],
            'fat' => ['required', 'integer'],
            'carbs' => ['required', 'integer'],
        ];
    }

    public function submit(): void
    {
        $validated = $this->validate();

        auth()
            ->user()
            ->foods()
            ->create(
                array_merge($this->except(['foodName']), [
                    'name' => $this->foodName,
                    'created_by_admin' => auth()->user()->isAdmin(),
                ]),
            );

        $this->dispatch('show-toast', 'Еда добавлена');
        $this->dispatch('close-food-modal');
    }

    public function cancel(): void
    {
        $this->dispatch('close-food-modal');
    }
}; ?>

<form wire:submit="submit" class='pt-3'>
  <h3 class='text-lg font-bold'>{{ __('Add food') }}</h3>

  <div class='flex flex-col gap-2'>
    <section>
      <x-input-field wire:model="foodName" :errorMessages="$errors->get('foodName')" label="{{ __('Food Name') }}"
        placeholder="{{ __('type food name') }}" />
    </section>

    <section class='flex justify-between gap-2'>
      <x-input-field wire:model="calories" :errorMessages="$errors->get('calories')"
        label="{{ __('Calories per 100 gram') }}"
        placeholder="{{ __('type calories per 100g') }}" />

      <x-input-field wire:model="protein" :errorMessages="$errors->get('protein')"
        label="{{ __('Proteins per 100 gram') }}"
        placeholder="{{ __('type proteins per 100g') }}" />

    </section>

    <section class='flex justify-between gap-2'>
      <x-input-field wire:model="fat" :errorMessages="$errors->get('fat')"
        label="{{ __('Fats per 100 gram') }}"
        placeholder="{{ __('type fats per 100g') }}" />

      <x-input-field wire:model="carbs" :errorMessages="$errors->get('carbs')"
        label="{{ __('Carbs per 100 gram') }}"
        placeholder="{{ __('type carbs per 100g') }}" />


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
