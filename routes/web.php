<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\ResidentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ReportStatusController;
use App\Http\Controllers\Admin\ReportCategoryController;
use App\Http\Controllers\User\FaqController as UserFaqController;
use App\Http\Controllers\User\ReportController as UserReportController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;

//Resident
Route::middleware(['auth', 'role:resident'])->group(function () {
    Route::get('/reports/take', [UserReportController::class, 'take'])->name('report.take');
    Route::get('/reports/take/preview', [UserReportController::class, 'preview'])->name('report.take.preview');
    Route::get('/reports/take/create-report', [UserReportController::class, 'create'])->name('report.take.create-report');
    Route::post('/reports/take/create-report', [UserReportController::class, 'store'])->name('report.take.create-report.store');
    Route::get('/reports-success', [UserReportController::class, 'success'])->name('report.success');
    Route::get('/myreports', [UserReportController::class, 'myReport'])->name('myreport');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

Route::get('/faq', [UserFaqController::class, 'index'])->name('faq.user');
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/reports', [UserReportController::class, 'index'])->name('report.index');
Route::get('/reports/{code}', [UserReportController::class, 'show'])->name('report.code');

Route::get('/login', [LoginController::class, 'index'])
    ->name('login');
Route::post('/login', [LoginController::class, 'store'])
    ->name('login.store');

Route::get('/register', [RegisterController::class, 'index'])
    ->name('register');
Route::post('/register', [RegisterController::class, 'store'])
    ->name('register.store');

Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout')->middleware(['auth', 'role:admin|resident']);

//Dashboard Admin
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/profile/edit', [AdminProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile/edit', [AdminProfileController::class, 'update'])->name('profile.update');

        Route::resource('resident', ResidentController::class);

        Route::resource('report-category', ReportCategoryController::class);

        Route::resource('report', ReportController::class);

        Route::get('/report-status/{reportId}/create', [ReportStatusController::class, 'create'])->name('report-status.create');

        Route::resource('report-status', ReportStatusController::class)->except('create');

        Route::get('/faq', [FaqController::class, 'index'])->name('faq.index');

        Route::get('/faq/create', [FaqController::class, 'create'])->name('faq.create');

        Route::post('/faq', [FaqController::class, 'store'])->name('faq.store');

        Route::get('/faq/{faqId}/edit', [FaqController::class, 'edit'])->name('faq.edit');

        Route::get('/faq/{faqId}', [FaqController::class, 'show'])->name('faq.show');

        Route::put('/faq/{faqId}', [FaqController::class, 'update'])->name('faq.update');

        Route::delete('/faq/{faqId}', [FaqController::class, 'destroy'])->name('faq.destroy');
    });

Route::fallback(function () {
    if (!Auth::check() || Auth::user()->hasRole('resident')) {
        return response()->view('pages.app.404', status: 404);
    }
    if (Auth::check() && Auth::user()->hasRole('admin')) {
        return response()->view('pages.admin.404', status: 404);
    }
});
