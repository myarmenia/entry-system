<?php

namespace App\Providers;

use App\Helpers\MyHelper;
use App\Interfaces\AttendanceSheetInterface;
use App\Interfaces\CheckEntryCodeInterface;
use App\Interfaces\ClientIdFromTurnstileInterface;
use App\Interfaces\CreateEntryCodeInterface;
use App\Repositories\AttendanceSheetRepository;
use App\Repositories\EntryCodeRepository;
use App\Repositories\Interfaces\PersonRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\PersonRepository;
use App\Repositories\TurnstileRepository;
use App\Repositories\UserRepository;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CreateEntryCodeInterface::class, EntryCodeRepository::class);
        $this->app->bind(ClientIdFromTurnstileInterface::class, TurnstileRepository::class);
        $this->app->bind(CheckEntryCodeInterface::class, TurnstileRepository::class);
        $this->app->bind(AttendanceSheetInterface::class, AttendanceSheetRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);

        $this->app->bind(PersonRepositoryInterface::class, PersonRepository::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();

       
    }
}
