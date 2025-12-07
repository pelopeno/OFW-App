<?php

namespace App\Http\Controllers;

use App\Helpers\ActivityLogger;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Project;

class AdminDashboardController extends Controller
{
   
public function index()
{
    
    $totalUsers = User::count();
    $activeProjects = Project::where('status', 'approved')->count();
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

        ActivityLogger::log(
            module: 'PROJECT_MANAGEMENT',
            action: 'disable_project',
            referenceId: $project->id,
            details: "Disabled project: {$project->title}",
            data: [
                'project_id' => $project->id,
                'title' => $project->title,
            ]
        );

        return redirect()->back()->with('message', 'Project disabled successfully');
    }

    public function enableProject($id)
    {
        $project = Project::findOrFail($id);
        $project->status = 'approved';
        $project->save();

        ActivityLogger::log(
            module: 'PROJECT_MANAGEMENT',
            action: 'enable_project',
            referenceId: $project->id,
            details: "Enabled project: {$project->title}",
            data: [
                'project_id' => $project->id,
                'title' => $project->title,
            ]
        );

        return redirect()->back()->with('message', 'Project enabled successfully');
    }
}
