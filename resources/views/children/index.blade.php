<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-xl text-blue-900 leading-tight uppercase tracking-tighter flex items-center gap-2">
                <span class="p-2 bg-blue-100 rounded-lg text-blue-600">
                    {{ $isParentView ? '👨‍👩‍👧‍👦' : '🩺' }}
                </span>
                {{ $isParentView ? 'Daftar Anak Saya' : 'Manajemen Data Pasien Anak' }}
            </h2>
            <a href="{{ route('dashboard') }}" class="inline-flex items-center px-5 py-2.5 bg-blue-900 border-2 border-blue-800 rounded-xl font-black text-[10px] text-white uppercase tracking-widest shadow-lg shadow-blue-200 hover:bg-black transition">
                &larr; Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-blue-50/30 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            {{-- 1. FORM REGISTRASI: Hanya muncul untuk Admin/Petugas --}}
            @if(!$isParentView)
            <div class="bg-white p-8 rounded-2xl shadow-xl border-2 border-blue-100">
                <h3 class="text-[10px] font-black text-blue-400 mb-6 uppercase tracking-widest flex items-center gap-2">
                    <div class="w-2 h-2 bg-blue-600 rounded-full"></div>
                    Registrasi Pasien Baru
                </h3>
                
                <form action="{{ route('children.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
                        <div>
                            <label class="block text-[9px] font-black text-blue-400 uppercase mb-1 ml-1">Nama Lengkap</label>
                            <input type="text" name="nama" class="w-full border-2 border-blue-50 rounded-xl font-bold text-sm bg-blue-50/20 focus:ring-blue-500 focus:border-blue-500 px-4 py-3" placeholder="Nama anak" required>
                        </div>

                        <div>
                            <label class="block text-[9px] font-black text-blue-400 uppercase mb-1 ml-1">Gender</label>
                            <select name="jenis_kelamin" class="w-full border-2 border-blue-50 rounded-xl font-bold text-sm bg-blue-50/20 focus:ring-blue-500 focus:border-blue-500 px-4 py-3" required>
                                <option value="" disabled selected>Pilih Gender</option>
                                <option value="L">LAKI-LAKI</option>
                                <option value="P">PEREMPUAN</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-[9px] font-black text-blue-400 uppercase mb-1 ml-1">Tanggal Lahir</label>
                            <input type="date" name="tgl_lahir" class="w-full border-2 border-blue-50 rounded-xl font-bold text-sm bg-blue-50/20 focus:ring-blue-500 focus:border-blue-500 px-4 py-3" required>
                        </div>

                        <div>
                            <label class="block text-[9px] font-black text-blue-400 uppercase mb-1 ml-1">Orang Tua (Akun)</label>
                            <select name="user_id" class="w-full border-2 border-blue-50 rounded-xl font-bold text-sm bg-blue-50/20 focus:ring-blue-500 focus:border-blue-500 px-4 py-3" required>
                                <option value="" disabled selected>Pilih Akun Ortu</option>
                                @foreach($parents as $parent)
                                    <option value="{{ $parent->id }}">{{ strtoupper($parent->name) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-black text-[10px] uppercase tracking-widest py-4 rounded-xl shadow-md transition-all active:scale-95 shadow-blue-200">
                            Simpan Data
                        </button>
                    </div>
                </form>
            </div>
            @endif

            {{-- 2. TABEL DATABASE --}}
            <div class="bg-white overflow-hidden shadow-xl rounded-2xl border-2 border-blue-100">
                <div class="p-6 bg-blue-900 flex justify-between items-center">
                    <h3 class="text-xs font-black text-white uppercase tracking-widest flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        {{ $isParentView ? 'Data Anak Saya' : 'Database Pasien Aktif' }}
                    </h3>
                    <span class="text-[10px] bg-blue-800 text-blue-100 px-3 py-1 rounded-full font-black border border-blue-700">
                        {{ $children->count() }} TOTAL PASIEN
                    </span>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-blue-50/50">
                                <th class="px-6 py-4 text-[10px] font-black text-blue-900 uppercase tracking-widest border-b-2 border-blue-100">Identitas Pasien</th>
                                @if(!$isParentView)
                                <th class="px-6 py-4 text-[10px] font-black text-blue-900 uppercase tracking-widest border-b-2 border-blue-100">Orang Tua</th>
                                @endif
                                <th class="px-6 py-4 text-[10px] font-black text-blue-900 uppercase tracking-widest border-b-2 border-blue-100 text-center">Gender</th>
                                <th class="px-6 py-4 text-[10px] font-black text-blue-900 uppercase tracking-widest border-b-2 border-blue-100 text-center">Tgl Lahir</th>
                                <th class="px-6 py-4 text-[10px] font-black text-blue-900 uppercase tracking-widest border-b-2 border-blue-100 text-right">Tindakan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y-2 divide-blue-50">
                            @forelse($children as $child)
                            <tr class="hover:bg-blue-50/30 transition-colors group">
                                <td class="px-6 py-5">
                                    <div class="font-black text-blue-900 text-sm capitalize">{{ $child->nama }}</div>
                                    <div class="flex items-center gap-1 mt-1">
                                        <div class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></div>
                                        <div class="text-[9px] font-black text-green-600 uppercase tracking-widest">
                                            Terverifikasi
                                        </div>
                                    </div>
                                </td>
                                
                                @if(!$isParentView)
                                <td class="px-6 py-5">
                                    <div class="text-[11px] font-bold text-gray-600 uppercase">{{ $child->parent->name ?? 'N/A' }}</div>
                                </td>
                                @endif
                                
                                <td class="px-6 py-5 text-center">
                                    <span class="px-3 py-1 rounded-lg text-[9px] font-black uppercase {{ $child->jenis_kelamin == 'L' ? 'bg-blue-100 text-blue-700' : 'bg-pink-100 text-pink-700' }}">
                                        {{ $child->jenis_kelamin == 'L' ? 'LAKI-LAKI' : 'PEREMPUAN' }}
                                    </span>
                                </td>
                                
                                <td class="px-6 py-5 text-center text-sm font-bold text-gray-700">
                                    {{ \Carbon\Carbon::parse($child->tgl_lahir)->translatedFormat('d F Y') }}
                                </td>
                                
                                <td class="px-6 py-5">
                                    <div class="flex justify-end items-center gap-3">
                                        @if(!$isParentView)
                                            <a href="{{ route('children.edit', $child->id) }}" class="p-2 bg-yellow-50 text-yellow-600 hover:bg-yellow-600 hover:text-white rounded-lg transition-all shadow-sm">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>

                                            <form action="{{ route('children.destroy', $child->id) }}" method="POST" onsubmit="return confirm('Hapus data?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="p-2 bg-red-50 text-red-500 hover:bg-red-500 hover:text-white rounded-lg transition-all shadow-sm">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif

                                        <a href="{{ route('children.show', $child->id) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-blue-700 transition shadow-md shadow-blue-100">
                                            <span>{{ $isParentView ? 'Riwayat' : 'Periksa' }}</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="{{ !$isParentView ? 5 : 4 }}" class="px-6 py-20 text-center">
                                    <p class="text-gray-300 font-black text-xs uppercase italic tracking-widest">Belum ada data pasien</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>