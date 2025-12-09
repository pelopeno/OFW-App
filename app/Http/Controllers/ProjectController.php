<?php

namespace App\Http\Controllers;
use App\Helpers\ActivityLogger;
use App\Models\Project;
use App\Models\Investment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function create()
    {
        return view('business.add-project');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:25',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,jpg,png,gif,webp,pdf|max:5120',
            'target_amount' => 'required|numeric|min:1|max:1000000',
        ], [
            'title.required' => 'Project title is required.',
            'title.max' => 'Project title cannot exceed 25 characters.',
            'description.required' => 'Project description is required.',
            'image.required' => 'Project image is required.',
            'image.image' => 'The file must be an image.',
            'image.mimes' => 'Image must be a file of type: jpeg, jpg, png, gif, webp, or pdf.',
            'image.max' => 'Image size cannot exceed 5MB.',
            'target_amount.required' => 'Target amount is required.',
            'target_amount.numeric' => 'Target amount must be a valid number.',
            'target_amount.min' => 'Target amount must be at least ₱1.',
            'target_amount.max' => 'Target amount cannot exceed ₱1,000,000.',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('projects', 'public');
        }

        Project::create([
            'user_id' => Auth::id(),
            'project_name' => $request->title, // Added this line to set project_name. Temporary lang.
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imagePath,
            'target_amount' => $request->target_amount,
            'current_amount' => 0,
            'status' => 'pending',
        ]);

        ActivityLogger::log(
            module: 'PROJECT',
            action: 'create_project',
            details: "Created new project: {$request->title}",
            data: [
                'title' => $request->title,
                'target_amount' => $request->target_amount,
            ]
        );

        return redirect()->route('business-dashboard')->with('success', 'Project created successfully!');
    }

    public function show($id)
    {
        $project = Project::with('user')->findOrFail($id);
        return view('project', compact('project'));
    }

    public function edit($id)
    {
        $project = Project::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('business.edit-project', compact('project'));
    }

    public function update(Request $request, $id)
    {
        $project = Project::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $request->validate([
            'title' => 'required|string|max:25',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp,pdf|max:5120',
            'target_amount' => 'required|numeric|min:1|max:1000000',
        ], [
            'title.required' => 'Project title is required.',
            'title.max' => 'Project title cannot exceed 25 characters.',
            'description.required' => 'Project description is required.',
            'image.image' => 'The file must be an image.',
            'image.mimes' => 'Image must be a file of type: jpeg, jpg, png, gif, webp, or pdf.',
            'image.max' => 'Image size cannot exceed 5MB.',
            'target_amount.required' => 'Target amount is required.',
            'target_amount.numeric' => 'Target amount must be a valid number.',
            'target_amount.min' => 'Target amount must be at least ₱1.',
            'target_amount.max' => 'Target amount cannot exceed ₱1,000,000.',
        ]);

        $project->title = $request->title;
        $project->description = $request->description;
        $project->target_amount = $request->target_amount;

        if ($request->hasFile('image')) {
            // Delete old image
            if ($project->image) {
                Storage::disk('public')->delete($project->image);
            }
            $project->image = $request->file('image')->store('projects', 'public');
        }

        $project->save();

        ActivityLogger::log(
            module: 'PROJECT',
            action: 'update_project',
            referenceId: $project->id,
            details: "Updated project: {$project->title}",
            data: [
                'project_id' => $project->id,
                'title' => $project->title,
                'target_amount' => $project->target_amount,
            ]
        );

        return redirect()->route('business-dashboard')->with('success', 'Project updated successfully!');
    }

    public function destroy($id)
    {
        $project = Project::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Delete project image
        if ($project->image) {
            Storage::disk('public')->delete($project->image);
        }

        $project->delete();

        ActivityLogger::log(
            module: 'PROJECT',
            action: 'delete_project',
            referenceId: $project->id,
            details: "Deleted project: {$project->title}",
            data: [
                'project_id' => $project->id,
                'title' => $project->title,
            ]
        );

        return redirect()->route('business-dashboard')->with('success', 'Project deleted successfully!');
    }

    public function requestArchive($id)
    {
        $project = Project::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Check if already requested
        if ($project->archive_requested) {
            return back()->with('error', 'Archive already requested for this project.');
        }

        $project->update([
            'archive_requested' => true,
            'archive_requested_at' => now(),
        ]);

        ActivityLogger::log(
            module: 'PROJECT',
            action: 'request_archive',
            referenceId: $project->id,
            details: "Requested archive for project: {$project->title}",
            data: [
                'project_id' => $project->id,
                'title' => $project->title,
            ]
        );

        return back()->with('success', 'Archive request submitted! Waiting for admin to disable the project.');
    }

    public function archive($id)
    {
        $project = Project::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Check if archive was requested and project is disabled
        if (!$project->archive_requested || $project->status !== 'disabled') {
            return back()->with('error', 'Project cannot be archived. Please request archive first.');
        }

        // Soft delete the project
        $project->delete();

        ActivityLogger::log(
            module: 'PROJECT',
            action: 'archive_project',
            referenceId: $project->id,
            details: "Archived project: {$project->title}",
            data: [
                'project_id' => $project->id,
                'title' => $project->title,
            ]
        );

        return redirect()->route('business-dashboard')->with('success', 'Project archived successfully!');
    }

    public function viewArchived()
    {
        $archivedProjects = Project::onlyTrashed()
            ->where('user_id', Auth::id())
            ->latest('deleted_at')
            ->get();

        return view('business.archived-projects', compact('archivedProjects'));
    }

    public function permanentDelete($id)
    {
        $project = Project::onlyTrashed()
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Delete project image
        if ($project->image) {
            Storage::disk('public')->delete($project->image);
        }

        $projectTitle = $project->title;
        $project->forceDelete();

        ActivityLogger::log(
            module: 'PROJECT',
            action: 'permanent_delete_project',
            referenceId: $id,
            details: "Permanently deleted project: {$projectTitle}",
            data: [
                'project_id' => $id,
                'title' => $projectTitle,
            ]
        );

        return back()->with('success', 'Project permanently deleted!');
    }

    public function restore($id)
    {
        $project = Project::onlyTrashed()
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $project->restore();
        $project->update([
            'archive_requested' => false,
            'archive_requested_at' => null,
        ]);

        ActivityLogger::log(
            module: 'PROJECT',
            action: 'restore_project',
            referenceId: $project->id,
            details: "Restored project: {$project->title}",
            data: [
                'project_id' => $project->id,
                'title' => $project->title,
            ]
        );

        return back()->with('success', 'Project restored successfully!');
    }

    public function donate(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required|numeric|min:100',
        ], [
            'amount.required' => 'Please enter an amount to invest.',
            'amount.numeric' => 'Amount must be a valid number.',
            'amount.min' => 'Minimum investment is ₱100.',
        ]);

        $project = Project::findOrFail($id);
        $wallet = Auth::user()->wallet;

        // Check if wallet has sufficient balance
        if ($request->amount > $wallet->balance) {
            return redirect()->route('marketplace')->withErrors([
                'amount' => 'Insufficient wallet balance. Your current balance is ₱'
                    . number_format($wallet->balance, 2),
            ]);
        }

        if ($request->amount + $project->current_amount > $project->target_amount) {
            return redirect()->route('marketplace')->withErrors([
                'amount' => 'Investment exceeds project target amount. The maximum you can invest is ₱'
                    . number_format($project->target_amount - $project->current_amount, 2),
            ]);
        }
        
        // Deduct from wallet
        $wallet->balance -= $request->amount;
        $wallet->save();

        // Add to project
        $project->current_amount += $request->amount;
        $project->save();

        // Log wallet transaction
        $wallet->transactions()->create([
            'type' => 'deduct',
            'amount' => $request->amount,
            'description' => "Invested to project: {$project->title}",
        ]);

        Investment::create([
            'user_id' => Auth::id(),
            'project_id' => $project->id,
            'amount' => $request->amount,
        ]);

        ActivityLogger::log(
            module: 'PROJECT_DONATION',
            action: 'donate',
            referenceId: $project->id,
            details: "Donated ₱{$request->amount} to project: {$project->title}",
            data: [
                'project_id' => $project->id,
                'title' => $project->title,
                'amount' => $request->amount,
            ]
        );

        return redirect()->route('marketplace')->with('success', 'Thank you for your donation!');
    }
}
