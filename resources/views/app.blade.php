<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title inertia>{{ config('app.name', 'Laravel') }}</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

  @routes

  {{-- Dacă ai path-uri (ex: /istoric), poți, opțional, să le faci absolute aici --}}
  @php
    $footer = config('footer');
    foreach ($footer['columns'] as &$col) {
      foreach ($col['links'] as &$link) {
        if (!($link['external'] ?? false)) {
          $link['url'] = url($link['url']); // ex: '/istoric' -> 'http://127.0.0.1:8000/istoric'
        }
      }
    }
  @endphp
  <script>
    window.footerData = @json($footer);
  </script>

  @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
  @inertiaHead
</head>
<body class="font-sans antialiased">
  @inertia
</body>
</html>
