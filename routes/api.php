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
