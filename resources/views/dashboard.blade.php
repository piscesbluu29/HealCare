<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-xl text-blue-900 leading-tight uppercase tracking-tighter flex items-center gap-2">
            <span class="p-2 bg-blue-100 rounded-lg text-blue-600">📊</span>
            Dashboard Pemantauan Stunting
        </h2>
    </x-slot>

    <div class="py-12 bg-blue-50/30 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Stat Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white p-6 rounded-2xl shadow-sm border-2 border-blue-100 border-l-8 border-l-blue-900 h-32 flex flex-col justify-center transition-transform hover:scale-105">
                    <p class="text-[10px] text-blue-400 uppercase font-black tracking-widest mb-1">Total Anak</p>
                    <p class="text-4xl font-black text-blue-900">{{ $totalAnak }}</p>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm border-2 border-blue-100 border-l-8 border-l-green-500 h-32 flex flex-col justify-center transition-transform hover:scale-105">
                    <p class="text-[10px] text-gray-400 uppercase font-black tracking-widest mb-1">Status Normal</p>
                    <p class="text-4xl font-black text-green-600">{{ $normal }}</p>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm border-2 border-blue-100 border-l-8 border-l-red-500 h-32 flex flex-col justify-center transition-transform hover:scale-105">
                    <p class="text-[10px] text-gray-400 uppercase font-black tracking-widest mb-1">Status Stunting</p>
                    <p class="text-4xl font-black text-red-600">{{ $stunting }}</p>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm border-2 border-blue-100 border-l-8 border-l-blue-500 h-32 flex flex-col justify-center transition-transform hover:scale-105">
                    <p class="text-[10px] text-gray-400 uppercase font-black tracking-widest mb-1">Status Tinggi</p>
                    <p class="text-4xl font-black text-blue-600">{{ $tinggi }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-start">
                {{-- Grafik Persentase --}}
                <div class="bg-white p-8 rounded-2xl shadow-xl border-2 border-blue-100 h-full relative overflow-hidden">
                    <h3 class="text-xs font-black text-blue-900 mb-6 uppercase tracking-widest flex items-center gap-2">
                        <div class="w-2 h-2 bg-blue-600 rounded-full animate-ping"></div>
                        Proporsi Gizi Anak
                    </h3>
                    
                    <div class="relative w-full h-[250px] flex items-center justify-center">
                        <canvas id="giziChart"></canvas>
                        {{-- Teks Tengah Donut --}}
                        <div class="absolute inset-0 flex flex-col items-center justify-end pb-8 pointer-events-none">
                            <span class="text-2xl font-black text-blue-900">{{ $totalAnak > 0 ? round(($normal / $totalAnak) * 100) : 0 }}%</span>
                            <span class="text-[8px] font-black text-blue-400 uppercase tracking-widest">Normal</span>
                        </div>
                    </div>
                    
                    <div class="mt-4 grid grid-cols-3 gap-2 border-t border-blue-50 pt-4">
                        <div class="text-center">
                            <p class="text-[8px] font-black text-green-500 uppercase">Aman</p>
                            <p class="text-sm font-black text-slate-800">{{ $normal }}</p>
                        </div>
                        <div class="text-center border-x border-blue-50">
                            <p class="text-[8px] font-black text-red-500 uppercase">Risiko</p>
                            <p class="text-sm font-black text-slate-800">{{ $stunting }}</p>
                        </div>
                        <div class="text-center">
                            <p class="text-[8px] font-black text-blue-500 uppercase">Optimal</p>
                            <p class="text-sm font-black text-slate-800">{{ $tinggi }}</p>
                        </div>
                    </div>
                </div>

                {{-- Tabel Pengecekan Terakhir --}}
                <div class="bg-white p-0 rounded-2xl shadow-xl md:col-span-2 border-2 border-blue-100 overflow-hidden">
                    <div class="p-6 bg-blue-50 border-b-2 border-blue-100 flex justify-between items-center">
                        <h3 class="text-xs font-black text-blue-900 uppercase tracking-widest">Pengecekan Terakhir</h3>
                        <a href="{{ route('children.index') }}" class="bg-blue-600 text-white text-[9px] font-black uppercase px-4 py-2 rounded-lg hover:bg-black transition shadow-md shadow-blue-200">Lihat Semua</a>
                    </div>
                    
                    <div class="overflow-x-auto px-6 pb-6">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="text-blue-900 text-[10px] uppercase font-black tracking-widest border-b-2 border-blue-50">
                                    <th class="py-4">Nama Pasien</th>
                                    <th class="py-4 text-center">Tinggi</th>
                                    <th class="py-4 text-center">Berat</th>
                                    <th class="py-4 text-center">Kondisi</th>
                                    <th class="py-4 text-right">Waktu</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-blue-50">
                                @foreach($recentActivities as $activity)
                                <tr class="hover:bg-blue-50/50 transition-all group">
                                    <td class="py-4 font-black text-slate-900 text-sm capitalize">
                                        {{ $activity->child->nama }}
                                    </td>
                                    <td class="py-4 text-center text-sm font-black text-slate-900">
                                        {{ $activity->tinggi_badan }} <span class="text-[9px] text-slate-400">cm</span>
                                    </td>
                                    <td class="py-4 text-center text-sm font-black text-slate-900">
                                        {{ $activity->berat_badan ?? '0' }} <span class="text-[9px] text-slate-400">kg</span>
                                    </td>
                                    <td class="py-4 text-center">
                                        <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-tighter border
                                            {{ $activity->status_stunting == 'Normal' ? 'bg-green-100 text-green-700 border-green-200' : '' }}
                                            {{ str_contains($activity->status_stunting, 'Pendek') || $activity->status_stunting == 'Stunting' ? 'bg-red-100 text-red-700 border-red-200' : '' }}
                                            {{ $activity->status_stunting == 'Tinggi' ? 'bg-blue-100 text-blue-700 border-blue-200' : '' }}">
                                            {{ $activity->status_stunting }}
                                        </span>
                                    </td>
                                    <td class="py-4 text-right text-[10px] text-slate-400 font-black uppercase group-hover:text-blue-600 transition-colors">
                                        {{ $activity->created_at->diffForHumans() }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('giziChart').getContext('2d');
            
            // Bikin Gradasi Warna biar makin cakep
            const gradientNormal = ctx.createLinearGradient(0, 0, 0, 400);
            gradientNormal.addColorStop(0, '#10B981');
            gradientNormal.addColorStop(1, '#059669');

            const gradientStunting = ctx.createLinearGradient(0, 0, 0, 400);
            gradientStunting.addColorStop(0, '#EF4444');
            gradientStunting.addColorStop(1, '#B91C1C');

            const gradientTinggi = ctx.createLinearGradient(0, 0, 0, 400);
            gradientTinggi.addColorStop(0, '#3B82F6');
            gradientTinggi.addColorStop(1, '#1D4ED8');

            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Normal', 'Stunting', 'Tinggi'],
                    datasets: [{
                        data: [{{ $normal }}, {{ $stunting }}, {{ $tinggi }}],
                        backgroundColor: [gradientNormal, gradientStunting, gradientTinggi],
                        borderWidth: 0,
                        hoverOffset: 20,
                        borderRadius: 10,
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    circumference: 180, // SEMI DONUT
                    rotation: 270,      // Posisi setengah lingkaran di atas
                    cutout: '80%',      // Lubang tengah diperbesar biar estetik
                    plugins: {
                        legend: { 
                            display: true,
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true,
                                font: { size: 10, weight: '900' },
                                color: '#1E3A8A'
                            }
                        },
                        tooltip: {
                            backgroundColor: '#1E3A8A',
                            titleFont: { size: 12, weight: '900' },
                            bodyFont: { size: 11 },
                            padding: 12,
                            displayColors: false
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>