<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\JobCategoriesController;
use App\Http\Controllers\JobVacancyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    // route dashboard
     Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
     // route job categories
    Route::resource('job_categories', JobCategoriesController::class);
    Route::put('job_categories/{job_category}/restore', [JobCategoriesController::class, 'restore'])->name('job_categories.restore');
    // route job vacancies
    Route::resource('job_vacancies', JobVacancyController::class);
    // route companies
    Route::resource('companies', CompanyController::class);
    Route::put('companies/{company}/restore', [CompanyController::class, 'restore'])->name('companies.restore');
    // route users
    Route::resource('users', UserController::class);
    // route job applications
    Route::resource('job_applications', JobApplicationController::class);
    // route profile
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
   
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
