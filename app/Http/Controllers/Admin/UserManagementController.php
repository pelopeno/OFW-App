<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ActivityLogger;
use App\Http\Controllers\Controller;
use App\Models\User;

class UserManagementController extends Controller
{
    // Load the user management page
    public function index()
    {
        $users = User::all(); // fetch all users

        return view('admin.user-management', compact('users'));
    }

    // Disable user
    public function disable($id)
    {
        $user = User::findOrFail($id);
        $user->status = 'Disabled';
        $user->save();

        ActivityLogger::log(
            module: 'USER_MANAGEMENT',
            action: 'disable_user',
            referenceId: $user->id,
            details: "Disabled user: {$user->name}",
            data: [
                'user_id' => $user->id,
                'name' => $user->name,
            ]
        );

        return back()->with('success', 'User disabled successfully');
    }

    // Activate user
    public function activate($id)
    {
        $user = User::findOrFail($id);
        $user->status = 'Active';
        $user->save();

        ActivityLogger::log(
            module: 'USER_MANAGEMENT',
            action: 'activate_user',
            referenceId: $user->id,
            details: "Activated user: {$user->name}",
            data: [
                'user_id' => $user->id,
                'name' => $user->name,
            ]
        );

        return back()->with('success', 'User activated successfully');
    }

    // Archive user
    public function archive($id)
    {
        $user = User::findOrFail($id);
        $user->status = 'Archived';
        $user->save();

        ActivityLogger::log(
            module: 'USER_MANAGEMENT',
            action: 'archive_user',
            referenceId: $user->id,
            details: "Archived user: {$user->name}",
            data: [
                'user_id' => $user->id,
                'name' => $user->name,
            ]
        );
        return back()->with('success', 'User archived successfully');
    }
}
