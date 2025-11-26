<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class MarketplaceController extends Controller
{
    //
    public function index()
    {
        $projects = Project::all();
        return view('marketplace', compact('projects'));
    }
}
