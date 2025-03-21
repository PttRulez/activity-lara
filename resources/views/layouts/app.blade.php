<!doctype html>
<html lang="en" data-theme="halloween" class="overflow-auto">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" href="{{ Vite::asset('resources/static/favicon.ico') }}" type="image/x-icon" />
  </head>

  <body class="pb-10 container mx-auto">
    <livewire:components.navigation />

    <div class="divider m-0"></div>

    <main class="max-md:px-4">

      {{ $slot }}

      <x-toast />
    </main>
  </body>

</html>
