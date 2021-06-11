<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\PageController;
use \App\Http\Controllers\LinkController;
use \App\Http\Controllers\RedirectController;

// Home page
Route::get('/', [PageController::class, 'welcome']);

// Handler Home page form
Route::post('links/create', [LinkController::class, 'create'])->name('create-link');

// Link statistics
Route::get('statistics/{code}', [PageController::class, 'linkStatistics'])->name('statistics');

// Redirect user to source url
Route::get('{code}', [RedirectController::class, 'redirect'])->name('link');
