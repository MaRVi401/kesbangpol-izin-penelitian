<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LogKeamanan;
use App\Models\JejakAudit;
use Illuminate\Http\Request;

class SiemController extends Controller
{
    public function index()
    {
        $totalSuspicious = LogKeamanan::where('is_suspicious', true)->count();
        $recentFailedLogins = LogKeamanan::where('tipe_event', 'login_gagal')
                                         ->whereDate('created_at', today())
                                         ->count();

        return view('pages.super-admin.siem.index', compact('totalSuspicious', 'recentFailedLogins'));
    }

    public function securityLogs(Request $request)
    {
        $logs = LogKeamanan::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
            
        return view('pages.super-admin.siem.security_logs', compact('logs'));
    }

    public function auditTrails(Request $request)
    {
        $audits = JejakAudit::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $audits->getCollection()->transform(function ($audit) {
            $audit->data_lama = $this->sanitizePayload($audit->data_lama);
            $audit->data_baru = $this->sanitizePayload($audit->data_baru);
            return $audit;
        });
            
        return view('pages.super-admin.siem.audit_trails', compact('audits'));
    }

    private function sanitizePayload($payload)
    {
        if (!$payload) return null;
        
        $data = is_string($payload) ? json_decode($payload, true) : (array) $payload;
        $sanitized = [];

        foreach ($data as $key => $value) {
            if (in_array($key, ['password', 'remember_token', 'api_key', 'pin'])) {
                $sanitized[$key] = '***REDACTED***';
                continue;
            }

            if ($key === 'uuid' || str_ends_with($key, '_id') || in_array($key, ['created_at', 'updated_at'])) {
                continue; 
            }

            $sanitized[$key] = $value;
        }

        return $sanitized;
    }
}