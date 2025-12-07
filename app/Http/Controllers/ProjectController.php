<?php

namespace App\Http\Controllers;

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
        'title' => $request->title,
        'description' => $request->description,
        'image' => $imagePath,
        'target_amount' => $request->target_amount,
        'current_amount' => 0,
        'status' => 'pending',
    ]);

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

        return redirect()->route('business-dashboard')->with('success', 'Project deleted successfully!');
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
            return back()->withErrors([
                'amount' => 'Insufficient wallet balance. Your current balance is ₱' 
                    . number_format($wallet->balance, 2),
            ]);
        }

        if($request->amount + $project->current_amount > $project->target_amount){
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

        return redirect()->route('marketplace')->with('success', 'Thank you for your donation!');
    }
}
