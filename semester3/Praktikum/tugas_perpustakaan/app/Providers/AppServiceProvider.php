<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Peminjaman;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Soal 3: Sentralisasi Otorisasi Gate untuk Peminjaman (Menambal IDOR)
        Gate::define('view-peminjaman', function (User $user, Peminjaman $peminjaman) {
            return $user->hasRole(['Admin', 'Petugas']) || $user->id === $peminjaman->user_id;
        });
    }
}