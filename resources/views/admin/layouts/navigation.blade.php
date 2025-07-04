<nav x-data="{ open: false }" class="top-0 left-0 h-screen w-64 bg-brown-100 border-r border-gray-200 transition-transform duration-300 ease-in-out z-50">
    <div class="flex flex-col h-full">
        <!-- Logo -->
        <div class="p-4 border-b border-gray-200 w-48">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center">
                <x-application-logo class="h-8 w-auto fill-current text-green-600" />
            </a>
        </div>

        <!-- Menu Items -->
        <div class="flex-1 overflow-y-auto">
            <ul class="space-y-2 p-4">
                <!-- Dashboard -->
                <li>
                    <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                        <span class="flex items-center  text-green-800">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                            </svg>
                            {{ __('Dashboard') }}
                        </span>
                    </x-responsive-nav-link>
                </li>
                <!-- Books -->
                <li>
                    <x-responsive-nav-link :href="route('admin.books.index')" :active="request()->routeIs('admin.books.*')">
                        <span class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-5 h-5 mr-2"
                                viewBox="0 0 448 512">
                                <path fill="#68947f" d="M96 0C43 0 0 43 0 96L0 416c0 53 43 96 96 96l288 0 32 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l0-64c17.7 0 32-14.3 32-32l0-320c0-17.7-14.3-32-32-32L384 0 96 0zm0 384l256 0 0 64L96 448c-17.7 0-32-14.3-32-32s14.3-32 32-32zm32-240c0-8.8 7.2-16 16-16l192 0c8.8 0 16 7.2 16 16s-7.2 16-16 16l-192 0c-8.8 0-16-7.2-16-16zm16 48l192 0c8.8 0 16 7.2 16 16s-7.2 16-16 16l-192 0c-8.8 0-16-7.2-16-16s7.2-16 16-16z"/>
                            </svg>
                            {{ __('Books') }}
                        </span>
                    </x-responsive-nav-link>
                </li>
                <!-- -->
                <li>
                    <x-responsive-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
                        <span class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                            </svg>
                            {{ __('Profile') }}
                        </span>
                    </x-responsive-nav-link>
                </li>
            </ul>
        </div>

        <!-- User Info and Logout -->
        <div class="p-4 border-t border-gray-200">
            <div class="flex items-center mb-4">
                <div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center overflow-hidden">
                    <!-- Placeholder for user avatar, replace with actual image if available -->
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
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 001 1h8a1 1 0 001-1v-2a1 1 0 00-1-1H4v-6h10v2a1 1 0 001 1h2a1 1 0 001-1V4a1 1 0 00-1-1h-8a1 1 0 00-1 1v2a1 1 0 001 1h6v2H4a1 1 0 00-1 1v2h10a1 1 0 001-1V7a1 1 0 00-1-1H3z" clip-rule="evenodd"/>
                        </svg>
                        {{ __('Log Out') }}
                    </span>
                </x-responsive-nav-link>
            </form>
        </div>
    </div>
</nav>