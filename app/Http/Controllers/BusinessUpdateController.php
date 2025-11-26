<?php

namespace App\Http\Controllers;

use App\Models\BusinessUpdate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BusinessUpdateController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $update = BusinessUpdate::create([
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Update posted successfully!',
            'update' => [
                'id' => $update->id,
                'content' => $update->content,
                'created_at' => $update->created_at->diffForHumans(),
            ]
        ]);
    }

    public function destroy($id)
    {
        $update = BusinessUpdate::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $update->delete();

        return response()->json([
            'success' => true,
            'message' => 'Update deleted successfully!'
        ]);
    }
}
