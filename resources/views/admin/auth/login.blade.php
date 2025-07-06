<!DOCTYPE html>
<html>
    <head>
        <title>Đăng nhập Admin - Tiệm Sách</title>
        @vite('resources/css/app.css')
    </head>

    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-row sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div>
                <a href="/">
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                <h1 class="text-2xl font-bold text-center text-brown-800 mb-4">Đăng nhập Admin</h1>
                @if ($errors->any())
                    <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif
                <form method="POST" action="{{ route('admin.login') }}">
                    @csrf
                    <div class="mb-4">
                        <label for="email" class="block text-gray-700">Email</label>
                        <input type="email" name="email" id="email" class="w-full p-2 border rounded" required>
                    </div>
                    <div class="mb-4">
                        <label for="password" class="block text-gray-700">Mật khẩu</label>
                        <input type="password" name="password" id="password" class="w-full p-2 border rounded" required>
                    </div>
                    
                    <div class="flex justify-end">
                        <x-primary-button class="ms-3 bg-green-800">
                        {{ __('Log in') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
            
        </div>
    </body>
</html>