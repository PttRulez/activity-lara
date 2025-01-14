<!doctype html>
<html lang="en" data-theme="halloween">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet"/>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
  <div class="container mx-auto">
  <livewire:components.navigation/>
  {{ $slot }}
  </div>
</body>
</html>