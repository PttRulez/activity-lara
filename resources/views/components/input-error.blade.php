@props(['messages'])

@if ($messages)
    <ul {{ $attributes->merge(['class' => 'text-sm text-red-600 space-y-1']) }}>
        @foreach ((array) $messages as $message)
            <li><div className='label'>
              <span className='label-text-alt text-error'>
                {{ $message }}
              </span>
        </div></li>
        @endforeach
    </ul>
@endif
