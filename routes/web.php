<?php

use App\Http\Controllers\Admin\ShortLinkController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });
use App\Models\SiteInfo;
use App\Models\Achievement;
use App\Models\Video;

Route::get('/', function () {
    return view('landing-page', [
        'siteInfo' => SiteInfo::first(),
        'achievements' => Achievement::all(),
        'videos' => Video::all(),
    ]);
});
Route::POST('/login', [AuthController::class, 'login'])->name('login');
Route::view('/login', 'login');

Route::get('/dashboard', function () {
    return view('dashboard'); // عرض صفحة dashboard.blade.php
})->name('dashboard')->middleware('auth:sanctum', 'role:admin');



Route::get('/s/{code}', [ShortLinkController::class, 'redirect'])->name('shortlink.redirect');


