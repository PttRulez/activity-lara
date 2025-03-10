<?php

use Livewire\Volt\Component;
use App\Models\Food;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Attributes\Modelable;

new class extends Component {
    #[Modelable]
    public string $foodName;
    
    public iterable $results = [];

    public function updatedFoodName($value): void
    {
        if (empty($value)) {
            $this->results = [];
        } else {
            $this->results = Food::where('name', 'ILIKE', '%' . $value . '%')
                ->get()
                ->toArray();
        }

        $this->dispatch('food-name-input', $value);
    }
}; ?>


<div x-data="foodsearch"
  :class="{
      'dropdown': true,
      'dropdown-open': results?.length > 0
  }">
  <input  type="text" class="input input-bordered w-full  max-md:px-2" autoComplete='off'
    wire:model.live.debounce.400ms="foodName" tabIndex="0">
  <ul class='dropdown-content menu  bg-base-200 flex-col rounded-md w-full z-10'
    wire:transition.opacity wire:transition.duration.300 tabindex="0"
    x-show="results?.length > 0" @click.outside="results = []">
    <template x-for="(food, index) in results">
      <li :key="food.name + index" tabindex="0" @click="handleChooseFood(food)"
        class='border-b border-b-base-content/10 w-full cursor-pointer'>
        <span x-text="food.name"></span>
      </li>
    </template>
  </ul>
</div>

@script
  <script>
    Alpine.data('foodsearch', () => ({
      foodName: $wire.entangle('foodName'),
      results: $wire.entangle('results'),

      handleChooseFood(f) {
        this.foodName = f.name;
        this.$dispatch('food-chosen', f);
        this.results = [];
      },
    }));
  </script>
@endscript
