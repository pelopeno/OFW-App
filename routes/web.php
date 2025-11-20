<?php

use Illuminate\Support\Facades\Route;

// Routes everyone can see
Route::get('/', function () {
    return view('landing');
});
Route::get('/project', function () {
    return view('project');
})->name('project');

// Routes exclusive to OFWs
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/saving_goals', function () {
        return view('saving-goals');
    })->name('saving-goals');
    Route::get('/investment_history', function () {
        return view('investment-history');
    })->name('investment-history');
    Route::get('/marketplace', function () {
        return view('marketplace');
    })->name('marketplace');
    Route::get('/profile', function () {
        return view(view: 'profile');
    })->name('profile');
});

// Routes exclusive to businesses
Route::get('/business', function () {
    return view('business.dashboard');
})->name('business-dashboard');
Route::get('/business/add-project', function () {
    return view('business.add-project');
})->name('add-project');

// Routes exclusive to admins
Route::get('/admin', function () {
    return view('admin.dashboard');
})->name('admin-dashboard');
Route::get('/admin/project_approval', function () {
    return view('admin.project-approval');
})->name('admin-project-approval');
Route::get('/admin/monitoring', function () {
    return view('admin.monitoring');
})->name('admin-monitoring');
Route::get('/admin/user_management', function () {
    return view('admin.user-management');
})->name('admin-user-management');
