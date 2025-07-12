@php
    $isPromoActive = request()->routeIs('admin.promotions.*');
    $isActive = request()->routeIs('admin.promotions.*');
    $classes = $isActive
        ? 'block w-full ps-3 pe-4 py-2 border-l-4 bg-green-50 text-brown-800 text-start text-base font-medium border-green-700 focus:outline-none focus:text-indigo-800 focus:bg-indigo-100 focus:border-orange-900 transition duration-150 ease-in-out'
        : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base text-brown-800 font-medium hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out';
@endphp
<nav x-data="{ open: false }" class="top-0 left-0 bg-orange-50 h-screen w-45 border-r border-gray-200 transition-transform duration-300 ease-in-out z-50">
    <div class="flex flex-col h-full">
        <!-- Logo -->
        <div class="border-b border-gray-200 w-48">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center">
                <x-application-logo class="h-8 w-auto fill-current text-green-600" />
            </a>
        </div>

        <!-- Menu Items -->
        <div class="p-4 border-b border-gray-200 w-48 overflow-y-auto no-scrollbar">
            <ul class="space-y-2">
                <!-- Trang chủ -->
                <li>
                    <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                        <span class="flex items-center text-green-800">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill="#166534" d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                            </svg>
                            {{ __('Trang Chủ') }}
                        </span>
                    </x-responsive-nav-link>
                </li>

                <!-- Sách -->
                <li>
                    <x-responsive-nav-link :href="route('admin.books.index')" :active="request()->routeIs('admin.books.*')">
                        <span class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 448 512">
                                <path fill="#553a25" d="M96 0C43 0 0 43 0 96L0 416c0 53 43 96 96 96l288 0 32 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l0-64c17.7 0 32-14.3 32-32l0-320c0-17.7-14.3-32-32-32L384 0 96 0zm0 384l256 0 0 64L96 448c-17.7 0-32-14.3-32-32s14.3-32 32-32zm32-240c0-8.8 7.2-16 16-16l192 0c8.8 0 16 7.2 16 16s-7.2 16-16 16l-192 0c-8.8 0-16-7.2-16-16zm16 48l192 0c8.8 0 16 7.2 16 16s-7.2 16-16 16l-192 0c-8.8 0-16-7.2-16-16s7.2-16 16-16z"/>
                            </svg>
                            {{ __('Sách') }}
                        </span>
                    </x-responsive-nav-link>
                </li>

                <!-- Categories -->
                <li>
                    <x-responsive-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.*')">
                        <span class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" viewBox="0 0 512 512">
                                <path fill="#553a25" d="M40 48C26.7 48 16 58.7 16 72l0 48c0 13.3 10.7 24 24 24l48 0c13.3 0 24-10.7 24-24l0-48c0-13.3-10.7-24-24-24L40 48zM192 64c-17.7 0-32 14.3-32 32s14.3 32 32 32l288 0c17.7 0 32-14.3 32-32s-14.3-32-32-32L192 64zm0 160c-17.7 0-32 14.3-32 32s14.3 32 32 32l288 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-288 0zm0 160c-17.7 0-32 14.3-32 32s14.3 32 32 32l288 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-288 0zM16 232l0 48c0 13.3 10.7 24 24 24l48 0c13.3 0 24-10.7 24-24l0-48c0-13.3-10.7-24-24-24l-48 0c-13.3 0-24 10.7-24 24zM40 368c-13.3 0-24 10.7-24 24l0 48c0 13.3 10.7 24 24 24l48 0c13.3 0 24-10.7 24-24l0-48c0-13.3-10.7-24-24-24l-48 0z"/>
                            </svg>
                            {{ __('Thể Loại') }}
                        </span>
                    </x-responsive-nav-link>
                </li>
                <!-- Promotions -->
                <li>
                    <x-responsive-nav-link :href="route('admin.promotions.index')" :active="request()->routeIs('admin.promotions.*')">
                        <span class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" 
                                class="w-5 h-5 mr-2"
                                viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                                <path fill="#553a25" d="M345 39.1L472.8 168.4c52.4 53 52.4 138.2 0 191.2L360.8 472.9c-9.3 9.4-24.5 9.5-33.9 .2s-9.5-24.5-.2-33.9L438.6 325.9c33.9-34.3 33.9-89.4 0-123.7L310.9 72.9c-9.3-9.4-9.2-24.6 .2-33.9s24.6-9.2 33.9 .2zM0 229.5L0 80C0 53.5 21.5 32 48 32l149.5 0c17 0 33.3 6.7 45.3 18.7l168 168c25 25 25 65.5 0 90.5L277.3 442.7c-25 25-65.5 25-90.5 0l-168-168C6.7 262.7 0 246.5 0 229.5zM144 144a32 32 0 1 0 -64 0 32 32 0 1 0 64 0z"/>
                            </svg>
                            {{ __('Khuyến Mãi') }}
                        </span>
                    </x-responsive-nav-link>
                </li>

                <li>
                    <x-responsive-nav-link :href="route('admin.authors.index')" :active="request()->routeIs('admin.authors.*')">
                        <span class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" 
                                class="w-5 h-5 mr-2"
                                viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                                <path fill="#553a25" d="M256 64C150 64 64 150 64 256s86 192 192 192c17.7 0 32 14.3 32 32s-14.3 32-32 32C114.6 512 0 397.4 0 256S114.6 0 256 0S512 114.6 512 256l0 32c0 53-43 96-96 96c-29.3 0-55.6-13.2-73.2-33.9C320 371.1 289.5 384 256 384c-70.7 0-128-57.3-128-128s57.3-128 128-128c27.9 0 53.7 8.9 74.7 24.1c5.7-5 13.1-8.1 21.3-8.1c17.7 0 32 14.3 32 32l0 80 0 32c0 17.7 14.3 32 32 32s32-14.3 32-32l0-32c0-106-86-192-192-192zm64 192a64 64 0 1 0 -128 0 64 64 0 1 0 128 0z"/>
                            </svg>
                            {{ __('Tác giả') }}
                        </span>
                    </x-responsive-nav-link>
                </li>
            </ul>
        </div>

        <!-- User Info and Logout -->
        <div class="p-4 border-t border-gray-200">
            <div class="flex items-center mb-4">
                <div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center overflow-hidden">
                    <span class="text-gray-600">{{ strtoupper(substr(Auth::guard('admin')->user()->name, 0, 1)) }}</span>
                </div>
                <div class="ml-3">
                    <div class="text-sm font-medium text-gray-800">{{ Auth::guard('admin')->user()->name }}</div>
                    <div class="text-xs text-gray-500">{{ Auth::guard('admin')->user()->email }}</div>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <x-responsive-nav-link :href="route('admin.logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                    <span class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" viewBox="0 0 512 512">
                            <path fill="#166534" d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"/>
                        </svg>
                        {{ __('Log Out') }}
                    </span>
                </x-responsive-nav-link>
            </form>
        </div>
    </div>
</nav>