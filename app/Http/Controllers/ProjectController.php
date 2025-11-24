<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function create()
    {
        return view('business.add-project');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,jpg,png,gif,webp,pdf|max:5120',
            'target_amount' => 'required|numeric|min:1',
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
}
