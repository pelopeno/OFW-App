<?php

use App\Http\Controllers\WalletController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GoalController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\BusinessDashboardController;
use App\Http\Controllers\BusinessProfileController;
use App\Http\Controllers\BusinessUpdateController;
use App\Http\Controllers\MarketplaceController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\ProjectApprovalController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\Admin\MonitoringController;
use App\Http\Controllers\InvestmentHistoryController;

use Illuminate\Support\Facades\Route;

// Routes everyone can see
Route::get('/', function () {
    return view('landing');
})->name('landing');

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
    Route::get('/investment_history', [InvestmentHistoryController::class, 'index'])->name('investment-history');
    Route::get('/marketplace', [MarketplaceController::class, 'index'])->name('marketplace');
    Route::post('/store_goal', [GoalController::class, 'store'])->name('store-goal');
    Route::post('/goals/{id}/allocateFunds', [GoalController::class, 'allocateFunds'])->name('allocate-funds.post');
    Route::post('/goals/{id}/withdrawFunds', [GoalController::class, 'withdrawFunds'])->name('withdraw-funds.post');
    Route::post('/project/{id}/donate', [ProjectController::class, 'donate'])->name('donate-project.post');
    Route::post('/add_funds', [WalletController::class, 'addFunds'])->name('wallet.add-funds');
    Route::post('/withdraw_wallet', [WalletController::class, 'withdrawWallet'])->name('wallet.withdraw-funds');
    Route::get('/transaction_history', [WalletController::class, 'transactionHistory'])->name('history');
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

    Route::get('/business/project/{id}/edit', [ProjectController::class, 'edit'])
        ->name('project.edit');

    Route::put('/business/project/{id}', [ProjectController::class, 'update'])
        ->name('project.update');

    Route::delete('/business/project/{id}', [ProjectController::class, 'destroy'])
        ->name('project.destroy');

    // Profile routes
    Route::post('/business/profile/update', [BusinessProfileController::class, 'update'])
        ->name('business.profile.update');

    Route::post('/business/profile/picture', [BusinessProfileController::class, 'uploadProfilePicture'])
        ->name('business.profile.picture');

    // Updates routes
    Route::post('/business/updates', [BusinessUpdateController::class, 'store'])
        ->name('business.updates.store');

    Route::delete('/business/updates/{id}', [BusinessUpdateController::class, 'destroy'])
        ->name('business.updates.destroy');

    // Capital Contributions route
    Route::get('/business/contributions', [BusinessDashboardController::class, 'showContributions'])
        ->name('contributions');
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

    Route::get(
        '/admin/user_management',
        [UserManagementController::class, 'index']
    )->name('admin-user-management');

    Route::post(
        '/admin/user/{id}/disable',
        [UserManagementController::class, 'disable']
    )->name('admin.disable');

    Route::post(
        '/admin/user/{id}/activate',
        [UserManagementController::class, 'activate']
    )->name('admin.activate');

    Route::post(
        '/admin/user/{id}/archive',
        [UserManagementController::class, 'archive']
    )->name('admin.archive');

    Route::get('/admin/project_approval', [ProjectApprovalController::class, 'index'])
        ->name('admin.project-approval');

    // Approve a project
    Route::post('/admin/project/{id}/approve', [ProjectApprovalController::class, 'approve'])
        ->name('admin.project.approve');

    // Decline a project
    Route::post('/admin/project/{id}/decline', [ProjectApprovalController::class, 'decline'])
        ->name('admin.project.decline');

    Route::get('/admin', [AdminDashboardController::class, 'index'])->name('admin-dashboard');
    Route::post('/admin/project/{id}/disable', [AdminDashboardController::class, 'disableProject'])->name('admin.project.disable');
    Route::post('/admin/project/{id}/enable', [AdminDashboardController::class, 'enableProject'])->name('admin.project.enable');
    Route::get('/admin/monitoring', [MonitoringController::class, 'index'])->name('admin-monitoring');
});
