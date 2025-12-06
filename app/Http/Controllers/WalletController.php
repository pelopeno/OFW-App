<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    //wala na 'to since naka modal na
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

    //wala na 'to since naka modal na
    public function showWithdrawFunds()
    {
        $wallet = Auth::user()->wallet;

        return view('withdraw-wallet', compact('wallet'));
    }

    public function withdrawWallet(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:500|max:50000',
            'password' => 'required',
        ], [
            'amount.required' => 'Enter the amount you want to withdraw.',
            'amount.numeric'  => 'Amount must be a valid number.',
            'amount.min'      => 'Minimum withdrawal is ₱500.',
            'amount.max'      => 'Maximum withdrawal per transaction is ₱50,000.',
            'password.required' => 'Please enter your password to confirm.',
        ]);

        $user = Auth::user();
        if (!password_verify($request->password, $user->password)) {
            return back()->withErrors([
                'password' => 'The provided password is incorrect.',
            ]);
        }
        $wallet = $user->wallet;

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

    public function transactionHistory()
    {
        $wallet = Auth::user()->wallet;
        $transactions = $wallet->transactions()->orderBy('created_at', 'desc')->paginate(10);

        return view('transaction-history', compact('transactions'));
    }
}
