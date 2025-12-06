<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Project;

class AdminDashboardController extends Controller
{
   
public function index()
{
    
    $totalUsers = User::count();
    $activeProjects = Project::where('status', 'active')->count();
    $pendingProjects = Project::where('status', 'pending')->count();

    // Get all projects for the table (optional: order by latest)
    $projects = Project::orderBy('created_at', 'desc')->get();

    return view('admin.dashboard', compact(
        'totalUsers', 
        'activeProjects', 
        'pendingProjects', 
        'projects'  // <-- pass it here
    ));
}


    public function disableProject($id)
    {
        $project = Project::findOrFail($id);
        $project->status = 'disabled';
        $project->save();

        return redirect()->back()->with('message', 'Project disabled successfully');
    }
}
