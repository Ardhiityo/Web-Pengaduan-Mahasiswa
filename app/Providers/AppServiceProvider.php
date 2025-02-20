<?php

namespace App\Providers;

use App\Services\Interfaces\AdminRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use App\Services\Repositories\FaqRepository;
use App\Services\Repositories\AuthRepository;
use App\Services\Repositories\ReportRepository;
use App\Services\Repositories\ResidentRepository;
use App\Services\Interfaces\FaqRepositoryInterface;
use App\Services\Interfaces\AuthRepositoryInterface;
use App\Services\Repositories\ReportStatusRepository;
use App\Services\Interfaces\ReportRepositoryInterface;
use App\Services\Repositories\ReportCategoryRepository;
use App\Services\Interfaces\ResidentRepositoryInterface;
use App\Services\Interfaces\ReportStatusRepositoryInterface;
use App\Services\Interfaces\ReportCategoryRepositoryInterface;
use App\Services\Repositories\AdminRepository;

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
                concrete: function ($app) {
                    return new AuthRepository($app->make(ResidentRepositoryInterface::class));
                }
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
        $this->app->bind(
            abstract: FaqRepositoryInterface::class,
            concrete: FaqRepository::class
        );
        $this->app->bind(
            abstract: AdminRepositoryInterface::class,
            concrete: AdminRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Carbon::setLocale('id');
    }
}
