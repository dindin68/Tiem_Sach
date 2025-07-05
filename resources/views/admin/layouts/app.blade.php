<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">
    @vite('resources/css/app.css')

</head>
<body class="font-sans antialiased h-screen">


    <div class="flex h-full bg-white">
        <div class="w-48 border-r">
            @include('admin.layouts.navigation')
        </div>
        <div class="flex-1 bg-white overflow-y-auto">
            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            @yield('content')
        </div>
    </div>

</body>
</html>