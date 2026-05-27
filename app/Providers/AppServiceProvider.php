<?php

namespace App\Providers;

use App\Models\Notification;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        // Inject unreadCount ke semua view yang menggunakan navbar
        // Menggantikan fungsi HandleInertiaRequests yang sudah dihapus
        View::composer(['layouts.app', 'layouts.navigation'], function ($view) {
            if (auth()->check()) {
                $unreadCount = Notification::where('user_id', auth()->id())
                    ->whereNull('read_at')
                    ->count();
                $view->with('unreadCount', $unreadCount);
            } else {
                $view->with('unreadCount', 0);
            }
        });
    }
}
