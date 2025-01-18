@props([
  'autoComplete' => 'off',
  'label' => 'label',
  'required' => false,
  'type' => 'text',
  'errorMessages' => [],
  'step' => ".1"
])

<label {{ $attributes->merge(['class' => 'form-control w-full']) }}>
  <div class='label'>
    <span class='label-text'>{{ $label }}</span>
  </div>
  <input class="input input-bordered w-full"
   type='{{ $type }}'
   @isset($step)
     step="{{ $step }}"
   @endif
   class='input input-bordered w-full'
   autoComplete='{{ $autoComplete }}'
    @required($required)
  />
  <x-input-error :messages="$errorMessages" class="mt-2"/>
</label>