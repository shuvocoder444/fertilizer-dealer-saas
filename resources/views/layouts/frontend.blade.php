<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'FertilizerSaaS')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- HTMX CDN -->
    <script src="https://unpkg.com/htmx.org@1.9.10"></script>
</head>
<body class="bg-slate-50 font-sans antialiased min-h-screen flex flex-col justify-between">

    <!-- Header Include -->
    @include('layouts.frontend-header')

    <!-- HTMX Dynamic Target Container -->
    <main id="main-content" class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer Include -->
    @include('layouts.frontend-footer')

</body>
</html>
