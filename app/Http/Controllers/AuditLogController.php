<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function index()
    {
        $logs = AuditLog::orderBy('created_at', 'desc')->paginate(20);
        return view('audit.index', compact('logs'));
    }
}