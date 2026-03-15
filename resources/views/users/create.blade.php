<x-app-layout>
    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <div class="flex items-center gap-3 mb-8 ml-2">
                <div class="p-2 bg-white rounded-xl shadow-sm border border-slate-100 text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <div>
                    <h1 class="font-black text-2xl text-slate-800 uppercase tracking-tighter leading-none">
                        Manajemen <span class="text-blue-600">Pengguna</span>
                    </h1>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Kelola akses admin, petugas, & orang tua</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-xl border border-slate-200 p-8">
                
                <div class="flex items-center gap-3 mb-8 pb-4 border-b border-slate-100">
                    <div class="w-1.5 h-6 bg-blue-600 rounded-full shadow-[0_0_8px_rgba(37,99,235,0.4)]"></div>
                    <h3 class="font-black text-xs uppercase tracking-[0.2em] text-blue-600 italic">
                        Registrasi Pengguna Baru
                    </h3>
                </div>

                <form action="{{ route('users.store') }}" method="POST" class="space-y-6" x-data="{ show: false }" autocomplete="off">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold uppercase text-slate-500 tracking-wider mb-2">Nama Lengkap</label>
                            <input type="text" name="name" 
                                class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl p-4 font-semibold text-slate-700 focus:border-blue-500 focus:bg-white transition-all outline-none" 
                                placeholder="Masukkan nama" required>
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase text-slate-500 tracking-wider mb-2">Email</label>
                            <input type="email" name="email" 
                                autocomplete="new-email"
                                class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl p-4 font-semibold text-slate-700 focus:border-blue-500 focus:bg-white transition-all outline-none" 
                                placeholder="example@gmail.com" required>
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase text-slate-500 tracking-wider mb-2">Role</label>
                            <div class="relative">
                                <select name="role" 
                                    class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl p-4 font-semibold text-slate-700 focus:border-blue-500 transition-all outline-none appearance-none cursor-pointer">
                                    <option value="petugas">🩺 PETUGAS KESEHATAN</option>
                                    <option value="ortu">👪 ORANG TUA</option>
                                    <option value="admin">🛡️ ADMINISTRATOR</option>
                                </select>
                                <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-slate-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase text-slate-500 tracking-wider mb-2">Password</label>
                            <div class="relative">
                                <input :type="show ? 'text' : 'password'" name="password" 
                                    autocomplete="new-password"
                                    class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl p-4 font-semibold text-slate-700 focus:border-blue-500 focus:bg-white transition-all outline-none" 
                                    placeholder="••••••••" required>
                                
                                <button type="button" @click="show = !show" class="absolute inset-y-0 right-4 flex items-center text-slate-400 hover:text-blue-600 transition-colors">
                                    <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.976 9.976 0 012.146-3.525m7.83 1.417a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-100">
                        <a href="{{ route('users.index') }}" 
                           class="px-5 py-2.5 rounded-lg font-black text-white bg-red-600 hover:bg-red-700 transition-all uppercase tracking-widest text-[10px]">
                            Batal
                        </a>

                        <button type="submit" 
                                class="px-5 py-2.5 rounded-lg font-black text-white bg-blue-600 hover:bg-blue-700 transition-all uppercase tracking-widest text-[10px] shadow-lg shadow-blue-200">
                            Simpan Akun Baru
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>