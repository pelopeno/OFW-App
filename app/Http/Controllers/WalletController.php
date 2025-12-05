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
            'amount' => 'required|numeric|min:500|max:100000',
        ], [
            'amount.required' => 'Enter the amount you want to Deposit.',
            'amount.numeric'  => 'Amount must be a valid number.',
            'amount.min'      => 'Minimum deposit is ₱500.',
            'amount.max'      => 'Maximum deposit per transaction is ₱100,000.',
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

    public function showWithdrawFunds()
    {
        $wallet = Auth::user()->wallet;

        return view('withdraw-wallet', compact('wallet'));
    }

    public function withdrawWallet(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:500|max:50000',
        ], [
            'amount.required' => 'Enter the amount you want to withdraw.',
            'amount.numeric'  => 'Amount must be a valid number.',
            'amount.min'      => 'Minimum withdrawal is ₱500.',
            'amount.max'      => 'Maximum withdrawal per transaction is ₱50,000.',
        ]);

        $wallet = Auth::user()->wallet;

        if ($request->amount > $wallet->balance) {
            return back()->withErrors([
                'amount' => 'Insufficient wallet balance. Your current balance is ₱'
                    . number_format($wallet->balance, 2),
            ]);
        }

        // Deduct the wallet
        $wallet->balance -= $request->amount;
        $wallet->save();

        // Log transaction
        $wallet->transactions()->create([
            'type' => 'deduct',
            'amount' => $request->amount,
            'description' => 'User withdrew funds.',
        ]);

        return redirect()->route('dashboard')->with('success', 'Funds withdrawn successfully!');
    }
}
