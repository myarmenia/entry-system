<?php

namespace App\Providers;

use App\Interfaces\ClientIdFromTurnstileInterface;
use App\Interfaces\CreateEntryCodeInterface;
use App\Interfaces\FindEntryCodeInterface;
use App\Repositories\CreateEntryCodeRepository;
use App\Repositories\FindEntryCodeRepository;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\TurnstileRepository;
use App\Repositories\UserRepository;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CreateEntryCodeInterface::class, CreateEntryCodeRepository::class);
        $this->app->bind(FindEntryCodeInterface::class, FindEntryCodeRepository::class);
        $this->app->bind(ClientIdFromTurnstileInterface::class, TurnstileRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);


    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
    }
}
