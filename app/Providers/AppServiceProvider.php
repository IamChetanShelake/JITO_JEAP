<?php

namespace App\Providers;

use App\Models\AdminNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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
        View::composer('admin.layouts.master', function ($view) {
            $actor = Auth::user();
            $notifications = collect();
            $unreadCount = 0;

            if ($actor && in_array($actor->role, ['admin', 'apex'], true)) {
                $notifications = AdminNotification::query()
                    ->where('recipient_role', $actor->role)
                    ->where('recipient_id', $actor->id)
                    ->latest()
                    ->limit(10)
                    ->get();

                $unreadCount = AdminNotification::query()
                    ->where('recipient_role', $actor->role)
                    ->where('recipient_id', $actor->id)
                    ->where('is_read', false)
                    ->count();
            }

            $view->with('layoutNotifications', $notifications)
                ->with('layoutUnreadNotificationCount', $unreadCount)
                ->with('layoutNotificationActor', $actor);
        });
    }
}
