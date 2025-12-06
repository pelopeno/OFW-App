<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Illuminate\Support\Facades\Auth;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        $user = $request->user();

        // Check if user status is active
        if (strtolower($user->status) !== 'active') {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            return redirect()->route('login')
                ->with('error', 'Your account is ' . strtolower($user->status) . '. Please contact support.');
        }

        // Determine the redirect path based on user type
        $redirectPath = match ($user->user_type) {
            'admin' => '/admin',
            'business_owner' => '/business',
            'ofw' => '/dashboard',
            default => '/dashboard',
        };

        // Clear any intended URL to prevent redirect to previous page
        $request->session()->forget('url.intended');
        $request->session()->regenerate();
        
        return redirect()->to($redirectPath);
    }
}
