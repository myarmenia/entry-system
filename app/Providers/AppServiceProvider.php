<?php

namespace App\Providers;

<<<<<<< HEAD
use App\Interfaces\ClientIdFromTurnstileInterface;
use App\Interfaces\CreateEntryCodeInterface;
use App\Interfaces\FindEntryCodeInterface;
use App\Repositories\CreateEntryCodeRepository;
use App\Repositories\FindEntryCodeRepository;
use App\Repositories\TurnstileRepository;
=======
use Illuminate\Pagination\Paginator;
>>>>>>> 03b39046cffae652450cc6ca671495ceee2f843c
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
        

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
    }
}
