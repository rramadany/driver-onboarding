<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Activitylog\Models\Activity;

class AuditLogController extends Controller
{
    public function index(): View
    {
        $activities = Activity::with('causer', 'subject')
            ->latest()
            ->paginate(20);

        return view('admin.audit-logs.index', ['activities' => $activities]);
    }
}
