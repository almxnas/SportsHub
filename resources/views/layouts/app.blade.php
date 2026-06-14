<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SportsHub</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { background: #f0f7f0; font-family: 'Segoe UI', sans-serif; }
        .sport-header { background: #1e3c2c; color: white; }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen">
        @include('layouts.navigation')
        <header class="sport-header py-4 shadow">
            <div class="max-w-7xl mx-auto px-4 text-center">
                <h1 class="text-3xl font-bold">🏸 SportsHub</h1>
                <p>Book your favourite sports facility instantly</p>
            </div>
        </header>
        <main class="py-6">
            <div class="max-w-7xl mx-auto px-4">
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4">{{ session('error') }}</div>
                @endif
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>