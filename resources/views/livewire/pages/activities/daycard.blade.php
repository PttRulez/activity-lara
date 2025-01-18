<?php

use Livewire\Volt\Component;
use App\Models\Activity;
use Carbon\Carbon;
use App\Enums\SportType;
use Illuminate\Support\Collection;
use Livewire\Attributes\Reactive;

new class extends Component {
    /**
     * @var Activity[] Array of Activity instances
     */
    #[Reactive]
    public ?Collection $activities;
    public Carbon $date;
    public string $text = "Vasya";

    /**
     * @param Collection<int, Activity> $activities
     */
    public function mount(Carbon $date, ?Collection $activities)
    {
        $this->date = $date;
        $this->activities = $activities;
    }

    public function getCalories(int $sourceId, ?int $calories = null)
    {
        if ($calories > 0) return;
        $this->dispatch('get-calories', $sourceId);
    }
}; ?>

<div class='card bg-base-100 shadow-xl border border-gray-700  min-h-10'>
  <div class='card-body'>
    @if (!$activities || count($activities) === 0)
      <div class='flex'>
        <p>{{ $date->isoFormat("DD.MM") }}</p>
      </div>

    @elseif(count($activities) === 1)
      <div class='flex'>
        <p>{{ $date->isoFormat("DD.MM") }}</p>
        <x-sport-icon
          :calories="$activities[0]->calories"
          sportType="{{ $activities[0]->sport_type }}"
          wire:click="getCalories({{ $activities[0]->source_id }}, {{ $activities[0]->calories }})"
        />
      </div>

      <h2 class='card-title text-ellipsis whitespace-nowrap overflow-hidden inline-block max-w-full'>
        {{ $activities[0]->name }}
      </h2>
      @if($activities[0]->distance > 0)
        <div class='flex justify-between'>
          <span>{{ round($activities[0]->distance / 1000, 2) }} km</span>
          <span>{{ $activities[0]->pace_string }}</span>
        </div>
      @endif
      @isset($activities[0]->calories)
        <span>{{ $activities[0]->calories . " " .  __('kcal') }}</span>
      @endisset

    @elseif(count($activities) > 1)
      <p>{{ $date->isoFormat("DD.MM") }}</p>
      @foreach($activities as $a)
        <div>
          <div class="flex justify-between">
            <x-sport-icon
              calories="{{ $a->calories }}"
              sportType="{{ $a->sport_type }}"
              wire:click="getCalories({{ $a->source_id }}, {{  $activities[0]->calories }})"
            />
            <span>{{ $a->calories }} kcal</span>
          </div>
        </div>
        @if($a->distance > 0)
          <div class='flex justify-between'>
            <span>{{ round($a->distance / 1000, 2) }} km</span>
            <span>{{ $a->pace_string }}</span>
          </div>
        @endif
      @endforeach
    @endif

  </div>
</div>

