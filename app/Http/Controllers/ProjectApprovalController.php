<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectApprovalController extends Controller
{
    public function index()
    {
        $projects = Project::where('status', 'pending')->get(); // Pending projects for table
        $activeProjects = Project::where('status', 'approved')->count(); // Count of active/approved projects
        $pendingProjects = $projects->count(); // Count of pending projects

        return view('admin.project-approval', compact('projects', 'activeProjects', 'pendingProjects'));
    }

    public function approve($id)
    {
        $project = Project::findOrFail($id);
        $project->update(['status' => 'approved']);

        return redirect()->back()->with('success', 'Project approved successfully!');
    }

    public function decline($id)
    {
        $project = Project::findOrFail($id);
        $project->update(['status' => 'declined']);

        return redirect()->back()->with('success', 'Project declined successfully!');
    }
}
