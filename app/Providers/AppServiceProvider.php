<?php

namespace App\Providers;

use App\Services\Interfaces\AdminRepositoryInterface;
use App\Services\Interfaces\AuthGoogleRepositoryInterface;
use App\Services\Repositories\StudyProgramRepository;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use App\Services\Repositories\FaqRepository;
use App\Services\Repositories\AuthRepository;
use App\Services\Repositories\ReportRepository;
use App\Services\Repositories\ResidentRepository;
use App\Services\Interfaces\FaqRepositoryInterface;
use App\Services\Interfaces\AuthRepositoryInterface;
use App\Services\Interfaces\DecryptParameterRepositoryInterface;
use App\Services\Repositories\ReportStatusRepository;
use App\Services\Interfaces\ReportRepositoryInterface;
use App\Services\Repositories\ReportCategoryRepository;
use App\Services\Interfaces\ResidentRepositoryInterface;
use App\Services\Interfaces\ReportStatusRepositoryInterface;
use App\Services\Interfaces\ReportCategoryRepositoryInterface;
use App\Services\Interfaces\StudyProgramRepositoryInterface;
use App\Services\Repositories\AdminRepository;
use App\Services\Repositories\AuthGoogleRepository;
use App\Services\Repositories\DecryptParameterRepository;

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

        $this->app->bind(
            AuthGoogleRepositoryInterface::class,
            AuthGoogleRepository::class
        );

        $this->app->bind(
            DecryptParameterRepositoryInterface::class,
            DecryptParameterRepository::class
        );

        $this->app->bind(
            StudyProgramRepositoryInterface::class,
            StudyProgramRepository::class
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
