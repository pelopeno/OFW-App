<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\RegisterResponse;

class CustomRegisterResponse implements RegisterResponse
{
    public function toResponse($request)
    {
        // Do NOT log the user in.
        // Simply redirect wherever you want after registration.
        return redirect()->route('landing')->with('status', 'Account created. Please log in.');
    }
}