@props([
  'autoComplete' => 'off',
  'label' => 'label',
  'required' => false,
  'type' => 'text'
])

<label class='form-control w-full'>
  <div class='label'>
    <span class='label-text'>{{ $label }}</span>
  </div>
  <input
    {{  $attributes->merge([
      'class' => 'input input-bordered w-full'
    ])}}
    type='{{ $type }}'
    class='input input-bordered w-full'
    autoComplete='{{ $autoComplete }}'
    @required($required)
  />
  <x-input-error :messages="$errors->get('form.email')" class="mt-2"/>
</label>