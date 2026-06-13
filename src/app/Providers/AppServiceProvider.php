<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\EloquentUserRepository;
use App\Repositories\UserRepositoryInterface;
use App\Repositories\EloquentWalletRepository;
use App\Repositories\WalletRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            UserRepositoryInterface::class,
            EloquentUserRepository::class
        );
        $this->app->bind(
            WalletRepositoryInterface::class,
            EloquentWalletRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
