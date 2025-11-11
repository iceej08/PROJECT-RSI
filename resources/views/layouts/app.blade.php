<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'UB Sport Center')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-pattern">
    @yield('content')

    <style>
        .bg-pattern {
            background-image:
                url("/images/pattern.svg"),
                linear-gradient(to bottom right, #004369, #002E48, #002E48, #004369);
            background-repeat: no-repeat, no-repeat;
            background-size: cover;
        }
    </style>
</body>
</html>