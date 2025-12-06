<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/project/{id}', function ($id) {
    $project = \App\Models\Project::with('user')->findOrFail($id);
    return response()->json($project);
});

Route::get('/project/{id}/updates', function ($id) {
    $updates = \App\Models\BusinessUpdate::where('project_id', $id)
        ->orderBy('created_at', 'desc')
        ->get()
        ->map(function ($update) {
            return [
                'id' => $update->id,
                'content' => $update->content,
                'image' => $update->image,
                'created_at' => $update->created_at->diffForHumans(),
            ];
        });
    
    return response()->json(['updates' => $updates]);
});
