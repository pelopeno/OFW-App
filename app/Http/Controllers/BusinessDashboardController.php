<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;

class BusinessDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get all projects for this business owner ordered by newest first
        $projects = Project::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('business.dashboard', compact('projects'));
    }
}   