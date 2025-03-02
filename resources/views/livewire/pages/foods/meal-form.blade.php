<?php

use Illuminate\Support\Collection;
use Livewire\Volt\Component;
use App\Models\Meal;
use App\Models\FoodInMeal;
use Carbon\Carbon;
use Livewire\Attributes\Computed;

const EMPTY_FOOD = ['calories' => 0, 'calories_per_100' => 0, 'name' => '', 'weight' => 0];

new class extends Component {
    public ?Meal $meal = null;

    public iterable $foods = [];
    public string $date;
    public string $name = 'Обед';
    public int $calories = 0;

    public function minus()
    {
        $this->food = [];
    }

    public function mount(): void
    {
        $this->date = Carbon::now()->toDateString();
    }

    public function add(): void
    {
        $this->foods[] = EMPTY_FOOD;
    }

    public function cancel(): void
    {
        $this->dispatch('close-meal-modal');
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'calories' => ['required', 'integer'],
            'date' => ['required', 'date'],
            'foods' => ['required', 'array'],
            'foods.*.calories' => ['required', 'integer'],
            'foods.*.calories_per_100' => ['required', 'integer', 'gt:0'],
            'foods.*.name' => ['required', 'string', 'max:255'],
            'foods.*.weight' => ['required', 'integer', 'gt:0'],
        ];
    }

    public function submit(): void
    {
        $v = $this->validate();
        DB::transaction(function () use ($v) {
            $meal = auth()
                ->user()
                ->meals()
                ->create([
                    'name' => $v['name'],
                    'calories' => $v['calories'],
                    'date' => $v['date'],
                ]);

            $foodsInMeal = [];
            foreach ($v['foods'] as $food) {
                $foodsInMeal[] = array_merge($food, [
                    'meal_id' => $meal->id,
                ]);
            }
            FoodInMeal::insert($foodsInMeal);
        });

        // $this->date = Carbon::now()->toDateString();
        // $this->foods = [];
        // $this->dispatch('close-meal-modal');
        // $this->dispatch('meal-added');
    }
}; ?>


<form wire:submit="submit" class='pt-3' x-data="mealform">
  <h3 class='text-lg font-bold'>{{ __('New Meal') }}</h3>

  <div class='flex flex-col gap-2'>
    <section class='flex justify-between gap-3 items-center'>
      <label class="form-control w-full flex-1">
        <div class='label'>
          <span class='label-text'>{{ __('Name') }}</span>
        </div>
        <input class="input input-bordered w-full" type='text' wire:model="name"
          autoComplete='off' />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
      </label>
      <div class="flex-1 text-right" x-text="`${totalCalories} калорий`"></div>
    </section>

    <section>
      <input type='date' class='input input-bordered w-full' autoComplete='off'
        x-model='date' />
      <x-input-error :messages="$errors->get('date')" class="mt-2" />
    </section>

    <div class='label grid grid-cols-[3fr_1fr_1fr_1fr] gap-2 text-xs text-center'>
      <span class='label-text'>{{ __('pages/foods.mealform.whateat') }}</span>
      <span class='label-text'>{{ __('pages/foods.mealform.weight') }}</span>
      <span class='label-text'>{{ __('pages/foods.mealform.kcal_100') }}</span>
      <span class='label-text'>{{ __('pages/foods.mealform.kcal') }}</span>
    </div>

    @foreach ($this->foods as $food)
      <div class="grid grid-cols-[3fr_1fr_1fr_1fr] gap-2 mb-2" wire:key="$loop->index"
        x-on:food-chosen="handleFoodChosen($event, {{ $loop->index }})"
        x-on:food-name-input="handleFoodNameInput($event, {{ $loop->index }})">
        <livewire:components.food-search :key="'food-search' . $loop->index" />
        <input type='number' placeholder='0 г'
          class='input input-bordered w-full hide-number-arrows max-md:px-2'
          wire:model.number="foods.{{ $loop->index }}.weight"
          @keyup="handleFoodDataChanged({{ $loop->index }})" />
        <input type='number'
          class='input input-bordered w-full hide-number-arrows max-md:px-2'
          wire:model.number="foods.{{ $loop->index }}.calories_per_100"
          @keyup="handleFoodDataChanged({{ $loop->index }})" />
        <input type='number'
          class='input input-bordered w-full hide-number-arrows max-md:px-2'
          wire:model.number="foods.{{ $loop->index }}.calories" disabled />
      </div>
      <x-input-error :messages="$errors->get('foods.' . $loop->index . '.name')" />
      <x-input-error :messages="$errors->get('foods.' . $loop->index . '.weight')" />
      <x-input-error :messages="$errors->get('foods.' . $loop->index . '.calories_per_100')" />
    @endforeach
  </div>

  <x-input-error :messages="$errors->get('foods')" />

  <div class='flex justify-between gap-3 pt-5'>
    <div class='btn  btn-outline ml-1 cursor-pointer' wire:click="add">
      +
    </div>
    <div>
      <button type='submit' class='btn btn-primary'>
        {{ __('Save') }}
      </button>
      <button id='btn' class='btn'
        @click.prevent="$dispatch('close-meal-modal')">
        {{ __('Cancel') }}
      </button>
    </div>
  </div>
</form>


@script
  <script>
    Alpine.data('mealform', () => ({
      date: $wire.entangle('date'),
      calories: $wire.entangle('calories'),
      foods: $wire.entangle('foods'),
      name: $wire.entangle('name'),

      get totalCalories() {
        let c = this.foods.reduce((acc, item) => acc + item.calories, 0);
        this.calories = c;
        return c;
      },

      //                                    HANDLERS

      handleFoodDataChanged(i) {
        let food = this.foods[i];
        food.calories = Math.floor((food.weight * food.calories_per_100) / 100);
      },
      handleFoodNameInput(e, i) {
        this.foods[i].name = e.detail[0];
      },
      handleFoodChosen(e, i) {
        let f = e.detail;
        this.foods[i] = {
          calories_per_100: f.calories,
          name: f.name,
          weight: 0,
          calories: 0,
        }
      },
    }));
  </script>
@endscript
