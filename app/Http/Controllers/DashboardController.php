<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
     public function index()
    {
        $user = Auth::user();

        // Wallet balance
        $wallet = $user->wallet;

        // Latest saving goal
        //$goal = $user->goals()->latest()->first();

        return view('dashboard', compact('wallet'));
    }
}
