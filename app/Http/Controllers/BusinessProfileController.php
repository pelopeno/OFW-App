<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Helpers\ActivityLogger;

class BusinessProfileController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'business_description' => 'nullable|string|max:1000',
        ]);

        $user = Auth::user();
        $user->business_description = $request->business_description;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully!',
            'business_description' => $user->business_description
        ]);

        ActivityLogger::log(
            module: 'BUSINESS_PROFILE',
            action: 'update_profile',
            details: "Updated business profile description",
            data: [
                'business_description' => $user->business_description,
            ]
        );
    }

    public function uploadProfilePicture(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,jpg,png,gif,webp|max:5120',
        ]);

        $user = Auth::user();

        // Delete old profile picture if exists
        if ($user->profile_picture) {
            Storage::disk('public')->delete($user->profile_picture);
        }

        // Store new profile picture
        $path = $request->file('profile_picture')->store('profiles', 'public');
        $user->profile_picture = $path;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Profile picture updated successfully!',
            'profile_picture_url' => Storage::url($path)
        ]);
    }
}
