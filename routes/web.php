<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\JobCategoriesController;
use App\Http\Controllers\JobVacancyController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:admin,company-owner'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Job Applications
    Route::resource('job_applications', JobApplicationController::class);
    Route::put('job_applications/{id}/restore', [JobApplicationController::class, 'restore'])->name('job_applications.restore');

    // Job Vacancies
    Route::resource('job_vacancies', JobVacancyController::class);
    Route::put('job_vacancies/{id}/restore', [JobVacancyController::class, 'restore'])->name('job_vacancies.restore');
});

// Company Routes
Route::middleware(['auth', 'role:company-owner'])->group(function () {
    Route::get('/my-company', [CompanyController::class, 'show'])->name('my-company.show');
    Route::get('/my-company/edit', [CompanyController::class, 'edit'])->name('my-company.edit');
    Route::put('/my-company', [CompanyController::class, 'update'])->name('my-company.update');
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Job Categories
    Route::resource('job_categories', JobCategoriesController::class);
    Route::put('job_categories/{id}/restore', [JobCategoriesController::class, 'restore'])->name('job_categories.restore');

    // Users
    Route::resource('users', UserController::class);
    Route::put('users/{id}/restore', [UserController::class, 'restore'])->name('users.restore');

    // Companies
    Route::resource('companies', CompanyController::class);
    Route::put('companies/{id}/restore', [CompanyController::class, 'restore'])->name('companies.restore');
});

// =============================================================================================

// Route::middleware(['auth', 'role:admin,company-owner'])->group(function () {
//     // route dashboard
//       Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
//      // route job categories
//     Route::resource('job_categories', JobCategoriesController::class);
//     Route::put('job_categories/{job_category}/restore', [JobCategoriesController::class, 'restore'])->name('job_categories.restore');
//     // route job vacancies
//     Route::resource('job_vacancies', JobVacancyController::class);
//       Route::put('job_vacancies/{id}/restore', [JobVacancyController::class, 'restore'])->name('job_vacancies.restore');
//     // route companies
//     Route::resource('companies', CompanyController::class);
//     Route::put('companies/{company}/restore', [CompanyController::class, 'restore'])->name('companies.restore');
//     // route users
//     Route::resource('users', UserController::class);
//       Route::put('users/{id}/restore', [UserController::class, 'restore'])->name('users.restore');
//     // route job applications
//     Route::resource('job_applications', JobApplicationController::class);
//         Route::put('job_applications/{id}/restore', [JobApplicationController::class, 'restore'])->name('job_applications.restore');

//     // route profile

//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__.'/auth.php';
