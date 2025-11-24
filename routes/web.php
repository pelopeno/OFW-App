<?php

use App\Http\Controllers\WalletController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GoalController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\BusinessDashboardController;
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
    Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');
    Route::get('/saving_goals', [GoalController::class, 'showGoals'])->name('saving-goals');
    Route::get('/investment_history', function () {
        return view('investment-history');
    })->name('investment-history');
    Route::get('/marketplace', function () {
        return view('marketplace');
    })->name('marketplace');
    Route::get('/add_goal', [GoalController::class, 'create'])->name('add-goal');
    Route::post('/store_goal', [GoalController::class, 'store'])->name('store-goal');
    Route::get('/goals/{id}/allocate', [GoalController::class, 'showAllocateForm'])->name('allocate-funds');
    Route::post('/goals/{id}/allocateFunds', [GoalController::class, 'allocateFunds'])->name('allocate-funds.post');
    Route::get('/goals/{id}/withdraw', [GoalController::class, 'withdrawForm'])->name('withdraw-funds');
    Route::post('/goals/{id}/withdrawFunds', [GoalController::class, 'withdrawFunds'])->name('withdraw-funds.post');
    Route::get('/project/ProjectIdHere/donate', function () {
        return view(view: 'donate-project');
    })->name('donate-project');
    Route::get('/add_funds', [WalletController::class, 'showAddFunds'])->name('add-funds');
    Route::post('/add_funds', [WalletController::class, 'addFunds'])->name('wallet.add-funds');
});

// Routes exclusive to Business Users
Route::middleware(['auth', 'role:business_owner'])->group(function () {
    Route::get('/business', [BusinessDashboardController::class, 'index'])
        ->name('business-dashboard');

    Route::get('/business/add_project', [ProjectController::class, 'create'])
        ->name('add-project');

    Route::post('/business/store-project', [ProjectController::class, 'store'])
        ->name('project.store');

    Route::get('/project/{id}', [ProjectController::class, 'show'])
        ->name('project.view');
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