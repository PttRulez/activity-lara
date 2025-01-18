<?php

use Livewire\Volt\Component;

new class extends Component {
    public string $sportType = \App\Enums\SportType::OTHER->value;
    public int $calories = 0;
}; ?>

<div @class([
  "badge badge-outline" => true,
    "hover:-translate-y-0.5 badge-secondary hover:scale-125 transform cursor-pointer" => $calories === 0,
    "badge-primary" => $calories > 0
])>
  @switch($sportType)
    @case('STRun')
      <i class="fa-solid fa-person-running"></i>
      @break
    @case('STRide')
      <i class="fa-solid fa-bicycle"></i>
      @break
    @case('STXCSki')
      <i class="fa-solid fa-person-skiing-nordic"></i>
      @break
    @default
      <i class="fa-solid fa-dog"></i>
  @endswitch
</div>
