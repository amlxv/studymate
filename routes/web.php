<?php

use App\Http\Controllers\SocialProviderController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Socialite\Facades\Socialite;

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

Route::get('/', fn() => Inertia::render('Guest/Index'));

Route::get('/home', fn() => Inertia::render('Home/Index'))->middleware('verified')->name('home');

/** Route for social login */
Route::get('/auth/{provider}/redirect', [SocialProviderController::class, 'redirect'])->name('social-provider.redirect');
Route::get('/auth/{provider}/callback', [SocialProviderController::class, 'callback'])->name('social-provider.callback');

