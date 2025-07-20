<nav x-data="{ open: false }" class="bg-orange-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center min-h-fit">
            <!-- Logo + Links -->
            <div class="flex items-center space-x-10">
                <div class="shrink-0 flex w-32">
                    <a href="{{ route('customer.index') }}">
                        <x-application-logo class="block fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                <div class="hidden sm:flex space-x-6">
                    <x-nav-link :href="route('customer.index')" :active="request()->routeIs('customer.index')">
                        {{ __('Trang Chủ') }}
                    </x-nav-link>
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open"
                            class="inline-flex items-center px-3 py-2 text-gray-700 text-lg font-medium hover:text-green-800 focus:outline-none">
                            {{ __('Tủ Sách') }}
                            <svg class="ml-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.23 7.21a.75.75 0 011.06.02L10 11.086l3.71-3.855a.75.75 0 011.08 1.04l-4.25 4.417a.75.75 0 01-1.08 0L5.25 8.27a.75.75 0 01-.02-1.06z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>

                        <div x-show="open" @click.away="open = false"
                            class="absolute z-50 left-0 mt-2 flex bg-white border border-gray-200 rounded-lg shadow p-4 w-[400px]"
                            x-transition>
                            <div class="w-1/2">
                                <a href="{{ route('books') }}"
                                    class="block px-2 py-1 text-sm font-medium text-green-700 hover:bg-green-100 rounded">
                                    Tất cả
                                </a>
                                @foreach ($categories->slice(0, ceil($categories->count() / 2)) as $category)
                                    <a href="{{ route('books.byCategory', $category->id) }}"
                                        class="block px-2 py-1 text-sm text-gray-700 hover:bg-green-100 rounded">
                                        {{ $category->name }}
                                    </a>
                                @endforeach
                            </div>
                            <div class="w-1/2">
                                @foreach ($categories->slice(ceil($categories->count() / 2)) as $category)
                                    <a href="{{ route('books.byCategory', $category->id) }}"
                                        class="block px-2 py-1 text-sm text-gray-700 hover:bg-green-100 rounded">
                                        {{ $category->name }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <x-nav-link href="#">
                        {{ __('Tác Giả') }}
                    </x-nav-link>
                    <x-nav-link href="#">
                        {{ __('Tin Tức') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Search + Cart + User -->
            <div class="flex items-center space-x-4">
                <!-- Search -->
                <div class="relative hidden sm:block w-64">
                    <input type="text" placeholder="Tìm sách..."
                        class="w-full h-10 pl-4 pr-10 border rounded-lg focus:ring focus:ring-blue-400" />
                    <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M12.9 14.32a8 8 0 1 1 1.41-1.41l5.35 5.33-1.42 1.42-5.33-5.34zM8 14A6 6 0 1 0 8 2a6 6 0 0 0 0 12z" />
                        </svg>
                    </div>
                </div>

                <!-- Cart Icon -->
                <a href="{{ route('cart.index') }}" class="relative group">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-6 h-6 text-green-700 group-hover:scale-110 transition" viewBox="0 0 576 512">
                        <path fill="#166534"
                            d="M0 24C0 10.7 10.7 0 24 0L69.5 0c22 0 41.5 12.8 50.6 32l411 0c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3l-288.5 0 5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5L488 336c13.3 0 24 10.7 24 24s-10.7 24-24 24l-288.3 0c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5L24 48C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96zM252 160c0 11 9 20 20 20l44 0 0 44c0 11 9 20 20 20s20-9 20-20l0-44 44 0c11 0 20-9 20-20s-9-20-20-20l-44 0 0-44c0-11-9-20-20-20s-20 9-20 20l0 44-44 0c-11 0-20 9-20 20z" />
                    </svg>
                    @if(isset($cartItemCount) && $cartItemCount > 0)
                        <span class="absolute -top-1 -right-1 bg-red-600 text-white text-xs rounded-full px-1">
                            {{ $cartItemCount }}
                        </span>
                    @endif
                </a>

                <!-- User Dropdown -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-white">
                            <div>{{ Auth::user()->name }}</div>
                            <svg class="ml-2 h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Tài khoản') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Đăng xuất') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-900 transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Menu -->
    <div :class="{'block': open, 'hidden': !open}" class="sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('customer.index')" :active="request()->routeIs('customer.index')">
                {{ __('Trang Chủ') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('books')" :active="request()->routeIs('books')">
                {{ __('Tủ Sách') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive User -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-700">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Tài khoản') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Đăng xuất') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>