<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Title;
use App\Services\Strava;
use Livewire\Attributes\Layout;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Livewire\Attributes\{Computed, On};
use App\Models\Activity;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Url;

new
#[Layout('layouts.app')]
#[Title('Activities')]
class extends Component {
    #[Url]
    public $month = null;

    #[Url]
    public $year = null;

    #[Computed]
    public function currentDate()
    {
        if (!$this->year || !$this->month) {
            return now();
        } else {
            return Carbon::create($this->year, $this->month, 2);
        }
    }

    #[Computed]
    public function prevButtonLink(): string
    {
        return route('activities', [
            'month' => $this->currentDate->copy()->subMonth()->month, 'year' => $this->currentDate->copy()->subMonth()->year,
        ]);
    }

    #[Computed]
    public function nextButtonLink(): null|string
    {
        if ($this->currentDate->isSameMonth(now())) {
            return null;
        } else {
            return route('activities', [
                'month' => $this->currentDate->copy()->addMonth()->month, 'year' => $this->currentDate->copy()->addMonth()->year,
            ]);
        }
    }


    #[Computed]
    public function after()
    {
        return $this->currentDate->copy()->startOfMonth()->startOfWeek();
    }

    #[Computed]
    public function before()
    {
        return $this->currentDate->copy()->endOfMonth()->endOfWeek();
    }

    #[Computed]
    public function days(): Collection
    {
        $allDates = collect();
        $activities = Activity::whereBetween('date', [$this->after, $this->before])->get();
        Log::debug('$activities count: ' . $activities->count());

        for ($this->currentDate = $this->after->copy(); $this->currentDate <= $this->before; $this->currentDate->addDay()) {
            $data = collect([
                'date' => $this->currentDate->copy(),
                'activities' => $activities->filter(fn($a) => $this->currentDate->isSameDay($a->date))->values(),
            ]);
            $allDates->put($this->currentDate->format('d.m'), $data);
        }

        return $allDates;
    }

    #[On('get-calories')]
    public function getCaloriesForActivity($id, Strava $strava): void
    {
        $strava->updateActivityWithCalories($id);
    }

    public function syncStrava(Strava $strava): void
    {
        $strava->syncStrava();
    }
}; ?>

<div>

  <div class='p-4 text-3xl flex justify-between'>
    <div class='min-w-56 flex justify-between'>
      <a href="{{ $this->prevButtonLink }}" wire:navigate>
        <i class='fa-solid fa-arrow-left cursor-pointer w-8 h-8'></i>
      </a>
      <span>{{ $this->currentDate->locale('ru')->monthName }}</span>

      @if($this->nextButtonLink)
        <a href="{{ $this->nextButtonLink }}"  wire:navigate>
          <i class='fa-solid fa-arrow-right cursor-pointer'></i>
        </a>
      @endif
    </div>
    <div>
      <button
        class='btn btn-primary'
        wire:click="syncStrava"
      >
        Sync Strava
        <svg
          class='animate-spin -ml-1 mr-3 h-5 w-5 text-black'
          xmlns='http://www.w3.org/2000/svg'
          fill='none'
          viewBox='0 0 24 24'
          wire:loading wire:target="syncStrava"
        >
          <circle
            class='opacity-25'
            cx='12'
            cy='12'
            r='10'
            stroke='currentColor'
            stroke-width='4'
          ></circle>
          <path
            class='opacity-75'
            fill='currentColor'
            d='M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z'
          ></path>
        </svg>
      </button>
    </div>
  </div>
  <div class='grid grid-cols-7 gap-4'>
    @foreach($this->days as $key => $day)
      <livewire:activities.daycard :date="$day->get('date')" :activities="$day->get('activities')"
                                   wire:key="{{ $key }}"/>
    @endforeach
  </div>
</div>
