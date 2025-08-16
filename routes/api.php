<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Admin\SiteInfoController;
use App\Http\Controllers\Admin\AchievementController;
use App\Http\Controllers\Admin\ShortLinkController;
use App\Http\Controllers\Admin\VideoController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ServiceController;
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [ProfileController::class, 'show']);
    Route::put('/profile', [ProfileController::class, 'update']);
});
// site-info
Route::get('/site-info', [SiteInfoController::class, 'index']);
// achievements
Route::get('/achievements', [AchievementController::class, 'index']);
Route::get('/s/{id}', [AchievementController::class, 'show']);
Route::get('/videos', [VideoController::class, 'index']);
// videos
Route::get('/s/{id}', [VideoController::class, 'show']);
// contact 
Route::middleware(['throttle:contact'])->post('/contact', [ContactController::class, 'store']);

// services
Route::get('/services', [ServiceController::class, 'index']);
// Route::get('/s/{code}', [ShortLinkController::class, 'redirect'])->name('shortlink.redirect');

Route::middleware(['auth:sanctum', 'role:admin'])->prefix('admin')->group(function () {
    // contact us تواصل معنا
    Route::get('/contacts', [ContactController::class, 'index']);
    Route::delete('/contacts/{id}', [ContactController::class, 'destroy']);
    // services الخدمات
    Route::post('/services', [ServiceController::class, 'store']);
    Route::put('/services/{id}', [ServiceController::class, 'update']);
    Route::delete('/services/{id}', [ServiceController::class, 'destroy']);
    // short links
    Route::get('/short-links/{code}/stats', [ShortLinkController::class, 'stats']);
    // site-info
    Route::apiResource('site-info', SiteInfoController::class)->except(['index', 'show']);
    // الإنجازات
    Route::apiResource('achievements', AchievementController::class)->except(['index', 'show']);
    Route::get('/achievements/{id}/stats', [AchievementController::class, 'achievementStats']);
    // الفيديوهات
    Route::apiResource('videos', VideoController::class)->except(['index', 'show']);
});


