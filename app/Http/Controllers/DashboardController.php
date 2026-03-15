<?php

namespace App\Http\Controllers;

use App\Models\Child;
use App\Models\GrowthRecord;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // LOGIKA FILTER: Admin/Petugas liat semua, Ortu liat punya sendiri
        if ($user->role == 'ortu') {
            // Ambil ID anak-anak yang terhubung ke akun orang tua ini
            $childIds = Child::where('user_id', $user->id)->pluck('id');
            $totalAnak = $childIds->count();
        } else {
            // Petugas & Admin liat SEMUA
            $childIds = Child::pluck('id'); 
            $totalAnak = Child::count();
        }

        // 1. Ambil record terbaru tiap anak untuk ringkasan status (Card Stats)
        $latestRecords = GrowthRecord::whereIn('child_id', $childIds)
            ->latest()
            ->get()
            ->unique('child_id');

        $normal = $latestRecords->where('status_stunting', 'Normal')->count();
        $stunting = $latestRecords->whereIn('status_stunting', ['Pendek', 'Sangat Pendek'])->count();
        $tinggi = $latestRecords->where('status_stunting', 'Tinggi')->count();

        // 2. Data untuk Tabel Pengecekan Terakhir
        $recentActivities = GrowthRecord::with('child')
            ->whereIn('child_id', $childIds)
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact('totalAnak', 'normal', 'stunting', 'tinggi', 'recentActivities'));
    }
}