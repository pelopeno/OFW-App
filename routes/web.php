<?php

use Illuminate\Support\Facades\Route;

// Routes everyone can see
Route::get('/', function () {
    return view('landing');
})->name('landing');
Route::get('/project', function () {
    return view('project');
})->name('project');

// Routes exclusive to OFWs
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'role:ofw',
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
    Route::get('/add_goal', function () {
        return view(view: 'add-goal');
    })->name('add-goal');
    Route::get('/insertGoalIDHere/allocate', function () {
        return view(view: 'allocate-funds');
    })->name('allocate-funds');
    Route::get('/insertGoalIDHere/withdraw', function () {
        return view(view: 'withdraw-funds');
    })->name('withdraw-funds');
    Route::get('/project/ProjectIdHere/donate', function () {
        return view(view: 'donate-project');
    })->name('donate-project');
    Route::get('/add_funds', function () {
        return view(view: 'add-funds');
    })->name('add-funds');
});

// Routes exclusive to Business Users
Route::middleware(['auth', 'role:business_owner'])->group(function () {
    Route::get('/business', function () {
        return view('business.dashboard');
    })->name('business-dashboard');

    Route::get('/business/add_project', function () {
        return view('business.add-project');
    })->name('add-project');
});


// Routes exclusive to Admins
Route::middleware(['auth', 'role:admin'])->group(function () {
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
});