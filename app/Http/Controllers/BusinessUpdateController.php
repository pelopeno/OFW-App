<?php

namespace App\Http\Controllers;

use App\Models\BusinessUpdate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Helpers\ActivityLogger;

class BusinessUpdateController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'project_id' => 'required|exists:projects,id',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('updates', 'public');
        }

        $update = BusinessUpdate::create([
            'user_id' => Auth::id(),
            'project_id' => $request->project_id,
            'content' => $request->content,
            'image' => $imagePath,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Update posted successfully!',
            'update' => [
                'id' => $update->id,
                'content' => $update->content,
                'image' => $imagePath,
                'project_id' => $update->project_id,
                'created_at' => $update->created_at->diffForHumans(),
            ]
        ]);

        ActivityLogger::log(
            module: 'BUSINESS_UPDATE',
            action: 'create_update',
            referenceId: $update->id,
            details: "Created business update for project ID: {$request->project_id}",
            data: [
                'update_id' => $update->id,
                'project_id' => $request->project_id,
            ]
        );
    }

    public function destroy($id)
    {
        $update = BusinessUpdate::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Delete image file if exists
        if ($update->image) {
            Storage::disk('public')->delete($update->image);
        }

        $update->delete();

        return response()->json([
            'success' => true,
            'message' => 'Update deleted successfully!'
        ]);

        ActivityLogger::log(
            module: 'BUSINESS_UPDATE',
            action: 'delete_update',
            referenceId: $id,
            details: "Deleted business update ID: {$id}",
            data: [
                'update_id' => $id,
            ]
        );
    }
}
