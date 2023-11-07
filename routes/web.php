<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SocialProviderController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TelegramController;
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

    Route::resource('schedule', ScheduleController::class);
    Route::get('schedules', [ScheduleController::class, 'viewAll'])->name('schedule.all');

    Route::get('upcoming', [UserController::class, 'upcoming'])->name('upcoming');

    Route::get('setting/telegram', [TelegramController::class, 'redirect'])->name('telegram.redirect');
    Route::get('setting/telegram/callback', [TelegramController::class, 'callback'])->name('telegram.callback');

    Route::resource('setting', SettingController::class);

    Route::prefix('admin')->name('admin.')->group(function () {
        /** Student */
        Route::name('student.')->group(function () {
            Route::get('student', [AdminController::class, 'studentIndex'])->name('index');
            Route::post('student', [AdminController::class, 'studentStore'])->name('store');
            Route::put('student/{user}', [AdminController::class, 'studentUpdate'])->name('update');
            Route::delete('student/{user}', [AdminController::class, 'studentDestroy'])->name('destroy');
        });
        
        /** Course */
        Route::name('course.')->group(function () {
            Route::get('course', [AdminController::class, 'courseIndex'])->name('index');
            Route::post('course', [AdminController::class, 'courseStore'])->name('store');
            Route::put('course/{course}', [AdminController::class, 'courseUpdate'])->name('update');
            Route::delete('course/{course}', [AdminController::class, 'courseDestroy'])->name('destroy');
        });

        /** Schedules */
        Route::name('schedule.')->group(function () {
            Route::get('schedule', [AdminController::class, 'scheduleIndex'])->name('index');
            Route::get('schedule/create', [AdminController::class, 'scheduleCreate'])->name('create');
            Route::post('schedule', [AdminController::class, 'scheduleStore'])->name('store');
            Route::get('schedule/{schedule}', [AdminController::class, 'scheduleEdit'])->name('edit');
            Route::put('schedule/{schedule}', [AdminController::class, 'scheduleUpdate'])->name('update');
            Route::delete('schedule/{schedule}', [AdminController::class, 'scheduleDestroy'])->name('destroy');
        });

        /** Settings */
        Route::name('setting.')->group(function () {
            Route::get('setting', [AdminController::class, 'settingIndex'])->name('index');
            Route::get('setting/create', [AdminController::class, 'settingCreate'])->name('create');
            Route::post('setting', [AdminController::class, 'settingStore'])->name('store');
            Route::get('setting/{setting}', [AdminController::class, 'settingEdit'])->name('edit');
            Route::put('setting/{setting}', [AdminController::class, 'settingUpdate'])->name('update');
            Route::delete('setting/{setting}', [AdminController::class, 'settingDestroy'])->name('destroy');
        });
    });
});

/**
 * Temporarily for testing purpose.
 */
Route::put("test", function (\Illuminate\Http\Request $request) {
    dd($request->all());
})->name("test");
