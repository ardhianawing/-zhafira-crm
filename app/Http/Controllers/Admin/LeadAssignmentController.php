<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Http\Request;

class LeadAssignmentController extends Controller
{
    public function index(Request $request)
    {
        // Menangkap jumlah baris dari URL (?per_page=50)
        $perPage = (int) $request->input('per_page', 50);

        $marketingUsers = User::where('role', 'marketing')
            ->where('is_active', true)
            ->withCount('leads')
            ->get();

        $unassignedLeads = Lead::whereNull('assigned_to')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage, ['*'], 'unassigned_page')
            ->appends(['per_page' => $perPage]);

        $assignedLeads = Lead::whereNotNull('assigned_to')
            ->with('assignedUser')
            ->when($request->marketing_filter, function ($query) use ($request) {
                return $query->where('assigned_to', $request->marketing_filter);
            })
            ->orderByRaw("CASE WHEN status_prospek = 'Hot' THEN 0 ELSE 1 END")
            ->orderBy('assigned_at', 'desc')
            ->paginate($perPage, ['*'], 'assigned_page')
            ->appends([
                'per_page' => $perPage,
                'marketing_filter' => $request->marketing_filter
            ]);

        $rotatorEnabled = \App\Models\AppSetting::isRotatorEnabled();

        return view('admin.assignment.index', compact('marketingUsers', 'unassignedLeads', 'assignedLeads', 'perPage', 'rotatorEnabled'));
    }

    public function assignSingle(Request $request, Lead $lead)
    {
        $request->validate([
            'marketing_id' => 'required|exists:users,id'
        ]);

        $lead->update([
            'assigned_to' => $request->marketing_id,
            'assigned_at' => now(),
        ]);

        return back()->with('success', 'Lead berhasil di-assign.');
    }

    public function assignBulk(Request $request)
    {
        $request->validate([
            'lead_ids' => 'required|array',
            'marketing_id' => 'required|exists:users,id'
        ]);

        Lead::whereIn('id', $request->lead_ids)
            ->update([
                'assigned_to' => $request->marketing_id,
                'assigned_at' => now()
            ]);

        return back()->with('success', count($request->lead_ids) . ' lead berhasil di-assign.');
    }

    public function transferBulk(Request $request)
    {
        $request->validate([
            'lead_ids' => 'required|array',
            'marketing_id' => 'required|exists:users,id'
        ]);

        Lead::whereIn('id', $request->lead_ids)
            ->update([
                'assigned_to' => $request->marketing_id,
                'assigned_at' => now()
            ]);

        return back()->with('success', count($request->lead_ids) . ' lead berhasil ditransfer.');
    }

    public function deleteBulk(Request $request)
    {
        $request->validate([
            'lead_ids' => 'required|array'
        ]);

        Lead::whereIn('id', $request->lead_ids)->delete();

        return back()->with('success', count($request->lead_ids) . ' lead berhasil dihapus.');
    }

    public function toggleRotator()
    {
        $current = \App\Models\AppSetting::isRotatorEnabled();
        \App\Models\AppSetting::setValue('lead_rotator_enabled', $current ? 'false' : 'true');

        return back()->with('success', 'Lead rotator ' . ($current ? 'dinonaktifkan' : 'diaktifkan') . '.');
    }
}