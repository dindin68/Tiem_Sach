<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Tiệm Sách') }}</title>
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="{{ asset('storage/uploads/favicon.ico') }}">

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

    @vite('resources/css/app.css')
    @vite('resources/js/app.js')

</head>

<body x-data="{ navOpen: true }" class="flex min-h-screen">



    <!-- Sidebar -->
    <nav x-show="navOpen" x-transition
        class="fixed top-0 left-0 h-screen w-46 bg-orange-50 border-r border-gray-200  z-50">
        <!-- Nút đóng nav trên mobile -->
        <div class="md:hidden flex justify-end p-2">
            <button @click="navOpen = false"
                class="text-green-700 hover:text-red-600 text-xl font-bold focus:outline-none">
                ✕
            </button>
        </div>

        <!-- Nội dung nav -->
        <div class="flex flex-col h-full">
            @include('admin.layouts.navigation')
        </div>
    </nav>

    <!-- Nút mở nav (chỉ hiện khi đang ẩn - mobile) -->
    <button @click="navOpen = true" x-show="!navOpen"
        class="fixed top-4 left-4 z-50 md:hidden bg-orange-100 border border-gray-300 px-2 py-1 rounded shadow">
        ☰
    </button>


    <!-- Nội dung chính -->
    <main class="flex-1 ml-0 md:ml-55 transition-all duration-300 ease-in-out">
        {{-- Flash message và lỗi --}}
        @include('components.message')

        @yield('content')

    </main>

</body>

</html>