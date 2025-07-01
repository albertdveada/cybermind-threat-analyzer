{{-- SLIDE BAR NAVIGATION --}}
<div x-show="sidebarOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform -translate-x-full" x-transition:enter-end="opacity-100 transform translate-x-0" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 transform translate-x-0" x-transition:leave-end="opacity-0 transform -translate-x-full" class="flex flex-col bg-gray-800 w-64 h-screen px-4 text-white border border-gray-700 fixed inset-y-0 left-0 z-40 md:static md:flex md:translate-x-0">
    <div class="flex flex-col mt-8 items-center text-center">
        <div class="w-full">
            <img src="{{ Auth::user()->avatars ? asset('storage/' . Auth::user()->avatars) : asset('storage/default.png') }}" alt="User Avatar" class="mx-auto w-20 h-20 rounded-full border-4 border-gray-700 shadow-md">
        </div>
        <div class="w-full mt-4">
            <span class="font-semibold text-white">{{ \Illuminate\Support\Str::limit(Auth::user()->name, 15) }}</span>
        </div>
    </div>
    <div class="mt-10 mb-4 flex-1">
        <ul class="ml-0 space-y-2">
            <li class="px-4 py-3 flex items-center gap-3 hover:text-black hover:bg-gray-300 hover:font-bold rounded-lg transition-colors duration-200 {{ request()->routeIs('account.account') ? 'bg-gray-300 text-black' : 'text-gray-100' }}">
                <span>
                    <svg class="fill-current h-5 w-5" viewBox="0 0 24 24" sfill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M16 7C16 9.20914 14.2091 11 12 11C9.79086 11 8 9.20914 8 7C8 4.79086 9.79086 3 12 3C14.2091 3 16 4.79086 16 7ZM14 7C14 8.10457 13.1046 9 12 9C10.8954 9 10 8.10457 10 7C10 5.89543 10.8954 5 12 5C13.1046 5 14 5.89543 14 7Z" fill="currentColor"/>
                        <path d="M16 15C16 14.4477 15.5523 14 15 14H9C8.44772 14 8 14.4477 8 15V21H6V15C6 13.3431 7.34315 12 9 12H15C16.6569 12 18 13.3431 18 15V21H16V15Z" fill="currentColor"/>
                    </svg>
                </span>
                <a href="{{ route('profile.layouts') }}" class="flex-1">
                    <span>Your Profile</span>
                </a>
            </li>
            <li class="px-4 py-3 flex items-center gap-3 hover:text-black hover:bg-gray-300 hover:font-bold rounded-lg transition-colors duration-200 {{ request()->routeIs('account.dashboard') ? 'bg-gray-300 text-black' : 'text-gray-100' }}">
                <span>
                    <svg class="fill-current h-5 w-5" viewBox="0 0 24 24">
                        <path d="M16 20h4v-4h-4m0-2h4v-4h-4m-6-2h4V4h-4m6 4h4V4h-4m-6 10h4v-4h-4m-6 4h4v-4H4m0 10h4v-4H4m6 4h4v-4h-4M4 8h4V4H4v4z"></path>
                    </svg>
                </span>
                <a href="{{ route('dashboard') }}" class="flex-1">
                    <span>Dashboard</span>
                </a>
            </li>
            <li x-data="{ open: false }" class="relative">
                <!-- Main Menu -->
                <button @click="open = !open" class="w-full px-4 py-3 flex items-center gap-3 rounded-lg transition-colors duration-200 text-[15px] text-white hover:bg-gray-300 hover:text-black">
                    <svg class="fill-current h-5 w-5" viewBox="0 0 24 24">
                        <path d="M12 13H7v5h5v2H5V10h2v1h5v2M8 4v2H4V4h4m2-2H2v6h8V2m10 9v2h-4v-2h4m2-2h-8v6h8V9m-2 9v2h-4v-2h4m2-2h-8v6h8v-6z"/>
                    </svg>
                    <span class="flex-1 text-left">Security & Control</span>
                    <svg :class="{ 'rotate-90': open }" class="h-4 w-4 transform transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
                <!-- Submenu -->
                <ul x-show="open" x-transition class="mt-1 ml-8 space-y-1 text-[15px] text-white" x-cloak>
                    <li>
                        <a href="{{ route('logs.analyst') }}" class="block px-3 py-2 rounded-lg bg-gray-800 hover:bg-gray-700 hover:text-white transition font-medium">🔐 Analyst Login</a>
                    </li>
                    <li>
                        <a href="{{ route('security.incidents') }}" class="block px-3 py-2 rounded-lg bg-gray-800 hover:bg-gray-700 hover:text-white transition font-medium">⚠️ Security Analyst</a>
                    </li>
                    <li>
                        <a href="{{ route('resolved.incidents') }}" class="block px-3 py-2 rounded-lg bg-gray-800 hover:bg-gray-700 hover:text-white transition font-medium">🗂️ Completed Incidents</a>
                    </li>
                </ul>
            </li>
            <li class="px-4 py-3 flex items-center gap-3 hover:text-black hover:bg-gray-300 hover:font-bold rounded-lg transition-colors duration-200 {{ request()->routeIs('account.apikey') ? 'bg-gray-300 text-black' : 'text-gray-100' }}">
                <span>
                    <svg class="fill-current h-6 w-6" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="352" cy="160" r="160" fill="currentColor"/>
                        <circle cx="400" cy="112" r="40" fill="white"/>
                        <path d="M240 256 L80 416 H80 V464 H128 V432 H160 V400 H208 V368 L368 208 Z" stroke="currentColor" stroke-width="16" fill="currentColor" />
                    </svg>
                </span>
                <a href="{{ route('publickey') }}" class="flex-1">
                    <span>API Key</span>
                </a>
            </li>
            <li class="px-4 py-3 flex items-center gap-3 hover:text-black hover:bg-gray-300 hover:font-bold rounded-lg transition-colors duration-200 {{ request()->routeIs('account.pricing') ? 'bg-gray-300 text-black' : 'text-gray-100' }}">
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path d="M3 6a2 2 0 012-2h7l8 8a2 2 0 010 2.83l-6.17 6.17a2 2 0 01-2.83 0L3 13V6z" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/>
                        <circle cx="6" cy="8" r="0.9" fill="currentColor" />
                        <text x="12" y="15" text-anchor="middle" font-size="12" fill="currentColor" font-weight="normal" font-family="Arial, sans-serif" dominant-baseline="middle">$</text>
                    </svg>
                </span>
                <a href="{{ route('plans') }}" class="flex-1">
                    <span>Plans & Pricing</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="mb-4">
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden"> @csrf </form>
        <li onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="px-4 py-3 flex items-center gap-3 hover:text-black hover:bg-gray-300 hover:font-bold rounded-lg transition-colors duration-200 cursor-pointer">
            <span>
                <svg class="fill-current h-5 w-5" viewBox="0 0 24 24">
                    <path d="M16 9v-4l8 7-8 7v-4h-8v-6h8zm-2 10v-2h-12v-6h12v-2h-12v-6h12v-2h-12c-3.313 0-6 2.687-6 6v6c0 3.313 2.687 6 6 6h12z"/>
                </svg>
            </span>
            <span>Logout</span>
        </li>
    </div>
</div>
