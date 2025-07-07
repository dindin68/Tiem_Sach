@php
    $isPromoActive = request()->routeIs('admin.promotions.*');
    $isActive = request()->routeIs('admin.promotions.*');
    $classes = $isActive
        ? 'block w-full ps-3 pe-4 py-2 border-l-4 bg-green-50 text-brown-800 text-start text-base font-medium border-green-700 focus:outline-none focus:text-indigo-800 focus:bg-indigo-100 focus:border-orange-900 transition duration-150 ease-in-out'
        : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base text-brown-800 font-medium hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out';
@endphp
<nav x-data="{ open: false }" class="top-0 left-0 bg-orange-50 h-screen w-64 border-r border-gray-200 transition-transform duration-300 ease-in-out z-50">
    <div class="flex flex-col h-full">
        <!-- Logo -->
        <div class="p-4 border-b border-gray-200 w-48">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center">
                <x-application-logo class="h-8 w-auto fill-current text-green-600" />
            </a>
        </div>

        <!-- Menu Items -->
        <div class="p-4 border-b border-gray-200 w-48">
            <ul class="space-y-2">
                <!-- Trang chủ -->
                <li>
                    <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                        <span class="flex items-center">
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
                                <path fill="#166534" d="M96 0C43 0 0 43 0 96L0 416c0 53 43 96 96 96l288 0 32 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l0-64c17.7 0 32-14.3 32-32l0-320c0-17.7-14.3-32-32-32L384 0 96 0zm0 384l256 0 0 64L96 448c-17.7 0-32-14.3-32-32s14.3-32 32-32zm32-240c0-8.8 7.2-16 16-16l192 0c8.8 0 16 7.2 16 16s-7.2 16-16 16l-192 0c-8.8 0-16-7.2-16-16zm16 48l192 0c8.8 0 16 7.2 16 16s-7.2 16-16 16l-192 0c-8.8 0-16-7.2-16-16s7.2-16 16-16z"/>
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
                                <path fill="#166534" d="M40 48C26.7 48 16 58.7 16 72l0 48c0 13.3 10.7 24 24 24l48 0c13.3 0 24-10.7 24-24l0-48c0-13.3-10.7-24-24-24L40 48zM192 64c-17.7 0-32 14.3-32 32s14.3 32 32 32l288 0c17.7 0 32-14.3 32-32s-14.3-32-32-32L192 64zm0 160c-17.7 0-32 14.3-32 32s14.3 32 32 32l288 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-288 0zm0 160c-17.7 0-32 14.3-32 32s14.3 32 32 32l288 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-288 0zM16 232l0 48c0 13.3 10.7 24 24 24l48 0c13.3 0 24-10.7 24-24l0-48c0-13.3-10.7-24-24-24l-48 0c-13.3 0-24 10.7-24 24zM40 368c-13.3 0-24 10.7-24 24l0 48c0 13.3 10.7 24 24 24l48 0c13.3 0 24-10.7 24-24l0-48c0-13.3-10.7-24-24-24l-48 0z"/>
                            </svg>
                            {{ __('Thể Loại') }}
                        </span>
                    </x-responsive-nav-link>
                </li>

                <!-- Dropdown Khuyến mãi -->
                <li x-data="{ open: {{ $isActive ? 'true' : 'false' }} }">
                    <button @click="open = !open" class="{{ $classes }} w-full text-left">
                        <span class="flex items-center justify-between">
                            <span class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" 
                                    class="w-5 h-5 mr-2"
                                    viewBox="0 0 384 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                                    <path fill="#166534" d="M374.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-320 320c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l320-320zM128 128A64 64 0 1 0 0 128a64 64 0 1 0 128 0zM384 384a64 64 0 1 0 -128 0 64 64 0 1 0 128 0z"/>
                                </svg>
                                Giảm Giá
                            </span>
                            <svg :class="{'rotate-90': open}" class="w-4 h-4 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </span>
                    </button>

                    <ul x-show="open" class="pl-4 mt-1 space-y-1" x-transition>
                        <li>
                            <a href="{{ route('admin.promotions.index') }}" class="{{ request()->routeIs('admin.promotions.index') ? 'text-green-800 font-semibold' : 'text-gray-700' }} hover:text-green-700">
                                Danh sách loại giảm giá
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.promotions.create') }}" class="{{ request()->routeIs('admin.promotions.create') ? 'text-green-800 font-semibold' : 'text-gray-700' }} hover:text-green-700">
                                Thêm giảm giá
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.promotions.history') }}" class="{{ request()->routeIs('admin.books.index') ? 'text-green-800 font-semibold' : 'text-gray-700' }} hover:text-green-700">
                                Xem lịch sử
                            </a>
                        </li>
                    </ul>
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