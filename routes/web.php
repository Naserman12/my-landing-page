<?php

use App\Http\Controllers\Admin\ShortLinkController;
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

Route::get('/s/{code}', [ShortLinkController::class, 'redirect'])->name('shortlink.redirect');


