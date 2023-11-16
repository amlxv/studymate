<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SocialProviderController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TelegramController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\StudentController as AdminStudentController;
use App\Http\Controllers\Admin\CourseController as AdminCourseController;
use App\Http\Controllers\Admin\ScheduleController as AdminScheduleController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use Illuminate\Support\Str;

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
Route::get('/', [UserController::class, 'hitBasePath'])->name('home');

/** Social Login */
Route::prefix('/auth/{provider}/')->name('social-provider.')->group(function () {
    Route::get('redirect', [SocialProviderController::class, 'redirect'])->name('redirect');
    Route::get('callback', [SocialProviderController::class, 'callback'])->name('callback');
});

/** Core */
Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('course', CourseController::class);
    Route::resource('profile', ProfileController::class);
    Route::resource('student', StudentController::class);
    Route::resource('setting', SettingController::class);
    Route::resource('schedule', ScheduleController::class);

    /** Misc */
    Route::get('schedules', [ScheduleController::class, 'viewAll'])->name('schedule.all');
    Route::get('upcoming', [UserController::class, 'upcoming'])->name('upcoming');

    /** Telegram Integration */
    Route::prefix('setting/telegram')->name('telegram.')->group(function () {
        Route::get('/', [TelegramController::class, 'redirect'])->name('redirect');
        Route::get('callback', [TelegramController::class, 'callback'])->name('callback');
    });

    /** Admin Section */
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('student', AdminStudentController::class);
        Route::resource('course', AdminCourseController::class);
        Route::resource('schedule', AdminScheduleController::class);
        Route::resource('setting', AdminSettingController::class);
    });
});

/**
 * Temporarily for testing purpose.
 */
Route::get("test", function () {
    dd("test");
});
