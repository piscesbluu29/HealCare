<?php

namespace App\Http\Controllers;

use App\Models\Child;
use App\Models\User;
use App\Models\GrowthRecord;
use App\Models\WhoStandard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class ChildController extends Controller
{
    /**
     * Menampilkan data anak (Admin liat semua, Ortu liat miliknya sendiri)
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->role == 'ortu') {
            // POV Jihyo: Cuma ambil anak yang user_id nya sesuai id dia
            $children = Child::where('user_id', $user->id)->latest()->get();
            $isParentView = true;
            $parents = collect(); // Kosongkan biar gak error di view
        } else {
            // POV Admin/Petugas: Ambil semua data
            $children = Child::with('parent')->latest()->get();
            $parents = User::where('role', 'ortu')->orderBy('name', 'asc')->get();
            $isParentView = false;
        }

        return view('children.index', compact('children', 'parents', 'isParentView'));
    }

    /**
     * Simpan data anak baru (Hanya Admin/Petugas)
     */
    public function store(Request $request)
    {
        // Proteksi: Ortu dilarang input mandiri
        if (Auth::user()->role == 'ortu') {
            abort(403, 'Orang tua tidak diizinkan menambah data secara mandiri.');
        }

        $request->validate([
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tgl_lahir' => 'required|date',
            'user_id' => 'required|exists:users,id',
        ]);

        Child::create([
            'user_id' => $request->user_id, 
            'nama' => $request->nama,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tgl_lahir' => $request->tgl_lahir,
        ]);

        return redirect()->back()->with('success', 'Data pasien berhasil didaftarkan!');
    }

    /**
     * Tampilkan detail perkembangan
     */
    public function show($id)
    {
        $child = Child::with(['records' => function($query) {
            $query->orderBy('created_at', 'asc');
        }])->findOrFail($id);

        // Security: Ortu cuma bisa liat anaknya sendiri
        if (Auth::user()->role == 'ortu' && $child->user_id !== Auth::id()) {
            abort(403, 'Akses Dilarang.');
        }

        $chartData = [
            'labels' => $child->records->map(fn($r) => $r->created_at->format('d M Y')),
            'heights' => $child->records->pluck('tinggi_badan'),
        ];

        return view('children.show', compact('child', 'chartData'));
    }

    public function edit($id)
    {
        $child = Child::findOrFail($id);

        if (Auth::user()->role == 'ortu') {
            abort(403, 'Hanya Admin/Petugas yang bisa mengedit data.');
        }

        $parents = User::where('role', 'ortu')->orderBy('name', 'asc')->get();
        return view('children.edit', compact('child', 'parents'));
    }

    public function update(Request $request, $id)
    {
        if (Auth::user()->role == 'ortu') {
            abort(403);
        }

        $request->validate([
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tgl_lahir' => 'required|date',
            'user_id' => 'required|exists:users,id',
        ]);

        $child = Child::findOrFail($id);
        
        $child->update([
            'nama' => $request->nama,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tgl_lahir' => $request->tgl_lahir,
            'user_id' => $request->user_id,
        ]);

        return redirect()->route('children.index')->with('success', 'Perubahan data berhasil disimpan!');
    }

    public function destroy($id)
    {
        if (Auth::user()->role == 'ortu') {
            abort(403);
        }

        $child = Child::findOrFail($id);
        $child->records()->delete();
        $child->delete();

        return redirect()->route('children.index')->with('success', 'Data berhasil dihapus selamanya.');
    }

    /**
     * Hitung Stunting (Hanya Admin/Petugas)
     */
    public function check(Request $request, $id)
    {
        if (Auth::user()->role == 'ortu') {
            abort(403, 'Hanya petugas medis yang dapat melakukan pengecekan.');
        }

        $request->validate([
            'tinggi_badan' => 'required|numeric',
            'berat_badan' => 'required|numeric',
        ]);

        $child = Child::findOrFail($id);
        $umur_bulan = Carbon::parse($child->tgl_lahir)->diffInMonths(now());
        $tinggi = $request->tinggi_badan;

        $standard = WhoStandard::where('jenis_kelamin', $child->jenis_kelamin)
                    ->where('umur_bulan', '<=', $umur_bulan)
                    ->orderBy('umur_bulan', 'desc')
                    ->first();

        if (!$standard) {
            return redirect()->back()->with('error', 'Standar WHO tidak ditemukan untuk umur ini.');
        }

        if ($tinggi < $standard->min_3sd) {
            $status = "Sangat Pendek";
        } elseif ($tinggi < $standard->min_2sd) {
            $status = "Pendek";
        } elseif ($tinggi <= $standard->plus_3sd) {
            $status = "Normal";
        } else {
            $status = "Tinggi";
        }

        GrowthRecord::create([
            'child_id' => $child->id,
            'berat_badan' => $request->berat_badan,
            'tinggi_badan' => $tinggi,
            'umur_bulan' => $umur_bulan,
            'status_stunting' => $status,
        ]);

        return redirect()->route('children.show', $id)->with('status_hasil', $status)->with('success', 'Pengecekan selesai!');
    }

    public function downloadPDF($id)
    {
        $child = Child::with('records')->findOrFail($id);
        
        if (Auth::user()->role == 'ortu' && $child->user_id !== Auth::id()) {
            abort(403);
        }

        $pdf = Pdf::loadView('children.pdf', compact('child'));
        return $pdf->download('Laporan_Stunting_' . $child->nama . '.pdf');
    }

    public function destroyRecord($id)
    {
        if (Auth::user()->role == 'ortu') {
            abort(403);
        }

        $record = GrowthRecord::findOrFail($id);
        $childId = $record->child_id;
        $record->delete();

        return redirect()->route('children.show', $childId)->with('success', 'Riwayat berhasil dihapus!');
    }
}