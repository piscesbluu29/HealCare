<section>
    <header>
        <h3 class="text-xs font-black text-blue-900 uppercase tracking-widest flex items-center gap-2">
            <div class="w-2 h-2 bg-blue-600 rounded-full"></div>
            Informasi Profil & Identitas
        </h3>
        <p class="mt-2 text-[10px] font-bold text-gray-400 uppercase italic leading-relaxed">
            Perbarui data diri dan foto profil Anda untuk mempermudah identifikasi di sistem HealCare.
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    {{-- PENTING: Atribut enctype harus ada untuk upload file --}}
    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-8 space-y-6">
        @csrf
        @method('patch')

        {{-- AREA UPLOAD AVATAR --}}
        <div class="p-6 bg-blue-50/50 rounded-3xl border-2 border-dashed border-blue-100 flex flex-col md:flex-row items-center gap-6">
            <div class="relative group">
                @if($user->avatar)
                    <img src="{{ asset('storage/' . $user->avatar) }}" 
                         class="w-28 h-28 rounded-2xl object-cover border-4 border-white shadow-xl transition-all duration-300 group-hover:scale-105 group-hover:rotate-2">
                @else
                    <div class="w-28 h-28 bg-blue-900 rounded-2xl flex items-center justify-center text-white text-4xl font-black shadow-xl">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                @endif
                
                {{-- Badge Indikator --}}
                <div class="absolute -bottom-2 -right-2 bg-blue-600 text-white p-1.5 rounded-lg shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
            </div>

            <div class="flex-1 space-y-2 text-center md:text-left">
                <label class="block text-[10px] font-black text-blue-400 uppercase tracking-widest">Foto Profil Baru</label>
                <input type="file" name="avatar" 
                       class="block w-full text-[10px] text-gray-500
                              file:mr-4 file:py-2.5 file:px-4
                              file:rounded-xl file:border-0
                              file:text-[10px] file:font-black file:uppercase
                              file:bg-blue-900 file:text-white
                              hover:file:bg-black transition-all cursor-pointer shadow-sm">
                <p class="text-[9px] text-gray-400 font-bold uppercase italic">Format: JPG, PNG (Max. 2MB)</p>
                <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- INPUT NAMA --}}
            <div class="space-y-2">
                <label class="block text-[10px] font-black text-blue-400 uppercase tracking-widest ml-1">Nama Lengkap</label>
                <input type="text" name="name" id="name" 
                       class="block w-full border-2 border-blue-50 rounded-2xl font-bold text-gray-800 text-sm bg-blue-50/20 focus:ring-blue-500 focus:border-blue-500 shadow-sm px-5 py-3.5 transition-all" 
                       value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            {{-- INPUT EMAIL --}}
            <div class="space-y-2">
                <label class="block text-[10px] font-black text-blue-400 uppercase tracking-widest ml-1">Alamat Email</label>
                <input type="email" name="email" id="email" 
                       class="block w-full border-2 border-blue-50 rounded-2xl font-bold text-gray-800 text-sm bg-blue-50/20 focus:ring-blue-500 focus:border-blue-500 shadow-sm px-5 py-3.5 transition-all" 
                       value="{{ old('email', $user->email) }}" required autocomplete="username">
                <x-input-error class="mt-2" :messages="$errors->get('email')" />

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div class="mt-2 p-3 bg-yellow-50 rounded-xl border border-yellow-100">
                        <p class="text-[10px] font-bold text-yellow-700 uppercase">
                            Email belum diverifikasi.
                            <button form="send-verification" class="underline ml-1 hover:text-yellow-900">
                                Klik di sini untuk kirim ulang.
                            </button>
                        </p>
                        @if (session('status') === 'verification-link-sent')
                            <p class="mt-1 text-[9px] font-black text-green-600 uppercase">Link verifikasi baru telah dikirim!</p>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        {{-- ACTION BUTTONS --}}
        <div class="flex items-center gap-4 pt-4 border-t border-blue-50">
            <button type="submit" class="inline-flex items-center px-8 py-4 bg-blue-900 border-2 border-blue-800 rounded-2xl font-black text-[10px] text-white uppercase tracking-widest shadow-xl shadow-blue-100 hover:bg-black active:scale-95 transition-all">
                Simpan Perubahan
            </button>

            @if (session('status') === 'profile-updated')
                <div x-data="{ show: true }" 
                     x-show="show" 
                     x-transition 
                     x-init="setTimeout(() => show = false, 3000)" 
                     class="flex items-center gap-2 text-green-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span class="text-[10px] font-black uppercase tracking-widest">Berhasil Diperbarui</span>
                </div>
            @endif
        </div>
    </form>
</section>