<x-app-layout>
    {{-- Tambahkan library SweetAlert2 di bagian atas atau di layout utama --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="py-12 bg-slate-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            {{-- Header Section --}}
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-3">
                    <div class="p-2.5 bg-white rounded-xl shadow-sm border border-slate-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="font-black text-2xl text-slate-800 uppercase tracking-tighter italic">Manajemen <span class="text-blue-600">Pengguna</span></h2>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Kelola akses admin, petugas, & orang tua</p>
                    </div>
                </div>

                <a href="{{ route('users.create') }}" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white text-[11px] font-black uppercase tracking-widest rounded-xl transition-all shadow-lg shadow-blue-200 active:scale-95">
                    + Tambah Pengguna Baru
                </a>
            </div>

            {{-- Table Section --}}
            <div class="bg-white rounded-[2rem] shadow-xl border border-slate-200 overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-blue-800"> {{-- Warna Biru HealCare --}}
                        <tr>
                            <th class="px-10 py-6 text-[12px] font-black uppercase tracking-widest text-white">Nama & Profil</th>
                            <th class="py-6 text-[12px] font-black uppercase tracking-widest text-white">Email Aktif</th>
                            <th class="py-6 text-[12px] font-black uppercase tracking-widest text-white text-center">Level Akses</th>
                            <th class="py-6 text-[12px] font-black uppercase tracking-widest text-white text-center">Keamanan</th>
                            <th class="px-10 py-6 text-[12px] font-black uppercase tracking-widest text-white text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($users as $user)
                        <tr class="hover:bg-blue-50/30 transition-all group border-b border-slate-100">
                            {{-- Profil & Foto --}}
                            <td class="px-10 py-8">
                                <div class="flex items-center gap-5">
                                    <div class="h-14 w-14 rounded-full overflow-hidden bg-blue-600 flex items-center justify-center text-white font-black text-xl shadow-md border-2 border-white">
                                        @if($user->avatar && file_exists(public_path('storage/' . $user->avatar)))
                                            <img src="{{ asset('storage/' . $user->avatar) }}" class="h-full w-full object-cover">
                                        @else
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-black text-slate-900 text-lg capitalize leading-none mb-2">{{ $user->name }}</p>
                                        <p class="text-[11px] font-bold text-blue-600 uppercase tracking-widest">ID USER: #{{ $user->id }}</p>
                                    </div>
                                </div>
                            </td>
                            
                            {{-- Email --}}
                            <td class="py-8 text-md font-extrabold text-slate-700 italic">
                                {{ $user->email }}
                            </td>

                            {{-- Level Akses --}}
                            <td class="py-8 text-center">
                                @php
                                    $roleStyle = match(strtolower($user->role)) {
                                        'admin' => 'bg-red-600 text-white shadow-red-200',
                                        'petugas' => 'bg-blue-600 text-white shadow-blue-200',
                                        'ortu' => 'bg-emerald-600 text-white shadow-emerald-200',
                                        default => 'bg-slate-600 text-white shadow-slate-200'
                                    };
                                @endphp
                                <span class="inline-block px-6 py-2 rounded-xl text-[11px] font-black uppercase tracking-[0.15em] shadow-lg {{ $roleStyle }}">
                                    {{ strtolower($user->role) === 'ortu' ? 'ORANG TUA' : $user->role }}
                                </span>
                            </td>

                            {{-- Fitur Reset Password (DENGAN SWEETALERT2) --}}
                            <td class="py-8 text-center">
                                <form action="{{ route('users.reset-password', $user->id) }}" method="POST" id="reset-form-{{ $user->id }}">
                                    @csrf
                                    <button type="button" 
                                        onclick="confirmReset('{{ $user->id }}', '{{ $user->name }}')"
                                        class="px-4 py-2 bg-yellow-400 text-black rounded-lg text-[10px] font-black uppercase tracking-wider hover:bg-yellow-500 transition-colors shadow-sm active:scale-95">
                                        Reset Password
                                    </button>
                                </form>
                            </td>

                            {{-- Aksi Hapus --}}
                            <td class="px-10 py-8 text-right">
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" id="delete-form-{{ $user->id }}">
                                    @csrf @method('DELETE')
                                    <button type="button" onclick="confirmDelete('{{ $user->id }}')"
                                        class="p-4 bg-red-50 text-red-600 rounded-2xl hover:bg-red-600 hover:text-white transition-all shadow-sm active:scale-95 border-2 border-red-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1-1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center">
                                <p class="text-slate-400 font-black uppercase tracking-widest italic">Data pengguna tidak ditemukan</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- SCRIPT SWEETALERT --}}
    <script>
        function confirmReset(id, name) {
            Swal.fire({
                title: 'RESET PASSWORD?',
                html: `Password user <b>${name}</b> akan dikembalikan ke standar (password123)`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#2563eb', // Biru HealCare
                cancelButtonColor: '#d33',
                confirmButtonText: 'YA, RESET!',
                cancelButtonText: 'BATAL',
                reverseButtons: true,
                borderRadius: '1.5rem'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('reset-form-' + id).submit();
                }
            })
        }

        function confirmDelete(id) {
            Swal.fire({
                title: 'HAPUS USER?',
                text: "Data yang dihapus tidak bisa dikembalikan!",
                icon: 'error',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'HAPUS!',
                cancelButtonText: 'BATAL',
                reverseButtons: true,
                borderRadius: '1.5rem'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }
    </script>
</x-app-layout>