<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;
use App\Models\Lowongan;
use App\Models\User;


class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Paginator::useBootstrap();

        View::composer('*', function ($view) {
            if (auth()->check() && auth()->user()->roles->name === 'admin') {
                $lowonganNotifikasi = Lowongan::where('isapproved', 0)->count();
                $userPendingNotifikasi = User::whereHas('roles', function ($q) {
                    $q->where('name', 'alumni');
                })->where('status_active', 0)->count();
                $totalNotifikasi = $lowonganNotifikasi + $userPendingNotifikasi;
            } else {
                $lowonganNotifikasi = 0;
                $userPendingNotifikasi = 0;
                $totalNotifikasi = 0;
            }

            $view->with(compact('lowonganNotifikasi', 'userPendingNotifikasi', 'totalNotifikasi'));
        });
    }
}
