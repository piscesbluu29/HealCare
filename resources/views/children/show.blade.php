<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-xl text-blue-900 leading-tight uppercase tracking-tighter flex items-center gap-2">
                <span class="p-2 bg-blue-100 rounded-lg text-blue-600">📈</span>
                Detail Perkembangan: {{ $child->nama }}
            </h2>
            <div class="flex gap-3">
                <a href="{{ route('children.pdf', $child->id) }}" class="inline-flex items-center px-5 py-2.5 bg-red-600 border-2 border-red-700 rounded-xl font-black text-[10px] text-white uppercase tracking-widest hover:bg-red-800 transition shadow-lg shadow-red-200">
                    Cetak PDF
                </a>
                <a href="{{ route('children.index') }}" class="inline-flex items-center px-5 py-2.5 bg-blue-900 border-2 border-blue-800 rounded-xl font-black text-[10px] text-white uppercase tracking-widest shadow-lg shadow-blue-200 hover:bg-black transition">
                    &larr; Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-blue-50/30 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- GRAFIK TREN DENGAN PITA AREA --}}
            <div class="bg-white p-8 rounded-2xl shadow-xl border-2 border-blue-100 mb-8 overflow-hidden relative">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xs font-black text-blue-900 uppercase tracking-widest flex items-center gap-2">
                        <div class="w-2 h-2 bg-blue-600 rounded-full animate-pulse"></div>
                        Analisis Z-Score Tinggi Badan
                    </h3>
                    <div class="flex gap-4">
                        <div class="flex items-center gap-1.5"><div class="w-3 h-3 bg-green-200 rounded"></div><span class="text-[8px] font-black uppercase text-gray-400">Normal</span></div>
                        <div class="flex items-center gap-1.5"><div class="w-3 h-3 bg-yellow-100 rounded"></div><span class="text-[8px] font-black uppercase text-gray-400">Pendek</span></div>
                        <div class="flex items-center gap-1.5"><div class="w-3 h-3 bg-red-100 rounded"></div><span class="text-[8px] font-black uppercase text-gray-400">Stunting</span></div>
                    </div>
                </div>
                <div class="h-[400px] w-full">
                    <canvas id="growthChart"></canvas>
                </div>
            </div>

            {{-- GRID KONTEN --}}
            <div class="grid grid-cols-1 {{ Auth::user()->role !== 'ortu' ? 'md:grid-cols-3' : '' }} gap-8 items-start">
                
                {{-- INPUT PENGUKURAN --}}
                @if(Auth::user()->role !== 'ortu')
                <div class="md:col-span-1 space-y-6">
                    <div class="bg-white p-8 rounded-2xl shadow-xl border-2 border-blue-100">
                        <h3 class="text-xs font-black text-blue-900 mb-6 uppercase tracking-widest">Input Pengukuran Baru</h3>
                        
                        <form action="{{ route('children.check', $child->id) }}" method="POST">
                            @csrf
                            <div class="grid grid-cols-2 gap-4 mb-6">
                                <div>
                                    <label class="block text-[10px] font-black text-blue-400 uppercase tracking-widest mb-1">TB (cm)</label>
                                    <input type="number" step="0.1" name="tinggi_badan" class="block w-full border-2 border-blue-50 rounded-xl font-bold text-gray-800 text-sm bg-blue-50/20 focus:ring-blue-500 focus:border-blue-500 shadow-sm px-4 py-3" placeholder="0.0" required>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-blue-400 uppercase tracking-widest mb-1">BB (kg)</label>
                                    <input type="number" step="0.1" name="berat_badan" class="block w-full border-2 border-blue-50 rounded-xl font-bold text-gray-800 text-sm bg-blue-50/20 focus:ring-blue-500 focus:border-blue-500 shadow-sm px-4 py-3" placeholder="0.0" required>
                                </div>
                            </div>
                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-black text-[10px] uppercase tracking-widest py-4 rounded-xl shadow-md transition-all active:scale-95 shadow-blue-200">
                                Simpan Rekam Medis
                            </button>
                        </form>

                        @if(session('status_hasil'))
                            <div class="mt-6 p-5 rounded-2xl border-2 animate-in fade-in slide-in-from-bottom-4 duration-500
                                {{ session('status_hasil') == 'Normal' ? 'border-green-200 bg-green-50 text-green-700' : '' }}
                                {{ str_contains(session('status_hasil'), 'Pendek') || session('status_hasil') == 'Stunting' ? 'border-red-200 bg-red-50 text-red-700' : '' }}
                                {{ session('status_hasil') == 'Tinggi' ? 'border-blue-200 bg-blue-50 text-blue-700' : '' }}">
                                <p class="text-[9px] font-black uppercase tracking-widest opacity-60">Status Diagnosa</p>
                                <p class="text-xl font-black uppercase">{{ session('status_hasil') }}</p>
                            </div>
                        @endif
                    </div>
                </div>
                @endif

                {{-- RIWAYAT PERTUMBUHAN --}}
                <div class="{{ Auth::user()->role !== 'ortu' ? 'md:col-span-2' : 'col-span-1' }}">
                    <div class="bg-white p-0 rounded-2xl shadow-xl border-2 border-blue-100 overflow-hidden">
                        <div class="p-6 bg-blue-900 flex justify-between items-center">
                            <h3 class="text-xs font-black text-white uppercase tracking-widest flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Riwayat Pertumbuhan
                            </h3>
                            <span class="text-[10px] bg-blue-800 text-blue-100 px-3 py-1 rounded-full border border-blue-700 font-black uppercase">
                                {{ $child->records->count() }} Data
                            </span>
                        </div>
                        
                        <div class="p-6 space-y-4 max-h-[500px] overflow-y-auto custom-scrollbar">
                            @forelse($child->records->sortByDesc('created_at') as $record)
                                <div class="group relative pl-6 border-l-4 py-4 transition-all hover:bg-blue-50/50 rounded-r-2xl border-2 border-transparent hover:border-blue-100
                                    {{ $record->status_stunting == 'Tinggi' ? 'border-l-blue-500' : '' }}
                                    {{ $record->status_stunting == 'Normal' ? 'border-l-green-500' : '' }}
                                    {{ str_contains($record->status_stunting, 'Pendek') ? 'border-l-red-500' : '' }}">
                                    
                                    <div class="flex justify-between items-center">
                                        <div class="grid grid-cols-2 md:grid-cols-3 gap-8 flex-1">
                                            <div>
                                                <p class="text-[10px] font-black text-blue-400 uppercase tracking-widest">Waktu</p>
                                                <p class="text-sm font-black text-blue-900">{{ $record->created_at->format('d M Y') }}</p>
                                                <p class="text-[10px] font-bold text-gray-400 italic">{{ $record->umur_bulan }} Bulan</p>
                                            </div>
                                            <div>
                                                <p class="text-[10px] font-black text-blue-400 uppercase tracking-widest">Hasil Ukur</p>
                                                <p class="text-sm font-black text-gray-700">TB: <span class="text-blue-600">{{ $record->tinggi_badan }} cm</span></p>
                                                <p class="text-sm font-black text-gray-700">BB: <span class="text-blue-600">{{ $record->berat_badan }} kg</span></p>
                                            </div>
                                            <div class="hidden md:block">
                                                <p class="text-[10px] font-black text-blue-400 uppercase tracking-widest">Status</p>
                                                <span class="inline-block mt-1 px-3 py-1 rounded-lg text-[9px] font-black uppercase border-2
                                                    {{ $record->status_stunting == 'Normal' ? 'bg-green-100 text-green-700 border-green-200' : '' }}
                                                    {{ str_contains($record->status_stunting, 'Pendek') ? 'bg-red-100 text-red-700 border-red-200' : '' }}
                                                    {{ $record->status_stunting == 'Tinggi' ? 'bg-blue-100 text-blue-700 border-blue-200' : '' }}">
                                                    {{ $record->status_stunting }}
                                                </span>
                                            </div>
                                        </div>
                                        @if(Auth::user()->role !== 'ortu')
                                        <form action="{{ route('record.destroy', $record->id) }}" method="POST" onsubmit="return confirm('Hapus data ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-2 text-red-200 hover:text-red-600 transition">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="py-20 text-center">
                                    <p class="text-blue-300 font-black text-xs uppercase italic tracking-widest">Belum ada data</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('growthChart').getContext('2d');
            
            // Mengambil data dari backend
            const labels = {!! json_encode($chartData['labels']) !!};
            const heightData = {!! json_encode($chartData['heights']) !!};
            
            // Dummy Z-Score (Ganti dengan data asli dari KMS jika ada)
            // Di sini kita buat simulasi area background
            const minVal = Math.min(...heightData) - 5;
            const maxVal = Math.max(...heightData) + 5;

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Tinggi Badan Anak',
                            data: heightData,
                            borderColor: '#1E3A8A',
                            backgroundColor: '#1E3A8A',
                            borderWidth: 4,
                            pointRadius: 6,
                            pointHoverRadius: 8,
                            pointBackgroundColor: '#fff',
                            pointBorderColor: '#1E3A8A',
                            pointBorderWidth: 3,
                            tension: 0.4,
                            zIndex: 10
                        },
                        {
                            label: 'Zona Normal',
                            data: heightData.map(() => maxVal), // Area Atas
                            backgroundColor: 'rgba(34, 197, 94, 0.15)', // Hijau Transparan
                            fill: 1, // Mengisi area di bawahnya
                            pointRadius: 0,
                            borderWidth: 0
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: '#1E3A8A',
                            padding: 12,
                            titleFont: { size: 12, weight: 'bold' },
                            bodyFont: { size: 14, weight: 'black' },
                            displayColors: false,
                            callbacks: {
                                label: (context) => `Tinggi: ${context.parsed.y} cm`
                            }
                        }
                    },
                    scales: {
                        y: {
                            grid: { color: '#F1F5F9' },
                            ticks: { 
                                font: { weight: 'bold', size: 11 },
                                callback: (value) => value + ' cm'
                            }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { font: { weight: 'bold', size: 11 } }
                        }
                    }
                }
            });
        });
    </script>

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 5px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #E2E8F0; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #CBD5E1; }
    </style>
</x-app-layout>