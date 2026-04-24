<?php

namespace App\Providers;

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
        \Illuminate\Support\Facades\Gate::before(function ($user, $ability) {
            return $user->hasRole('admin') ? true : null;
        });

        \Illuminate\Support\Facades\Event::listen(
            \Illuminate\Auth\Events\Login::class,
            function ($event) {
                app(\Modules\Web\Services\CartService::class)->persistToDatabase();
            }
        );

        \Illuminate\Notifications\DatabaseNotification::creating(function ($notification) {
            if (isset($notification->data['vendor_id'])) {
                $notification->vendor_id = $notification->data['vendor_id'];
            }
        });
    }
}
