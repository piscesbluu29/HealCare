<x-guest-layout>
    <div class="min-h-screen w-full flex items-center justify-center bg-[#005596] bg-gradient-to-br from-[#003d6b] via-[#005596] to-[#00a3cc] relative overflow-hidden font-sans">
        
        {{-- Ornament Medis Gahar --}}
        <div class="absolute inset-0 opacity-10 pointer-events-none">
            <svg class="absolute -right-20 -top-20 h-[600px] w-auto text-white" fill="currentColor" viewBox="0 0 200 200">
                <path d="M100 0C44.8 0 0 44.8 0 100s44.8 100 100 100 100-44.8 100-100S155.2 0 100 0zm0 180c-44.1 0-80-35.9-80-80s35.9-80 80-80 80 35.9 80 80-35.9 80-80 80z"/>
            </svg>
            <div class="absolute top-1/4 left-10 w-64 h-64 bg-cyan-400 rounded-full blur-[120px]"></div>
            <div class="absolute bottom-1/4 right-10 w-96 h-96 bg-blue-900 rounded-full blur-[150px]"></div>
        </div>

        <div class="w-full max-w-[1200px] grid grid-cols-1 lg:grid-cols-2 gap-0 relative z-10 m-4 shadow-[0_50px_100px_rgba(0,0,0,0.4)] rounded-[40px] overflow-hidden border border-white/20">
            
            {{-- SISI KIRI: Branding & Info --}}
            <div class="hidden lg:flex flex-col justify-between p-16 bg-white/10 backdrop-blur-md border-r border-white/10 text-white">
                <div>
                    <div class="w-20 h-20 bg-white rounded-3xl flex items-center justify-center shadow-2xl mb-8 border-2 border-white/20">
                        <img src="{{ asset('images/logo-kesehatan.webp') }}" class="h-12 w-12 object-contain" alt="Logo">
                    </div>
                    <h1 class="text-6xl font-black italic tracking-tighter leading-none uppercase">
                        HEAL<span class="text-cyan-300">CARE</span>
                    </h1>
                    <p class="mt-4 text-cyan-100 font-bold uppercase tracking-[0.4em] text-xs">Sistem Pemantauan Stunting</p>
                </div>

                <div class="space-y-6">
                    <div class="flex items-center gap-4 bg-black/20 p-4 rounded-2xl border border-white/10">
                        <div class="text-2xl text-cyan-300 italic font-black">2026</div>
                        <div class="text-[10px] font-black uppercase tracking-widest leading-tight">
                            Digitalisasi Layanan <br> Kesehatan Terpadu
                        </div>
                    </div>
                    <p class="text-[10px] text-white/60 font-medium leading-relaxed uppercase tracking-widest italic">
                        "Mencetak generasi emas dengan pemantauan tumbuh kembang anak yang akurat dan real-time."
                    </p>
                </div>
            </div>

            {{-- SISI KANAN: Form Login --}}
            <div class="bg-white p-10 lg:p-20 flex flex-col justify-center">
                <div class="mb-10 lg:hidden text-center">
                    <h1 class="text-3xl font-black text-blue-900 italic tracking-tighter uppercase">HEAL<span class="text-cyan-500">CARE</span></h1>
                </div>

                <div class="mb-10">
                    <h2 class="text-4xl font-black text-blue-900 tracking-tighter uppercase italic leading-none">SELAMAT DATANG</h2>
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em] mt-3">Silahkan masuk ke akun anda</p>
                </div>

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf
                    
                    <div class="space-y-1 group">
                        <label class="text-[10px] font-black text-blue-400 uppercase tracking-widest ml-1">Email Akses</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-blue-300 group-focus-within:text-blue-600 transition-colors">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                </svg>
                            </span>
                            <input type="email" name="email" :value="old('email')" required autofocus 
                                class="block w-full pl-12 pr-4 py-5 bg-blue-50/50 border-2 border-blue-50 rounded-2xl font-bold text-gray-800 text-sm focus:ring-0 focus:border-blue-500 transition-all outline-none" 
                                placeholder="nama@email.com">
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-[10px] font-bold uppercase italic" />
                    </div>

                    <div class="space-y-1 group" x-data="{ show: false }">
                        <div class="flex justify-between items-center px-1">
                            <label class="text-[10px] font-black text-blue-400 uppercase tracking-widest">Kata Sandi</label>
                            @if (Route::has('password.request'))
                                <a class="text-[9px] font-black text-gray-400 uppercase hover:text-blue-600" href="{{ route('password.request') }}">Lupa?</a>
                            @endif
                        </div>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-blue-300 group-focus-within:text-blue-600 transition-colors">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </span>
                            <input :type="show ? 'text' : 'password'" name="password" required 
                                class="block w-full pl-12 pr-12 py-5 bg-blue-50/50 border-2 border-blue-50 rounded-2xl font-bold text-gray-800 text-sm focus:ring-0 focus:border-blue-500 transition-all outline-none" 
                                placeholder="••••••••">
                            <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-4 flex items-center text-blue-300 hover:text-blue-600">
                                <svg x-show="!show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                <svg x-show="show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7 1.274-4.057 5.064-7 9.542-7 1.254 0 2.438.234 3.525.665M12 15a3 3 0 01-3-3m11.5 6.5l-23-23" /></svg>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center px-1">
                        <input id="remember_me" type="checkbox" name="remember" class="rounded-md border-gray-200 text-blue-600 shadow-sm focus:ring-blue-500 w-4 h-4">
                        <label for="remember_me" class="ms-2 text-[10px] font-black text-gray-400 uppercase tracking-widest italic">Ingat Sesi Saya</label>
                    </div>

                    <button type="submit" class="w-full bg-blue-900 text-white font-black text-[11px] uppercase tracking-[0.2em] py-6 rounded-2xl shadow-[0_20px_40px_rgba(0,61,107,0.3)] hover:bg-black active:scale-[0.97] transition-all duration-300">
                        Masuk Ke Dashboard
                    </button>
                </form>

                <p class="mt-12 text-center text-[10px] font-bold text-gray-300 uppercase tracking-widest">
                    &copy; 2026 HEALCARE SYSTEM V1.0 • RSUD TERPADU
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>