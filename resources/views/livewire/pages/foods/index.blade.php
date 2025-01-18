<?php

use JetBrains\PhpStorm\NoReturn;
use Livewire\Volt\Component;
use Livewire\Attributes\On;
use App\Models\Meal;

new class extends Component {
    public iterable $days = [];
    public bool $foodModalOpen = false;

    public function mount(): void
    {
        $this->days = auth()->user()->meals()->with('foods')->get()->groupBy('date')
            ->map(function ($groupedMeals, $date) {
                return [
                    'date' => \Carbon\Carbon::parse($date),
                    'meals' => $groupedMeals
                ];
            });
    }

}; ?>

<div class='p-4'
     x-data="foodIndex"

     x-init="
  window.addEventListener('close-meal-modal', () => {
    mealModalOpen = false;
  });

  window.addEventListener('close-food-modal', () => {
    foodModalOpen = false;
  });
  "
>
  <section class='text-3xl flex justify-end gap-4'>
    <button
      class='btn btn-secondary'
      @click="mealModalOpen=true"
    >
      Add Meal
    </button>
    <button
      class='btn btn-secondary'
      @click="foodModalOpen=true"
    >
      Add Food
    </button>
  </section>


  <section>
    @foreach($days as $day)

      <div class='mb-8'>
        <p>
          {{ $day['date']->translatedFormat('j F') }} -
          <span>{{ $day['meals']->reduce(fn($acc, $meal) => $meal->calories + $acc, 0) }}</span>
        </p>

        <div class='divider'></div>

        @foreach($day['meals'] as $meal)
          <div class='collapse bg-base-200 mb-4'>
            <input type='checkbox'/>
            <div class='collapse-title  font-medium'>
              {{ $meal->name . ' - ' . $meal->calories }}
            </div>
            <div class='collapse-content'>
              @foreach($meal->foods as $food)
                <div class='text-sm'>
                  {{ $food->name }} - {{ $food->weight }} {{ __('g') }} - {{ $food->calories }} {{ __('pages/foods.calories') }}
                </div>
              @endforeach
            </div>
          </div>
        @endforeach
      </div>
    @endforeach
  </section>

  <dialog class="modal" open x-show="mealModalOpen">
    <div class="modal-box overflow-visible" @click.outside="mealModalOpen = false">
      <livewire:pages.foods.meal-form/>
    </div>
  </dialog>

  <dialog class="modal" open x-show="foodModalOpen" >
    <div class="modal-box"  @click.outside="foodModalOpen = false">
      <livewire:pages.foods.food-form/>
    </div>
  </dialog>



</div>

@script
<script>
	Alpine.data('foodIndex', () => ({
		foodModalOpen: false,
		mealModalOpen: false,
		toastText: 'asd',
		showToast: false,
	}))
</script>
@endscript