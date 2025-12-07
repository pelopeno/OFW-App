<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;

class MonitoringController extends Controller
{
    public function index()
    {
        // Get all logs, newest first
        $logs = ActivityLog::latest()->paginate(10);

        return view('admin.monitoring', compact('logs'));
    }
}
