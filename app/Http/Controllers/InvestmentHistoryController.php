<?php

namespace App\Http\Controllers;

use App\Models\Investment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvestmentHistoryController extends Controller
{
    //
    public function index()
    {
                $investments = Investment::where('user_id', Auth::id())
                        ->with('project')
                        ->latest()
                        ->paginate(3);

        return view('investment-history', compact('investments'));
    }
    }
