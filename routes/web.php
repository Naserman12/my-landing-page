<?php

use App\Http\Controllers\Admin\AchievementController;
use App\Http\Controllers\Admin\ShortLinkController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;
use App\Models\SiteInfo;
use App\Models\Achievement;
use App\Models\Video;

Route::get('/', function () {
    return view('welcome');
});
// Route::get('/', function () {
//     return view('landing-page', [
//         'siteInfo' => SiteInfo::first(),
//         'achievements' => Achievement::all(),
//         'videos' => Video::all(),
//     ]);
// });
// Route::get('/achievements', [AchievementController::class, 'index']);
// Route::get('/achievements/{id}',  [AchievementController::class, 'show']);
Route::POST('/login', [AuthController::class, 'login']);
Route::view('/login', 'login')->middleware('guest')->name('login');
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
Route::get('/s/{code}', [ShortLinkController::class, 'redirect'])->name('shortlink.redirect');


