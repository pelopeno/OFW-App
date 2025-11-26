<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Goal;

class GoalController extends Controller
{
    public function index()
    {
        $goals = Auth::user()->goals;

        return view('goals.index', compact('goals'));
    }

    public function showGoals()
    {
        $goals = Auth::user()->goals;

        return view('saving-goals', compact('goals'));
    }

    public function create()
    {
        return view('add-goal');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'target_amount' => 'required|numeric|min:1',
            'current_amount' => 'nullable|numeric|min:0',
        ]);

        Goal::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'target_amount' => $request->target_amount,
            'current_amount' => $request->current_amount ?? 0,
        ]);

        return redirect()->route('saving-goals')->with('success', 'Saving goal created!');
    }

    public function showAllocateForm($id)
    {
        $goal = Goal::findOrFail($id);
        $wallet = Auth::user()->wallet;
        
        return view('allocate-funds', compact('goal', 'wallet'));
    }

    public function allocateFunds(Request $request, $id)
    {
        $wallet = Auth::user()->wallet;
        
        // Validate the input
        $request->validate([
            'amount' => [
                'required',
                'numeric',
                'min:0.01',
                'max:' . $wallet->balance, // Cannot allocate more than wallet balance
            ]
        ], [
            'amount.required' => 'Please enter an amount to allocate.',
            'amount.numeric' => 'Amount must be a valid number.',
            'amount.min' => 'Amount must be at least ₱0.01.',
            'amount.max' => 'Insufficient wallet balance. Your balance is ₱' . number_format($wallet->balance, 2),
        ]);

        $goal = Goal::findOrFail($id);

        // Deduct from wallet
        $wallet->balance -= $request->amount;
        $wallet->save();

        // Add to goal
        $goal->current_amount += $request->amount;
        $goal->save();

        return redirect()->route('saving-goals')->with('success', '₱' . number_format($request->amount, 2) . ' allocated to ' . $goal->name . ' successfully!');
    }

    public function withdrawForm($id)
    {
        $goal = Goal::findOrFail($id);
        
        return view('withdraw-funds', compact('goal'));
    }

    public function withdrawFunds(Request $request, $id)
    {
        $goal = Goal::findOrFail($id);

        // Validate the input
        $request->validate([
            'amount' => [
                'required',
                'numeric',
                'min:0.01',
                'max:' . $goal->current_amount, // Cannot withdraw more than goal balance
            ]
        ], [
            'amount.required' => 'Please enter an amount to withdraw.',
            'amount.numeric' => 'Amount must be a valid number.',
            'amount.min' => 'Amount must be at least ₱0.01.',
            'amount.max' => 'Insufficient goal funds. Available balance is ₱' . number_format($goal->current_amount, 2),
        ]);

        // Deduct from goal
        $goal->current_amount -= $request->amount;
        $goal->save();

        // Add to wallet
        $wallet = Auth::user()->wallet;
        $wallet->balance += $request->amount;
        $wallet->save();

        return redirect()->route('saving-goals')->with('success', '₱' . number_format($request->amount, 2) . ' withdrawn from ' . $goal->name . ' successfully!');
    }
}
