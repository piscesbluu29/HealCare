<x-app-layout>
    <div class="py-12 bg-slate-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
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

<div class="bg-white rounded-[2rem] shadow-xl border border-slate-200 overflow-hidden">
    <table class="w-full text-left">
        <thead>
            <tr class="bg-slate-50 border-b-2 border-slate-100">
                <th class="px-10 py-6 text-[14px] font-black uppercase tracking-widest text-slate-800">Nama & Profil</th>
                <th class="py-6 text-[14px] font-black uppercase tracking-widest text-slate-800">Email Aktif</th>
                <th class="py-6 text-[14px] font-black uppercase tracking-widest text-slate-800 text-center">Level Akses</th>
                <th class="px-10 py-6 text-[14px] font-black uppercase tracking-widest text-slate-800 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($users as $user)
            <tr class="hover:bg-blue-50/30 transition-all group">
                <td class="px-10 py-8">
                    <div class="flex items-center gap-5">
                        <div class="h-14 w-14 rounded-full bg-blue-600 flex items-center justify-center text-white font-black text-xl shadow-md">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="font-black text-slate-900 text-lg capitalize leading-none mb-2">{{ $user->name }}</p>
                            <p class="text-[11px] font-bold text-blue-600 uppercase tracking-widest">ID USER: #{{ $user->id }}</p>
                        </div>
                    </div>
                </td>
                
                <td class="py-8 text-md font-extrabold text-slate-700 italic">
                    {{ $user->email }}
                </td>

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
                        {{ $user->role }}
                    </span>
                </td>

                <td class="px-10 py-8 text-right">
                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Hapus user ini?')">
                        @csrf @method('DELETE')
                        <button class="p-4 bg-red-50 text-red-600 rounded-2xl hover:bg-red-600 hover:text-white transition-all shadow-sm active:scale-95 border-2 border-red-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            @endforelse
        </tbody>
    </table>
</div>
        </div>
    </div>
</x-app-layout>