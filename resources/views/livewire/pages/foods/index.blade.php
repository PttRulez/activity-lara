<?php

use Livewire\Volt\Component;

new class extends Component {
    public iterable $days = [];
    public bool $foodModalOpen = false;

    public function mount(): void
    {
        $this->days = auth()
            ->user()
            ->meals()
            ->with('foods')
            ->orderByDesc('date')
            ->get()
            ->groupBy('date')
            ->map(function ($groupedMeals, $date) {
                return [
                    'date' => \Carbon\Carbon::parse($date),
                    'meals' => $groupedMeals,
                ];
            });
    }
}; ?>

<div class='p-4' x-data="foodIndex" @close-meal-modal="mealModalOpen = false;"
  @close-food-modal="foodModalOpen = false;">
  <section class='text-3xl flex flex-wrap justify-end gap-4'>
    <button class='btn btn-secondary' @click="mealModalOpen=true">
      {{ __('pages/foods.Add Meal') }}
    </button>
    <button class='btn btn-secondary' @click="foodModalOpen=true">
      {{ __('pages/foods.Add Food') }}
    </button>
  </section>


  <section class='mt-8'>
    @foreach ($days as $day)
      <div class='mb-8'>
        <p>
          {{ $day['date']->translatedFormat('j F') }} -
          <span>{{ $day['meals']->reduce(fn($acc, $meal) => $meal->calories + $acc, 0) }}</span>
        </p>

        <div class='divider'></div>

        @foreach ($day['meals'] as $meal)
          <div class='collapse bg-base-200 mb-4'>
            <input type='checkbox' />
            <div class='collapse-title  font-medium'>
              {{ $meal->name . ' - ' . $meal->calories }}
            </div>
            <div class='collapse-content'>
              @foreach ($meal->foods as $food)
                <div class='text-sm'>
                  {{ $food->name }} - {{ $food->weight }} {{ __('g') }} - {{ $food->calories }}
                  {{ __('pages/foods.calories') }}
                </div>
              @endforeach
            </div>
          </div>
        @endforeach
      </div>
    @endforeach
  </section>


  <dialog class="modal  overflow-auto" :open="mealModalOpen" x-show="mealModalOpen">
    <div class="modal-box overflow-auto " @click.outside="mealModalOpen = false">
      <livewire:pages.foods.meal-form />
    </div>
  </dialog>

  <dialog class="modal" :open="foodModalOpen" x-show="foodModalOpen">
    <div class="modal-box" @click.outside="foodModalOpen = false">
      <livewire:pages.foods.food-form />
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
