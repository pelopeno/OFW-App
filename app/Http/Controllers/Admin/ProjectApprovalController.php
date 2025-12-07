<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Helpers\ActivityLogger;

class ProjectApprovalController extends Controller
{
    public function index()
    {
        $projects = Project::where('status', 'pending')->get();
        $activeProjects = Project::where('status', 'approved')->count(); 
        $pendingProjects = $projects->count(); 

        return view('admin.project-approval', compact('projects', 'activeProjects', 'pendingProjects'));
    }

    public function approve($id)
    {
        $project = Project::findOrFail($id);
        $project->update(['status' => 'approved']);

        ActivityLogger::log(
            module: 'PROJECT_APPROVAL',
            action: 'approve_project',
            referenceId: $project->id,
            details: "Approved project: {$project->title}",
            data: [
                'project_id' => $project->id,
                'title' => $project->title,
            ]
        );

        return redirect()->back()->with('success', 'Project approved successfully!');
    }

    public function decline($id)
    {
        $project = Project::findOrFail($id);
        $project->update(['status' => 'declined']);

        ActivityLogger::log(
            module: 'PROJECT_APPROVAL',
            action: 'decline_project',
            referenceId: $project->id,
            details: "Declined project: {$project->title}",
            data: [
                'project_id' => $project->id,
                'title' => $project->title,
            ]
        );

        return redirect()->back()->with('success', 'Project declined successfully!');
    }
}
