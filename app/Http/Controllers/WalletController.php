<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    //
    public function showAddFunds()
{
    return view('add-funds');
}

public function addFunds(Request $request)
{
    $request->validate([
        'amount' => 'required|numeric|min:1',
    ]);

    $wallet = Auth::user()->wallet;

    // Update balance
    $wallet->balance += $request->amount;
    $wallet->save();

    // Log the transaction
    $wallet->transactions()->create([
        'type' => 'add',
        'amount' => $request->amount,
        'description' => 'User added funds.',
    ]);

    return redirect()->route('dashboard')->with('success', 'Funds added successfully!');
}

}
