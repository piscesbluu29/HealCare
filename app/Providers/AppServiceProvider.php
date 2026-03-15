<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{

    public function boot(): void
    {
        // 1. Satpam khusus Admin: Cek apakah user punya role 'admin'
        Gate::define('admin-only', function ($user) {
            return $user->role === 'admin';
        });

        // 2. Satpam Petugas & Admin: Buat akses menu Data Anak
        Gate::define('petugas-access', function ($user) {
            return in_array($user->role, ['admin', 'petugas']);
        });
    }
}
