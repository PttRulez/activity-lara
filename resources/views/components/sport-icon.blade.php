@use('App\Enums\SportType')

@props([
    'calories' => 0,
    'sportType' => SportType::OTHER->value
])

<div @class([
  "badge badge-outline" => true,
    "hover:-translate-y-0.5 badge-secondary hover:scale-125 transform cursor-pointer" => $calories == 0,
    "badge-primary" => $calories > 0
])
{{ $attributes }}
>
  @switch($sportType)
    @case(SportType::RUN->value)
      <i class="fa-solid fa-person-running"></i>
      @break
    @case(SportType::RIDE->value)
      <i class="fa-solid fa-bicycle"></i>
      @break
    @case(SportType::XC_SKI->value)
      <i class="fa-solid fa-person-skiing-nordic"></i>
      @break
    @default
      <i class="fa-solid fa-dog"></i>
  @endswitch
</div>