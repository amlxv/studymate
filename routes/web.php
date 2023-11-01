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
        Route::name('student.')->group(function () {
            Route::get('student', [AdminController::class, 'studentIndex'])->name('index');
            Route::post('student', [AdminController::class, 'studentStore'])->name('store');
            Route::put('student/{user}', [AdminController::class, 'studentUpdate'])->name('update');
            Route::delete('student/{user}', [AdminController::class, 'studentDestroy'])->name('destroy');
        });
    });
});

/**
 * Temporarily for testing purpose.
 */
Route::put("test", function (\Illuminate\Http\Request $request) {
    dd($request->all());
})->name("test");
