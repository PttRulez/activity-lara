<?php

use Livewire\Volt\Component;
use Carbon\Carbon;
use App\Services\Diary as DiaryService;

new class extends Component {
    public iterable $weeks;

    public function mount(DiaryService $diaryService): void
    {
        $now = Carbon::now();
        $before = $now->copy()->endOfWeek();
        $after = $now->copy()->subWeeks(3)->startOfWeek();
        $this->weeks = $diaryService->getDiaries($after, $before);
    }
}; ?>


<div class='p-4' x-data="diariesIndex">
  <section class='text-3xl flex justify-end gap-4'>
    <button class='btn btn-secondary' @click="stepsModalOpen=true">
      {{ __('pages/diaries.Add Steps') }}
    </button>

    <button class='btn btn-secondary' @click="weightModalOpen=true">
      {{ __('pages/diaries.Add Weight') }}
    </button>
  </section>
  <section class='mt-14 md:block'>
    @foreach ($weeks as $weekIndex => $week)
      <div class='flex max-md:flex-col-reverse gap-3'>
        <ul
          class='timeline max-md:timeline-vertical max-md:flex-col-reverse justify-between w-full mb-10 md:mb-20 flex-auto'>
          @foreach ($week['days'] as $index => $day)
            <li class='grow' key={date}>
              @if ($index > 0)
                <hr class='grow' />
              @endif
              <div @class([
                  'tooltip timeline-start border-2  rounded p-2' => true,
                  'border-green-500' => $day['caloriesBalance'] <= 0,
                  'border-red-500' => $day['caloriesBalance'] > 0,
              ])
                data-tip="{{ $day['caloriesConsumed'] }} - {{ auth()->user()->bmr }} - {{ $day['caloriesBurnedInActivities'] }} - {{ $day['caloriesBurnedBySteps'] }} ({{ $day['steps'] }})">
                {{ $day['caloriesBalance'] }}
              </div>
              <div class='timeline-middle tooltip' data-tip={{ $day['date'] }}>
                <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20'
                  fill='currentColor' class='h-5 w-5 '>
                  <path fillRule='evenodd'
                    d='M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z'
                    clipRule='evenodd' />
                </svg>
              </div>
              @isset($day['weight'])
                <div class='timeline-end timeline-box'>{{ $day['weight'] }}</div>
              @endisset
              @if ($index < 6)
                <hr />
              @endif
            </li>
          @endforeach
        </ul>
        <div class='text-center'>
          <div @class([
              'stat-value' => true,
              'text-green-500' =>
                  $weekIndex < count($weeks) - 1 &&
                  $week['weight'] - $weeks[$weekIndex + 1]['weight'] <= 0.2,
              'text-red-500' =>
                  $weekIndex < count($weeks) - 1 &&
                  $week['weight'] - $weeks[$weekIndex + 1]['weight'] > 0.2,
          ])>
            @isset($week['weight'])
              {{ $week['weight'] }}
            @endisset
          </div>
        </div>
      </div>
    @endforeach
  </section>

  <dialog class="modal" :open="stepsModalOpen" x-show="stepsModalOpen">
    <div class="modal-box" @click.outside="stepsModalOpen = false">
      <livewire:components.steps-form />
    </div>
  </dialog>

  <dialog class="modal" :open="weightModalOpen" x-show="weightModalOpen">
    <div class="modal-box" @click.outside="weightModalOpen = false">
      <livewire:components.weights-form />
    </div>
  </dialog>

</div>

@script
  <script>
    Alpine.data('diariesIndex', () => ({
      stepsModalOpen: false,
      weightModalOpen: false,
      toastText: '',
      showToast: false,
    }))
  </script>
@endscript
