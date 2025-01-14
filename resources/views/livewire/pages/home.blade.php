<?php

use Livewire\Volt\Component;
use App\Models\StravaInfo;
use App\Models\User;
use App\Services\Strava;

new class extends Component {
    public User $user;
    public string $stravaOAuthLink;

    public function mount(Strava $strava)
    {
        $this->user = auth()->user();
        $this->stravaOAuthLink = $strava->getStravaOauthLink();
    }


}; ?>

<div>
  @if(auth()->user()->stravaInfo)
    <div class="text-center">
      <h1 class="text-2xl mt-10 mb-10">Приветствуем вас, {{ $user->name }}</h1>
    </div>
  @else()
    <div class="text-center">
      <h1 class="text-2xl mt-10 mb-10">Здарова, атлет. Чтобы посмотреть свои активности, необходимо
        законнектить сраву</h1>
      <a
        href='{{ $stravaOAuthLink }}'
        class='btn btn-primary'
      >
        Ваши активити
      </a>
    </div>
  @endif
</div>
