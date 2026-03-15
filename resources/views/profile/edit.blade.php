<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-xl text-blue-900 leading-tight uppercase tracking-tighter flex items-center gap-2">
            <span class="p-2 bg-blue-100 rounded-lg text-blue-600">👤</span>
            Pengaturan Profil & Keamanan
        </h2>
    </x-slot>

    <div class="py-12 bg-blue-50/30 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                {{-- INFO KIRI --}}
                <div class="md:col-span-1">
                    <div class="bg-blue-900 p-8 rounded-3xl shadow-xl text-white relative overflow-hidden">
                        <div class="relative z-10">
                            <p class="text-[10px] font-black uppercase tracking-[0.2em] opacity-60 mb-1">Role Akun</p>
                            <h3 class="text-2xl font-black uppercase tracking-tighter mb-4">{{ Auth::user()->role }}</h3>
                            
                            <div class="w-20 h-20 bg-blue-700 rounded-2xl flex items-center justify-center text-3xl mb-4 border-2 border-blue-500/50">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            
                            <p class="text-sm font-bold opacity-80 italic">"Pastikan data diri dan password Anda diperbarui secara berkala untuk keamanan data pasien."</p>
                        </div>
                        {{-- Ornamen --}}
                        <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-blue-800 rounded-full opacity-50"></div>
                    </div>
                </div>

                {{-- FORM KANAN --}}
                <div class="md:col-span-2 space-y-6">
                    
                    {{-- Update Profil --}}
                    <div class="p-8 bg-white shadow-xl border-2 border-blue-100 rounded-3xl">
                        <div class="max-w-xl">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>

                    {{-- Reset Password --}}
                    <div class="p-8 bg-white shadow-xl border-2 border-blue-100 rounded-3xl">
                        <div class="max-w-xl">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>

                    {{-- Hapus Akun (Opsional, Admin/Petugas biasanya nggak butuh ini) --}}
                    @if(Auth::user()->role === 'ortu')
                    <div class="p-8 bg-white shadow-xl border-2 border-red-100 rounded-3xl">
                        <div class="max-w-xl">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>