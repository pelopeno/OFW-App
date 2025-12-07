<?php
namespace App\Helpers;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class ActivityLogger
{
    public static function log($module, $action, $referenceId = null, $details = null, $data = [])
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'module' => $module,
            'action' => $action,
            'reference_id' => $referenceId,
            'details' => $details,
            'data' => $data,
        ]);
    }
}
