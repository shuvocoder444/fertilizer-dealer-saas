<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'সার ডিলার SaaS — বাংলাদেশ এগ্রো ম্যানেজমেন্ট প্ল্যাটফর্ম')</title>

    <!-- Google Fonts: Hind Siliguri for authentic, human Bangla typography -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body, html {
            font-family: 'Hind Siliguri', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            scroll-behavior: smooth;
        }
    </style>
</head>
<body class="bg-slate-50 antialiased min-h-screen flex flex-col justify-between selection:bg-emerald-500 selection:text-white text-slate-800">

    <!-- Header Include -->
    @include('layouts.frontend-header')

    <!-- Main Content -->
    <main id="main-content" class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer Include -->
    @include('layouts.frontend-footer')

</body>
</html>
