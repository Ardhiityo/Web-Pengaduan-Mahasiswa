<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\ResidentController;
use App\Http\Controllers\Superadmin\FaqController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\AuthGoogleController;
use App\Http\Controllers\Superadmin\AdminController;
use App\Http\Controllers\Admin\ReportStatusController;
use App\Http\Controllers\Superadmin\FacultyController;
use App\Http\Controllers\Superadmin\AdminFacultyController;
use App\Http\Controllers\Superadmin\ReportCategoryController;
use App\Http\Controllers\User\FaqController as UserFaqController;
use App\Http\Controllers\User\ReportController as UserReportController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Superadmin\StudyProgramController;

// Auth with google
Route::controller(AuthGoogleController::class)->group(function () {
    Route::prefix('auth')->group(function () {
        Route::get('/redirect',  'redirect')->name('redirect');
        Route::get('/callback',  'callback')->name('callback');
    });
});

//Auth
Route::middleware('check_login')->group(function () {
    //Login
    Route::controller(LoginController::class)->group(function () {
        Route::prefix('login')->group(function () {
            Route::get('/',  'index')->name('login');
            Route::post('/',  'store')->name('login.store');
        });
    });
});

//Register
Route::controller(RegisterController::class)->group(function () {
    Route::prefix('register')->group(function () {
        Route::get('/',  'index')->name('register');
        Route::post('/',  'store')->name('register.store');
    });
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])
        ->name('logout')->middleware(['auth', 'role:admin|superadmin|resident']);
});

//Resident
Route::middleware(['auth', 'role:resident', 'verified'])
    ->group(function () {
        //Report
        Route::controller(UserReportController::class)->group(function () {
            Route::prefix('reports')->group(function () {
                Route::get('/take',  'take')
                    ->name('report.take');
                Route::get('/take/preview',  'preview')
                    ->name('report.take.preview');
                Route::get('/take/create-report',  'create')
                    ->name('report.take.create-report');
                Route::post('/take/create-report',  'store')
                    ->name('report.take.create-report.store');
                Route::get('/reports-success',  'success')
                    ->name('report.success');
                Route::get('/myreports',  'myReport')
                    ->name('myreport');
            });
        });

        //Profile
        Route::controller(ProfileController::class)->group(function () {
            Route::prefix('profile')->group(function () {
                Route::get('/', 'index')->name('profile');
                Route::get('/edit', 'edit')->name('profile.edit');
                Route::patch('/', 'update')->name('profile.update');
            });
        });
    });

Route::middleware('check_is_resident')->group(function () {;
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/faq', [UserFaqController::class, 'index'])->name('faq.user');
});

Route::controller(UserReportController::class)->group(function () {
    Route::prefix('reports')->group(function () {
        Route::get('/',  'index')->name('report.index');
        Route::get('/{reportId}', 'show')->name('report.show');
    });
});

//Admin
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:admin|superadmin'])
    ->group(function () {

        //Dasboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        //Profile
        Route::controller(AdminProfileController::class)->group(function () {
            Route::prefix('profile')->group(function () {
                Route::get('/edit', 'edit')->name('profile.edit');
                Route::patch('/edit', 'update')->name('profile.update');
            });
        });

        //Resident
        Route::resource('resident', ResidentController::class);

        //Report
        Route::resource('report', ReportController::class);

        //Report status
        Route::resource('report-status', ReportStatusController::class)
            ->except('create');

        Route::get('/report-status/{reportId}/create', [ReportStatusController::class, 'create'])->name('report-status.create');
    });

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:superadmin'])
    ->group(function () {
        //Report category
        Route::resource('report-category', ReportCategoryController::class);
        //FAQ
        Route::resource('faq', FaqController::class);
        // Admin
        Route::resource('admin', AdminController::class);
        // Faculty
        Route::resource('faculty', FacultyController::class);
        // Admin Faculty
        Route::get('/admin-faculty/{admin}/create', [AdminFacultyController::class, 'create'])
            ->name('admin-faculty.create');
        Route::post('/admin-faculty/{admin}', [AdminFacultyController::class, 'store'])
            ->name('admin-faculty.store');
        Route::delete('/admin-faculty/{admin}/destroy/{faculty}', [AdminFacultyController::class, 'destroy'])
            ->name('admin-faculty.destroy');
        // Study Program
        Route::get('/faculty/{faculty}/study-program/create', [StudyProgramController::class, 'create'])
            ->name('study-program.create');
        Route::post('/faculty/{faculty}/study-program/create', [StudyProgramController::class, 'store'])
            ->name('study-program.store');
        Route::get('/faculty/{faculty}/study-program/{study_program}/edit', [StudyProgramController::class, 'edit'])
            ->name('study-program.edit');
        Route::delete('/faculty/{faculty}/study-program/{study_program}', [StudyProgramController::class, 'destroy'])
            ->name('study-program.destroy');
    });

Route::fallback(function () {
    if (!Auth::check() || Auth::user()->hasRole('resident')) {
        return response()->view('pages.app.404', status: 404);
    }
    if (Auth::check() && Auth::user()->hasRole('admin')) {
        return response()->view('pages.admin.404', status: 404);
    }
});
