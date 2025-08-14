<?php

use App\Http\Controllers\Admin\ShortLinkController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/s/{code}', [ShortLinkController::class, 'redirect'])->name('shortlink.redirect');


