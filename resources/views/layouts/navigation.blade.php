<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <img src="{{ asset('images/logo-pln.png') }}" alt="Logo PLN" class="h-16 w-auto mx-auto">
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    {{-- MENU MASTER DATA (Kini bisa diakses oleh Admin & User) --}}
                    <x-nav-link :href="route('k3lk_employees.index')" :active="request()->routeIs('k3lk_employees.*')">
                        {{ __('Pegawai K3LK') }}
                    </x-nav-link>

                    <x-nav-link :href="route('companies.index')" :active="request()->routeIs('companies.*')">
                        {{ __('Perusahaan Pelaksana') }}
                    </x-nav-link>
                    
                    <x-nav-link :href="route('observations.index')" :active="request()->routeIs('observations.*')">
                        {{ __('Data Observasi') }}
                    </x-nav-link>

                    <x-nav-link :href="route('reports.index')" :active="request()->routeIs('reports.*')">
                        {{ __('Laporan') }}
                    </x-nav-link>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <img src="{{ asset('images/logo-k3.png') }}" alt="K3" class="h-6 w-auto mr-2">
                            <div>{{ Auth::user()->name }} 
                                <span class="text-xs font-bold text-blue-600 dark:text-blue-400">[{{ strtoupper(Auth::user()->role) }}]</span>
                            </div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="block px-4 py-2 text-xs text-gray-400 uppercase tracking-widest font-semibold">
                            {{ __('Pengaturan Akun') }}
                        </div>

                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profil Saya') }}
                        </x-dropdown-link>

                        {{-- SEKSI LONCAT AKUN --}}
                        <div class="block px-4 py-2 text-xs text-gray-400 uppercase tracking-widest border-t border-gray-100 dark:border-gray-700 font-semibold">
                            {{ __('Masuk Sebagai') }}
                        </div>

                        @php
                            // Mengambil user lain untuk testing loncat akun (Limit 1 karena user cuma berdua)
                            $otherUsers = \App\Models\User::select('id', 'name', 'role')->where('id', '!=', Auth::id())->limit(1)->get();
                        @endphp

                        @foreach($otherUsers as $u)
                            <x-dropdown-link :href="route('users.impersonate', $u->id)" class="text-sm">
                                {{ $u->name }} <span class="text-[10px] text-gray-400">({{ strtoupper($u->role) }})</span>
                            </x-dropdown-link>
                        @endforeach

                        <div class="border-t border-gray-100 dark:border-gray-700"></div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                        this.closest('form').submit();"
                                class="text-red-600 font-bold">
                                {{ __('Keluar Aplikasi') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- MENU MOBILE --}}
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('k3lk_employees.index')" :active="request()->routeIs('k3lk_employees.*')">
                {{ __('Pegawai K3LK') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('companies.index')" :active="request()->routeIs('companies.*')">
                {{ __('Perusahaan Pelaksana') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('observations.index')" :active="request()->routeIs('observations.*')">
                {{ __('Data Observasi') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('reports.index')" :active="request()->routeIs('reports.*')">
                {{ __('Laporan') }}
            </x-responsive-nav-link>
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
            </div>
            <div class="mt-3 space-y-1">
                @foreach($otherUsers as $u)
                    <x-responsive-nav-link :href="route('users.impersonate', $u->id)">
                        {{ __('Masuk sebagai ') . $u->name }}
                    </x-responsive-nav-link>
                @endforeach
            </div>
        </div>
    </div>
</nav>