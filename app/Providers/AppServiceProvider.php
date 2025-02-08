<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Repositories\AuthRepository;
use App\Services\Repositories\ReportRepository;
use App\Services\Repositories\ResidentRepository;
use App\Services\Interfaces\AuthRepositoryInterface;
use App\Services\Repositories\ReportStatusRepository;
use App\Services\Interfaces\ReportRepositoryInterface;
use App\Services\Repositories\ReportCategoryRepository;
use App\Services\Interfaces\ResidentRepositoryInterface;
use App\Services\Interfaces\ReportStatusRepositoryInterface;
use App\Services\Interfaces\ReportCategoryRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this
            ->app
            ->bind(
                abstract: AuthRepositoryInterface::class,
                concrete: AuthRepository::class
            );
        $this
            ->app
            ->bind(
                abstract: ResidentRepositoryInterface::class,
                concrete: ResidentRepository::class
            );
        $this->app->bind(
            abstract: ReportCategoryRepositoryInterface::class,
            concrete: ReportCategoryRepository::class
        );
        $this->app->bind(
            abstract: ReportRepositoryInterface::class,
            concrete: ReportRepository::class
        );
        $this->app->bind(
            abstract: ReportStatusRepositoryInterface::class,
            concrete: ReportStatusRepository::class
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
