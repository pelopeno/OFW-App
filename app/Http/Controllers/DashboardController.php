<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Wallet balance
        $wallet = $user->wallet;

        // Latest saving goal
        $latestGoal = $user->goals()->latest()->first();

        $projects = Project::latest()->first();

        $latestInvestment = $user->investments()->with('project')->latest()->first();

        return view('dashboard', compact('wallet', 'latestGoal', 'projects', 'latestInvestment'));
    }
}
