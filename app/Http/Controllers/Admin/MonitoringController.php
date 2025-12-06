<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Log;

class MonitoringController extends Controller
{
    public function index()
    {
        // Get all logs, newest first
        $logs = Log::with('user')->orderBy('created_at', 'desc')->get();

        // Pass logs to view
        return view('admin.monitoring', compact('logs'));
    }
}
