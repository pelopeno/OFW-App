<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;
use App\Models\BusinessUpdate;
use App\Models\Investment;

class BusinessDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get all projects for this business owner ordered by newest first
       $projects = Project::where('user_id', $user->id)
             ->orderBy('created_at', 'desc')
             ->paginate(2);

        // Get all business updates ordered by newest first
        $updates = BusinessUpdate::where('user_id', $user->id)
            ->with('project')
            ->orderBy('created_at', 'desc')
            ->paginate(2);

        return view('business.dashboard', compact('projects', 'updates'));
    }

    public function showContributions()
    {
        $user = Auth::user();

        // Get all investments made in this user's projects
        $contributions = Investment::whereHas('project', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->with('project', 'user')->orderBy('created_at', 'desc')->paginate(2);
        

        return view('business.contributions', compact('contributions'));
    }
}   