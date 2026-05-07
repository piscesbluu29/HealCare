<x-guest-layout>
    <div class="min-h-screen w-full flex items-center justify-center bg-[#005596] bg-gradient-to-br from-[#003d6b] via-[#005596] to-[#00a3cc] relative overflow-hidden font-sans p-6">
        
        {{-- Ornament Medis Gahar --}}
        <div class="absolute inset-0 opacity-10 pointer-events-none">
            <svg class="absolute -right-20 -top-20 h-[500px] w-auto text-white" fill="currentColor" viewBox="0 0 200 200">
                <path d="M100 0C44.8 0 0 44.8 0 100s44.8 100 100 100 100-44.8 100-100S155.2 0 100 0zm0 180c-44.1 0-80-35.9-80-80s35.9-80 80-80 80 35.9 80 80-35.9 80-80 80z"/>
            </svg>
            <div class="absolute top-1/4 left-10 w-64 h-64 bg-cyan-400 rounded-full blur-[120px]"></div>
            <div class="absolute bottom-1/4 right-10 w-80 h-80 bg-blue-900 rounded-full blur-[150px]"></div>
        </div>

        {{-- KOTAK UTAMA: Max-width dikunci di 950px agar tidak memenuhi layar --}}
        <div class="w-full max-w-[950px] grid grid-cols-1 lg:grid-cols-2 gap-0 relative z-10 shadow-[0_40px_80px_rgba(0,0,0,0.4)] rounded-[32px] overflow-hidden border border-white/20">
            
            {{-- SISI KIRI: Branding & Info --}}
            <div class="hidden lg:flex flex-col justify-between p-12 bg-white/10 backdrop-blur-md border-r border-white/10 text-white">
                <div>
                    {{-- Logo Container (Compact Size) --}}
                    <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center shadow-2xl mb-6 border-2 border-white/20">
                        <img src="{{ asset('images/logo-kesehatan.webp') }}" class="h-10 w-10 object-contain" alt="Logo">
                    </div>
                    
                    {{-- Judul HealCare (5xl agar pas) --}}
                    <h1 class="text-5xl font-black italic tracking-tighter leading-none uppercase">
                        HEAL<span class="text-cyan-300">CARE</span>
                    </h1>
                    <p class="mt-3 text-cyan-100 font-bold uppercase tracking-[0.4em] text-[10px]">
                        Sistem Pemantauan Stunting
                    </p>
                </div>

                <div class="space-y-5">
                    {{-- Info Box --}}
                    <div class="flex items-center gap-4 bg-black/20 p-3.5 rounded-xl border border-white/10">
                        <div class="text-xl text-cyan-300 italic font-black">2026</div>
                        <div class="text-[9px] font-black uppercase tracking-widest leading-tight">
                            Digitalisasi Layanan <br> Kesehatan Terpadu
                        </div>
                    </div>
                    {{-- Slogan --}}
                    <p class="text-[9px] text-white/60 font-medium leading-relaxed uppercase tracking-widest italic">
                        "Mencetak generasi emas dengan pemantauan tumbuh kembang anak yang akurat dan real-time."
                    </p>
                </div>
            </div>

            {{-- SISI KANAN: Form Login --}}
            <div class="bg-white p-10 lg:p-14 flex flex-col justify-center">
                {{-- Logo Mobile Only --}}
                <div class="mb-8 lg:hidden text-center">
                    <h1 class="text-2xl font-black text-blue-900 italic tracking-tighter uppercase">
                        HEAL<span class="text-cyan-500">CARE</span>
                    </h1>
                </div>

                {{-- Header Login --}}
                <div class="mb-8">
                    <h2 class="text-3xl font-black text-blue-900 tracking-tighter uppercase italic leading-none">
                        SELAMAT DATANG
                    </h2>
                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-[0.3em] mt-2">
                        Silahkan masuk ke akun anda
                    </p>
                </div>

                {{-- Form Section --}}
                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf
                    
                    {{-- Email Input --}}
                    <div class="space-y-1 group">
                        <label class="text-[9px] font-black text-blue-400 uppercase tracking-widest ml-1">Email Akses</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-blue-300 group-focus-within:text-blue-600 transition-colors">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                </svg>
                            </span>
                            <input type="email" name="email" :value="old('email')" required autofocus 
                                class="block w-full pl-11 pr-4 py-4 bg-blue-50/50 border-2 border-blue-50 rounded-xl font-bold text-gray-800 text-sm focus:ring-0 focus:border-blue-500 transition-all outline-none" 
                                placeholder="nama@email.com">
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-[9px] font-bold uppercase italic text-red-500" />
                    </div>

                    {{-- Password Input --}}
                    <div class="space-y-1 group" x-data="{ show: false }">
                        <div class="flex justify-between items-center px-1">
                            <label class="text-[9px] font-black text-blue-400 uppercase tracking-widest">Kata Sandi</label>
                            @if (Route::has('password.request'))
                                <a class="text-[8px] font-black text-gray-400 uppercase hover:text-blue-600 transition-colors" href="{{ route('password.request') }}">Lupa?</a>
                            @endif
                        </div>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-blue-300 group-focus-within:text-blue-600 transition-colors">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </span>
                            <input :type="show ? 'text' : 'password'" name="password" required 
                                class="block w-full pl-11 pr-11 py-4 bg-blue-50/50 border-2 border-blue-50 rounded-xl font-bold text-gray-800 text-sm focus:ring-0 focus:border-blue-500 transition-all outline-none" 
                                placeholder="••••••••">
                            {{-- Toggle Password Visibility --}}
                            <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-4 flex items-center text-blue-300 hover:text-blue-600 transition-colors">
                                <svg x-show="!show" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                <svg x-show="show" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7 1.274-4.057 5.064-7 9.542-7 1.254 0 2.438.234 3.525.665M12 15a3 3 0 01-3-3m11.5 6.5l-23-23" /></svg>
                            </button>
                        </div>
                    </div>

                    {{-- Remember Me --}}
                    <div class="flex items-center px-1">
                        <input id="remember_me" type="checkbox" name="remember" class="rounded border-gray-200 text-blue-600 shadow-sm focus:ring-blue-500 w-3.5 h-3.5">
                        <label for="remember_me" class="ms-2 text-[9px] font-black text-gray-400 uppercase tracking-widest italic">Ingat Sesi Saya</label>
                    </div>

                    {{-- Login Button --}}
                    <button type="submit" class="w-full bg-blue-900 text-white font-black text-[10px] uppercase tracking-[0.2em] py-5 rounded-xl shadow-[0_15px_30px_rgba(0,61,107,0.2)] hover:bg-black active:scale-[0.98] transition-all duration-300">
                        LOGIN
                    </button>
                </form>

                {{-- Footer Text --}}
                <p class="mt-10 text-center text-[9px] font-bold text-gray-300 uppercase tracking-widest">
                    &copy; 2026 HEALCARE SYSTEM • V1.0 • RSUD TERPADU
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>