<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\SocialProviderController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TimetableController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/** Root */
Route::get('/', [UserController::class, 'hitBasePath']);

/** Social Login */
Route::prefix('/auth/{provider}/')->name('social-provider.')->group(function () {
    Route::get('redirect', [SocialProviderController::class, 'redirect'])->name('redirect');
    Route::get('callback', [SocialProviderController::class, 'callback'])->name('callback');
});

/** Core */
Route::middleware(['auth', 'verified'])->group(function () {

    /** Available without completing the profile */
    Route::post('/student/store', [StudentController::class, 'store'])->name('student.store');

    /** Requires complete profile */
    Route::middleware('profile.complete')->group(function () {
        Route::resource('student', StudentController::class)->except('store');
        Route::resource('course', CourseController::class);
        Route::resource('timetable', TimetableController::class);
    });
});

