<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

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

        return back()->with('success', 'User disabled successfully');
    }

    // Activate user
    public function activate($id)
    {
        $user = User::findOrFail($id);
        $user->status = 'Active';
        $user->save();

        return back()->with('success', 'User activated successfully');
    }

    // Archive user
    public function archive($id)
    {
        $user = User::findOrFail($id);
        $user->status = 'Archived';
        $user->save();

        return back()->with('success', 'User archived successfully');
    }
}
