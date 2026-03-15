<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-xl text-blue-900 leading-tight uppercase tracking-tighter flex items-center gap-2">
                <span class="p-2 bg-blue-100 rounded-lg text-blue-600">📝</span>
                {{ __('Edit Data Pasien') }}: <span class="text-blue-600">{{ $child->nama }}</span>
            </h2>
            <a href="{{ route('children.index') }}" class="inline-flex items-center px-5 py-2.5 bg-blue-900 border-2 border-blue-800 rounded-xl font-black text-[10px] text-white uppercase tracking-widest hover:bg-black transition shadow-lg shadow-blue-200">
                &larr; Batal
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-blue-50/30 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-xl rounded-2xl border-2 border-blue-100 p-8">
                <div class="mb-8 border-b-2 border-blue-50 pb-4 flex justify-between items-end">
                    <div>
                        <h3 class="text-[10px] font-black text-blue-900 uppercase tracking-[0.2em]">Formulir Pembaruan Data Pasien</h3>
                        <div class="flex items-center gap-1 mt-1">
                            <div class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></div>
                            <span class="text-[9px] font-black text-green-600 uppercase tracking-widest">Status: Terverifikasi</span>
                        </div>
                    </div>
                    <p class="text-[9px] font-black text-blue-300 uppercase italic tracking-widest">ID Pasien: #{{ $child->id }}</p>
                </div>

                <form action="{{ route('children.update', $child->id) }}" method="POST">
                    @csrf
                    @method('PUT') 
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        {{-- Nama Lengkap --}}
                        <div>
                            <label class="block text-[10px] font-black text-blue-400 uppercase tracking-widest mb-1">Nama Lengkap Pasien</label>
                            <input id="nama" name="nama" type="text" 
                                class="block w-full border-2 border-blue-50 rounded-xl font-bold text-gray-800 text-sm bg-blue-50/20 focus:ring-blue-500 focus:border-blue-500 transition-all" 
                                value="{{ old('nama', $child->nama) }}" required />
                            <x-input-error class="mt-2" :messages="$errors->get('nama')" />
                        </div>

                        {{-- Gender --}}
                        <div>
                            <label class="block text-[10px] font-black text-blue-400 uppercase tracking-widest mb-1">Jenis Kelamin</label>
                            <select name="jenis_kelamin" id="jenis_kelamin" 
                                class="block w-full border-2 border-blue-50 rounded-xl font-bold text-gray-800 text-sm bg-blue-50/20 focus:ring-blue-500 focus:border-blue-500 transition-all">
                                <option value="L" {{ old('jenis_kelamin', $child->jenis_kelamin) == 'L' ? 'selected' : '' }}>LAKI-LAKI</option>
                                <option value="P" {{ old('jenis_kelamin', $child->jenis_kelamin) == 'P' ? 'selected' : '' }}>PEREMPUAN</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('jenis_kelamin')" />
                        </div>

                        {{-- Tanggal Lahir --}}
                        <div>
                            <label class="block text-[10px] font-black text-blue-400 uppercase tracking-widest mb-1">Tanggal Lahir</label>
                            <input id="tgl_lahir" name="tgl_lahir" type="date" 
                                class="block w-full border-2 border-blue-50 rounded-xl font-bold text-gray-800 text-sm bg-blue-50/20 focus:ring-blue-500 focus:border-blue-500 transition-all" 
                                value="{{ old('tgl_lahir', $child->tgl_lahir) }}" required />
                            <x-input-error class="mt-2" :messages="$errors->get('tgl_lahir')" />
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-blue-400 uppercase tracking-widest mb-1">Wali / Orang Tua</label>
                            @if(Auth::user()->role !== 'ortu')
                                <select name="user_id" class="block w-full border-2 border-blue-50 rounded-xl font-bold text-gray-800 text-sm bg-blue-50/20 focus:ring-blue-500 focus:border-blue-500 transition-all" required>
                                    {{-- 1. Tambahkan Opsi Default di paling atas --}}
                                    <option value="" disabled {{ !old('user_id', $child->user_id) ? 'selected' : '' }}>Pilih Akun Ortu</option>
                                    
                                    @foreach($parents as $parent)
                                        {{-- 2. Looping akun ortu, tandai yang aktif sesuai database --}}
                                        <option value="{{ $parent->id }}" {{ old('user_id', $child->user_id) == $parent->id ? 'selected' : '' }}>
                                            {{ strtoupper($parent->name) }}
                                        </option>
                                    @endforeach
                                </select>
                            @else
                                {{-- Tampilan kalau yang login itu Ortu (Locked) --}}
                                <div class="bg-gray-100 border-2 border-gray-200 rounded-xl px-4 py-2.5 text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                    {{ Auth::user()->name }} (Anda)
                                </div>
                                <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                            @endif
                            <x-input-error class="mt-2" :messages="$errors->get('user_id')" />
                        </div>
                    </div>

                    <div class="mt-10 flex items-center justify-between border-t-2 border-blue-50 pt-6">
                        <div class="flex items-center gap-4">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-black text-[10px] uppercase tracking-widest py-4 px-10 rounded-xl shadow-lg shadow-blue-200 transition-all active:scale-95">
                                {{ __('Simpan Perubahan') }}
                            </button>
                            
                            @if (session('success'))
                                <div class="flex items-center gap-2 text-green-600 bg-green-50 px-4 py-2 rounded-lg border border-green-100 animate-bounce">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-[10px] font-black uppercase tracking-widest">{{ __('Berhasil Disimpan') }}</span>
                                </div>
                            @endif
                        </div>
                        
                        <p class="text-[9px] font-black text-blue-300 uppercase italic tracking-widest">HealCare System v1.0</p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>