<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/saving-goals', function () {
        return view('saving-goals');
    })->name('saving-goals');
    Route::get('/investment-history', function () {
        return view('investment-history');
    })->name('investment-history');
    Route::get('/marketplace', function () {
        return view('marketplace');
    })->name('marketplace');

});

    Route::get('/business', function () {
        return view('business.dashboard');
    })->name('business-dashboard');
    Route::get('/project', function () {
        return view('project');
    })->name('project');

