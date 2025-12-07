<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Goal;

class GoalController extends Controller
{
    public function showGoals()
    {
        $goals = Auth::user()->goals;

        return view('saving-goals', compact('goals'));
    }

    public function store(Request $request)
    {
        $wallet = Auth::user()->wallet;

        $request->validate([
            'name' => 'required|string|min:1|max:20',
            'target_amount' => 'required|numeric|min:1',
            'current_amount' => 'nullable|numeric|min:0',
        ]);

        if ($request->current_amount && $request->current_amount > $wallet->balance) {
            return redirect()->back()->withErrors(['current_amount' => 'Insufficient wallet balance. Your balance is ₱' . number_format($wallet->balance, 2)])->withInput();
        }

        if ($request->current_amount > $request->target_amount) {
            return redirect()->back()->withErrors(['current_amount' => 'Current amount cannot exceed target amount.'])->withInput();
        }

        if ($request->current_amount) {
            // Deduct from wallet if initial amount is provided
            $wallet->balance -= $request->current_amount;
            $wallet->save();
        }

        Goal::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'target_amount' => $request->target_amount,
            'current_amount' => $request->current_amount ?? 0,
        ]);
        
        $wallet->transactions()->create([
            'type' => 'deduct',
            'amount' => $request->current_amount ?? 0,
            'description' => 'Initial amount allocated to new saving goal: ' . $request->name,
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
        $user = Auth::user();

        // Check if user has a wallet
        $wallet = $user->wallet;
        if (!$wallet) {
            return back()->withErrors(['amount' => 'Wallet not found. Please set up your wallet first.']);
        }

        // Fetch goal and ensure it belongs to the logged-in user
        $goal = Goal::where('id', $id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        $remainingNeeded = $goal->target_amount - $goal->current_amount;

        // Prevent allocating to a completed goal
        if ($remainingNeeded <= 0) {
            return back()->withErrors(['amount' => 'This goal is already completed.']);
        }

        // Validate input
        $request->validate([
            'amount' => [
                'required',
                'numeric',
                'min:0.01',
                function ($attribute, $value, $fail) use ($wallet, $remainingNeeded) {
                    if ($value > $wallet->balance) {
                        $fail('Insufficient wallet balance.');
                    }
                    if ($value > $remainingNeeded) {
                        $fail('Amount exceeds the remaining needed (₱' . number_format($remainingNeeded, 2) . ').');
                    }
                }
            ]
        ], [
            'amount.required' => 'Please enter an amount to allocate.',
            'amount.numeric' => 'Amount must be a valid number.',
            'amount.min' => 'Amount must be at least ₱0.01.',
        ]);

        // Convert to float with proper precision
        $amount = round($request->amount, 2);

        // Deduct from wallet
        $wallet->balance -= $amount;
        $wallet->save();

        // Add to goal
        $goal->current_amount += $amount;
        $goal->save();

        // Check if goal is now completed
        $completionMessage = "";
        if ($goal->current_amount >= $goal->target_amount) {
            $completionMessage = " Goal '{$goal->name}' has been completed!";
        }

        $wallet->transactions()->create([
            'type' => 'deduct',
            'amount' => $amount,
            'description' => 'Allocated funds to saving goal: ' . $goal->name,
        ]);

        return redirect()
            ->route('saving-goals')
            ->with('success', '₱' . number_format($amount, 2) . ' allocated to ' . $goal->name . ' successfully!' . $completionMessage);
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
