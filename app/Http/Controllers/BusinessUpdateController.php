<?php

namespace App\Http\Controllers;

use App\Models\BusinessUpdate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BusinessUpdateController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('updates', 'public');
        }

        $update = BusinessUpdate::create([
            'user_id' => Auth::id(),
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
                'created_at' => $update->created_at->diffForHumans(),
            ]
        ]);
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
    }
}
