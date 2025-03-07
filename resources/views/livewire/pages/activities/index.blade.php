<?php

use Livewire\Volt\Component;
use App\Services\Strava;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Livewire\Attributes\{Computed, On};
use Livewire\Attributes\Url;

new #[Title('Activities')] class extends Component {
    public string $stravaOAuthLink;
    public iterable $days;

    public function mount(Strava $strava)
    {
        $this->stravaOAuthLink = $strava->getStravaOauthLink();
        $this->getDays();
    }
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
            'month' => $this->currentDate->copy()->subMonth()->month,
            'year' => $this->currentDate->copy()->subMonth()->year,
        ]);
    }

    #[Computed]
    public function nextButtonLink(): null|string
    {
        if ($this->currentDate->isSameMonth(now())) {
            return null;
        } else {
            return route('activities', [
                'month' => $this->currentDate->copy()->addMonth()->month,
                'year' => $this->currentDate->copy()->addMonth()->year,
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

    public function getDays(): void
    {
        $allDates = collect();
        $activities = auth()
            ->user()
            ->activities()
            ->whereBetween('date', [$this->after, $this->before])
            ->get();

        for ($this->currentDate = $this->after->copy(); $this->currentDate <= $this->before; $this->currentDate->addDay()) {
            $data = collect([
                'date' => $this->currentDate->copy(),
                'activities' => $activities->filter(fn($a) => $this->currentDate->isSameDay($a->date))->values(),
            ]);
            $allDates->put($this->currentDate->format('d.m'), $data);
        }

        $this->days = $allDates;
    }

    #[On('get-calories')]
    public function getCaloriesForActivity($id, Strava $strava): void
    {
        $strava->updateActivityWithCalories($id);
    }

    public function syncStrava(Strava $strava): void
    {
        $strava->syncStrava();
        $this->getDays();
    }
}; ?>

<div>
  <div
    class='p-4 text-3xl flex max-md:flex-col-reverse max-md:gap-5 items-center justify-between'>
    <div class='min-w-56 flex justify-between'>
      <a href="{{ $this->prevButtonLink }}" wire:navigate>
        <i class='fa-solid fa-arrow-left cursor-pointer w-8 h-8'></i>
      </a>
      <span>{{ $this->currentDate->monthName }}</span>

      @if ($this->nextButtonLink)
        <a href="{{ $this->nextButtonLink }}" wire:navigate>
          <i class='fa-solid fa-arrow-right cursor-pointer'></i>
        </a>
      @endif
    </div>
    <div>
      @if (auth()->user()->stravaInfo)
        <x-button class='btn-primary' wire:click="syncStrava" spinner="syncStrava">
          {{ __('Sync Strava') }}
        </x-button>
      @else()
        <a href='{{ $stravaOAuthLink }}' class='btn btn-primary'>
          {{ __('Bind Strava') }}
        </a>
      @endif
    </div>
  </div>
  {{-- Desktop version --}}
  <div class='grid grid-cols-7 gap-4 max-md:hidden'>
    @foreach ($this->days as $date => $day)
      <livewire:pages.activities.daycard :date="$day->get('date')" :activities="$day->get('activities')"
        wire:key="{{ $date . Str::random(16) }}" />
    @endforeach
  </div>
  {{-- End Desktop version --}}

  {{-- Mobile version --}}
  <div class='flex flex-col-reverse gap-5 md:hidden'>
    @foreach ($this->days as $key => $day)
      <livewire:pages.activities.daycard :date="$day->get('date')" :activities="$day->get('activities')"
        wire:key="{{ $key . Str::random(16) }}" />
    @endforeach
  </div>
  {{-- End Mobile version --}}
</div>
