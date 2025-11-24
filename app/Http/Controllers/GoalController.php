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
            'name' => 'required',
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
        return view('allocate-funds', compact('goal'));
    }

    public function allocateFunds(Request $request, $id)
    {
        // Logic to allocate funds to the goal
        $request->validate([
        'amount' => 'required|numeric|min:1'
    ]);

    $wallet = Auth::user()->wallet;

    if ($request->amount > $wallet->balance) {
        return back()->withErrors(['amount' => 'Insufficient wallet balance.']);
    }
    $wallet->balance -= $request->amount;
    $wallet->save();
    $goal = Goal::findOrFail($id);
    $goal->current_amount += $request->amount;
    $goal->save();

    return redirect()->route('saving-goals')->with('success', 'Funds allocated successfully!');

    }

    public function withdrawForm($id)
    {
        $goal = Goal::findOrFail($id);
        return view('withdraw-funds', compact('goal'));
    }

    public function withdrawFunds(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1'
        ]);

        $goal = Goal::findOrFail($id);

        if ($request->amount > $goal->current_amount) {
            return back()->withErrors(['amount' => 'Insufficient goal funds.']);
        }

        $goal->current_amount -= $request->amount;
        $goal->save();

        $wallet = Auth::user()->wallet;
        $wallet->balance += $request->amount;
        $wallet->save();

        return redirect()->route('saving-goals')->with('success', 'Funds withdrawn successfully!');
    }
}
