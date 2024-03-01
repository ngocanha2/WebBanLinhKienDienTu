<?php

namespace App\Providers;

use App\Models\Role;
use App\Observers\RoleObserver;

use App\Repositories\Interface\UserRepositoryInterface;
use App\Repositories\Repository\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Role::observe(RoleObserver::class);

    }
}
