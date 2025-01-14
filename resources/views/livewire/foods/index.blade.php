<?php

use JetBrains\PhpStorm\NoReturn;
use Livewire\Volt\Component;
use Livewire\Attributes\On;

new class extends Component {
    public array $days = [];

    #[On('close-food-form')]
    public function closeFoodModal(): void
    {
        $this->dispatch('close-food-modal');;
    }
    #[On('close-meal-form')]
    public function closeMealModal(): void
    {
        $this->dispatch('close-meal-modal');;
    }
}; ?>

<div class='p-4' x-data="{foodModalOpen: false, mealModalOpen: false}" x-init="
    window.addEventListener('close-meal-modal', () => {
        mealModalOpen = false;
    });
    window.addEventListener('close-food-modal', () => {
        foodModalOpen = false;
    });
">
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

      <div class='mb-8' key={d.date.toString()}>
        <p>
          {new Date(d.date).toLocaleString("Ru-ru", {
          month: "numeric",
          day: "numeric",
          })}{" "}
          -{" "}
          <span>{d.meals.reduce((acc, cur) => cur.calories + acc, 0)}</span>
        </p>

        <div class='divider'></div>

        {d.meals.map((m) => (
        <div class='collapse bg-base-200 mb-4' key={m.id + m.name}>
          <input type='checkbox'/>
          <div class='collapse-title  font-medium'>
            {`${m.name} - ${m.calories}`}
          </div>
          <div class='collapse-content'>
            {m.foods.map((f) => (
            <div class='text-sm' key={f.name + m.id}>
              {`${f.name} - ${f.weight} г - ${f.calories} калорий`}
            </div>
            ))}
          </div>
        </div>
        ))}
      </div>s
    @endforeach
  </section>

  <dialog class="modal"  open x-show="mealModalOpen">
    <div class="modal-box" @click.outside="mealModalOpen = false">
      <livewire:foods.meal-form />
    </div>
  </dialog>

  <dialog class="modal"  open x-show="foodModalOpen">
    <div class="modal-box" @click.outside="foodModalOpen = false">
      <livewire:foods.food-form />
    </div>
  </dialog>

</div>
