<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 sticky top-0 z-40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('landing') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-indigo-600" />
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('landing')" :active="request()->routeIs('landing')">
                        {{ __('Beranda') }}
                    </x-nav-link>

                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    @if(Auth::user()->role == 'user')
                        <x-nav-link :href="route('donations.index')" :active="request()->routeIs('donations.*')">
                            {{ __('Waqaf Buku') }}
                        </x-nav-link>
                    @endif

                    @if(Auth::user()->role == 'admin')
                        <x-nav-link :href="route('books.index')" :active="request()->routeIs('books.*')">
                            {{ __('Kelola Buku') }}
                        </x-nav-link>
                        <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')">
                            {{ __('Kelola User') }}
                        </x-nav-link>
                        <x-nav-link :href="route('reports.index')" :active="request()->routeIs('reports.*')">
                            {{ __('Laporan') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.fines')" :active="request()->routeIs('admin.fines')">
                            {{ __('Denda Terkumpul') }}
                        </x-nav-link>
                    @endif
                    
                    @if(Auth::user()->role == 'manager')
                        <x-nav-link :href="route('manager.loans')" :active="request()->routeIs('manager.loans')">
                            {{ __('Validasi Peminjaman') }}
                        </x-nav-link>
                        <x-nav-link :href="route('manager.donations')" :active="request()->routeIs('manager.donations')">
                            {{ __('Validasi Waqaf') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-full text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150 gap-3">
                            
                            <img class="h-9 w-9 rounded-full object-cover border border-gray-200" 
                                 src="{{ Auth::user()->profile_photo_path ? asset('storage/' . Auth::user()->profile_photo_path) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&color=7F9CF5&background=EBF4FF' }}" 
                                 alt="{{ Auth::user()->name }}" />

                            <div class="flex flex-col text-left leading-tight">
                                <span class="font-bold text-gray-700">{{ Auth::user()->name }}</span>
                                <span class="text-[10px] text-indigo-500 uppercase tracking-wider font-bold">
                                    {{ Auth::user()->nim ?? Auth::user()->role }}
                                </span>
                            </div>

                            <svg class="fill-current h-4 w-4 ms-1 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-2 border-b border-gray-100">
                            <p class="text-xs text-gray-500">Email Akun:</p>
                            <p class="text-sm font-bold text-gray-900 truncate">{{ Auth::user()->email }}</p>
                        </div>

                        <x-dropdown-link :href="route('landing')">
                            {{ __('Ke Halaman Depan') }}
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Edit Profil') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('landing')" :active="request()->routeIs('landing')">
                {{ __('Beranda') }}
            </x-responsive-nav-link>
            
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            @if(Auth::user()->role == 'user')
                <x-responsive-nav-link :href="route('donations.index')" :active="request()->routeIs('donations.*')">
                    {{ __('Waqaf Buku') }}
                </x-responsive-nav-link>
            @endif

            @if(Auth::user()->role == 'admin')
                <x-responsive-nav-link :href="route('books.index')" :active="request()->routeIs('books.*')">{{ __('Kelola Buku') }}</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')">{{ __('Kelola User') }}</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('reports.index')" :active="request()->routeIs('reports.*')">{{ __('Laporan') }}</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.fines')" :active="request()->routeIs('admin.fines')">{{ __('Denda Terkumpul') }}</x-responsive-nav-link>
            @endif
            
            @if(Auth::user()->role == 'manager')
                <x-responsive-nav-link :href="route('manager.loans')" :active="request()->routeIs('manager.loans')">{{ __('Validasi Peminjaman') }}</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('manager.donations')" :active="request()->routeIs('manager.donations')">{{ __('Validasi Waqaf') }}</x-responsive-nav-link>
            @endif
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4 flex items-center gap-3">
                <img class="h-10 w-10 rounded-full object-cover border border-gray-200" 
                     src="{{ Auth::user()->profile_photo_path ? asset('storage/' . Auth::user()->profile_photo_path) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&color=7F9CF5&background=EBF4FF' }}" 
                     alt="{{ Auth::user()->name }}" />
                
                <div>
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-bold text-xs text-indigo-500 uppercase tracking-wider">
                        {{ Auth::user()->nim ?? Auth::user()->role }}
                    </div>
                    <div class="font-medium text-xs text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">{{ __('Profile') }}</x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">{{ __('Log Out') }}</x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>