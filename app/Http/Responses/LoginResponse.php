<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        $user = $request->user();

        switch ($user->user_type) {
            case 'admin':
                return redirect()->intended('/admin');
            case 'business_owner':
                return redirect()->intended('/business');
            case 'ofw':
            default:
                return redirect()->intended('/dashboard');
        }
    }
}
