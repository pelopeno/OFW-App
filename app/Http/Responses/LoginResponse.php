<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        $user = $request->user();

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
