<!DOCTYPE html>
<html>
<head>
    <title>Admin - Tiệm Sách</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100">
    <nav class="bg-blue-600 text-white p-4">
        <div class="container mx-auto flex justify-between">
            <div>
                <a href="{{ route('admin.dashboard') }}" class="mr-4">Dashboard</a>
                <a href="{{ route('admin.books.index') }}" class="mr-4">Sách</a>
                <a href="{{ route('admin.orders.index') }}">Đơn hàng</a>
            </div>
            @auth('admin')
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-white">Đăng xuất</button>
                </form>
            @endauth
        </div>
    </nav>
    <div class="container mx-auto p-4">
        @yield('content')
    </div>
</body>
</html>