<nav x-data="{ open: false }" class="bg-[#005596] bg-gradient-to-r from-[#003d6b] via-[#005596] to-[#0074cc] border-b-4 border-[#00a3cc] shadow-2xl relative">
    {{-- Background Decorative Pattern --}}
    <div class="absolute inset-0 opacity-10 pointer-events-none overflow-hidden"> 
        <svg class="absolute right-0 top-0 h-full w-auto text-white" fill="currentColor" viewBox="0 0 200 200">
            <path d="M100 0C44.8 0 0 44.8 0 100s44.8 100 100 100 100-44.8 100-100S155.2 0 100 0zm0 180c-44.1 0-80-35.9-80-80s35.9-80 80-80 80 35.9 80 80-35.9 80-80 80z"/>
            <path d="M110 60h-20v30H60v20h30v30h20v-30h30v-20h-30z"/>
        </svg>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="flex justify-between h-24">
            <div class="flex items-center gap-12">
                {{-- Logo Section --}}
                <div class="shrink-0 flex items-center group">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-5">
                        <div class="relative">
                            <div class="absolute -inset-1 bg-cyan-400 blur opacity-25 group-hover:opacity-50 transition duration-300"></div>
                            <div class="relative h-14 w-14 bg-white flex items-center justify-center shadow-lg border-2 border-white/20 rounded-xl transition-all duration-300 group-hover:scale-105">
                                <img src="{{ asset('images/logo-kesehatan.webp') }}" class="h-10 w-10 object-contain drop-shadow-md" alt="Logo">
                            </div>
                        </div>
                        <div class="flex flex-col border-l-2 border-white/20 pl-5">
                            <span class="text-white font-black text-2xl tracking-tighter leading-none italic uppercase">Heal<span class="text-cyan-300">Care</span></span>
                            <span class="text-cyan-100 text-[8px] font-black tracking-[0.3em] uppercase mt-1">Sistem Pemantauan Stunting</span>
                        </div>
                    </a>
                </div>

                {{-- Navigation Links --}}
                <div class="hidden space-x-4 sm:-my-px sm:flex items-center">
                    <a href="{{ route('dashboard') }}" 
                       class="relative group px-5 py-2.5 rounded-xl transition-all duration-300 {{ request()->routeIs('dashboard') ? 'bg-white/10 shadow-lg border border-white/20' : 'hover:bg-white/5 border border-transparent' }}">
                        <div class="flex items-center gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ request()->routeIs('dashboard') ? 'text-cyan-300' : 'text-white/40 group-hover:text-cyan-300' }} transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            <span class="font-black text-[11px] uppercase tracking-[0.15em] {{ request()->routeIs('dashboard') ? 'text-white' : 'text-white/60 group-hover:text-white' }}">Dashboard</span>
                        </div>
                    </a>

                    @if(Auth::user()->role === 'admin' || Auth::user()->role === 'petugas')
                        <a href="{{ route('children.index') }}" 
                           class="relative group px-5 py-2.5 rounded-xl transition-all duration-300 {{ request()->routeIs('children.index') ? 'bg-white/10 shadow-lg border border-white/20' : 'hover:bg-white/5 border border-transparent' }}">
                            <div class="flex items-center gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ request()->routeIs('children.index') ? 'text-cyan-300' : 'text-white/40 group-hover:text-cyan-300' }} transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                <span class="font-black text-[11px] uppercase tracking-[0.15em] {{ request()->routeIs('children.index') ? 'text-white' : 'text-white/60 group-hover:text-white' }}">Data Anak</span>
                            </div>
                        </a>
                    @endif
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('users.index') }}" 
                        class="relative group px-5 py-2.5 rounded-xl transition-all duration-300 {{ request()->routeIs('users.*') ? 'bg-white/10 shadow-lg border border-white/20' : 'hover:bg-white/5 border border-transparent' }}">
                            <div class="flex items-center gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ request()->routeIs('users.*') ? 'text-cyan-300' : 'text-white/40 group-hover:text-cyan-300' }} transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                <span class="font-black text-[11px] uppercase tracking-[0.15em] {{ request()->routeIs('users.*') ? 'text-white' : 'text-white/60 group-hover:text-white' }}">Kelola Petugas</span>
                            </div>
                        </a>
                    @endif
                </div>
            </div>

            {{-- Profile Dropdown Section --}}
            <div class="hidden sm:flex sm:items-center">
                <div class="flex items-center gap-4 bg-black/20 backdrop-blur-md px-4 py-2 rounded-2xl border border-white/10 shadow-inner">
                    <div class="flex flex-col items-end justify-center mr-1">
                        <span class="text-white font-black text-[11px] uppercase tracking-widest leading-none">{{ Auth::user()->name }}</span>
                        <span class="text-cyan-300 text-[8px] font-bold uppercase tracking-tighter mt-1.5 bg-cyan-400/10 px-2 py-0.5 rounded-md leading-none">
                            {{ Auth::user()->role === 'ortu' ? 'Orang Tua' : (Auth::user()->role === 'admin' ? 'Administrator' : 'Petugas Kesehatan') }}
                        </span>
                    </div>
                    
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="relative group focus:outline-none flex items-center shrink-0">
                                <div class="absolute -inset-1 bg-gradient-to-r from-cyan-400 to-blue-500 rounded-full blur opacity-40 group-hover:opacity-100 transition duration-300"></div>
                                <div class="relative w-10 h-10 rounded-full bg-white border-2 border-white/50 overflow-hidden shadow-lg flex items-center justify-center">
                                    @if(Auth::user()->avatar)
                                        <img src="{{ asset('storage/' . Auth::user()->avatar) }}" class="w-full h-full object-cover" alt="Avatar">
                                    @else
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&color=005596&background=EBF4FF&bold=true" class="w-full h-full object-cover" alt="Avatar">
                                    @endif
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="px-4 py-3 bg-blue-50/50 border-b border-gray-100 mb-1">
                                <p class="text-[9px] font-black text-blue-400 uppercase tracking-[0.2em]">Akun Terlogin</p>
                                <p class="text-[11px] font-black text-blue-900 truncate uppercase">{{ Auth::user()->email }}</p>
                            </div>
                            <x-dropdown-link :href="route('profile.edit')" class="group flex items-center gap-3 px-4 py-3">
                                <div class="p-2 bg-blue-100 rounded-lg group-hover:bg-blue-500 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-600 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <span class="font-black text-[10px] uppercase tracking-widest text-gray-700">Profil Saya</span>
                            </x-dropdown-link>
                            <div class="border-t border-gray-100"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="group flex items-center gap-3 px-4 py-3 hover:bg-red-50">
                                    <div class="p-2 bg-red-100 rounded-lg group-hover:bg-red-500 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-600 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                    </div>
                                    <span class="font-black text-[10px] uppercase tracking-widest text-red-600">Logout</span>
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>
        </div>
    </div>
</nav>