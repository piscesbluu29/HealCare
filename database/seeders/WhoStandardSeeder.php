<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WhoStandard;

class WhoStandardSeeder extends Seeder
{
    public function run(): void
    {
        // Kosongkan tabel dulu biar gak double kalau di-run ulang
        WhoStandard::truncate();

        // DATA LAKI-LAKI (L) - Berdasarkan Standar Antropometri Kemenkes/WHO
        $lakiLaki = [
            // [Umur, -3SD, -2SD, Median, +3SD]
            [0, 44.2, 46.1, 49.9, 55.6], [1, 48.9, 50.8, 54.7, 60.6],
            [2, 52.4, 54.4, 58.4, 64.4], [3, 55.3, 57.3, 61.4, 67.6],
            [4, 57.6, 59.7, 63.9, 70.1], [5, 59.6, 61.7, 65.9, 72.2],
            [6, 61.2, 63.3, 67.6, 74.0], [12, 68.6, 71.0, 75.7, 82.9],
            [18, 74.4, 76.9, 82.3, 90.2], [24, 78.0, 81.0, 87.1, 96.3],
            [30, 81.7, 85.1, 91.9, 102.1], [36, 86.4, 89.9, 96.1, 105.7],
            [42, 89.9, 93.6, 100.1, 110.0], [48, 93.0, 94.9, 103.3, 113.7],
            [54, 95.9, 99.8, 107.2, 118.0], [60, 98.7, 103.3, 110.0, 121.1],
        ];

        // DATA PEREMPUAN (P) - Berdasarkan Standar Antropometri Kemenkes/WHO
        $perempuan = [
            [0, 43.6, 45.4, 49.1, 54.7], [1, 47.8, 49.8, 53.7, 59.5],
            [2, 51.0, 53.0, 57.1, 63.2], [3, 53.5, 55.6, 59.8, 66.1],
            [4, 55.6, 57.8, 62.1, 68.5], [5, 57.4, 59.6, 64.0, 70.7],
            [6, 58.9, 61.2, 65.7, 72.5], [12, 66.3, 68.9, 74.0, 81.7],
            [18, 72.0, 74.9, 80.7, 89.2], [24, 76.7, 80.0, 86.4, 95.4],
            [30, 80.4, 84.1, 90.7, 100.5], [36, 85.4, 88.7, 95.1, 104.7],
            [42, 89.0, 92.5, 99.3, 109.1], [48, 92.5, 94.1, 102.7, 113.1],
            [54, 95.6, 99.4, 106.7, 117.3], [60, 98.4, 102.6, 109.4, 120.4],
        ];

        foreach ($lakiLaki as $data) {
            WhoStandard::create([
                'jenis_kelamin' => 'L', 'umur_bulan' => $data[0],
                'min_3sd' => $data[1], 'min_2sd' => $data[2], 'median' => $data[3], 'plus_3sd' => $data[4]
            ]);
        }

        foreach ($perempuan as $data) {
            WhoStandard::create([
                'jenis_kelamin' => 'P', 'umur_bulan' => $data[0],
                'min_3sd' => $data[1], 'min_2sd' => $data[2], 'median' => $data[3], 'plus_3sd' => $data[4]
            ]);
        }
    }
}