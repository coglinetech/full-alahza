<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Al-Ahza - Jasa Travel Umroh Terpercaya')</title>
    <meta name="description" content="@yield('description', 'Al-Ahza melayani paket umroh reguler dan umroh plus dengan pelayanan amanah dan harga transparan. Berizin resmi Kemenag RI.')">

    <!-- Open Graph -->
    <meta property="og:title" content="Al-Ahza - Travel Umroh Terpercaya">
    <meta property="og:description" content="Melayani ibadah Umroh dengan amanah sejak 2014. Berizin resmi Kemenag RI.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Plus+Jakarta+Sans:wght@400;500;600&family=Amiri:wght@400;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body class="font-sans text-primary bg-warm-white antialiased">

    @include('partials.navbar')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')

    @stack('scripts')
</body>
</html>