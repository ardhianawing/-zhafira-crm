<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\User;
use App\Enums\StatusProspek;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function index(Request $request)
    {
        $perPage = (int) $request->input('per_page', 50);
        
        $leads = Lead::with('assignedUser')
            ->when($request->search, function($query, $search) {
                return $query->where('nama_customer', 'like', "%{$search}%")
                             ->orWhere('no_hp', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate($perPage)
            ->appends(['per_page' => $perPage, 'search' => $request->search]);

        return view('admin.leads.index', compact('leads', 'perPage'));
    }

    public function create()
    {
        $statuses = StatusProspek::cases();
        $marketingUsers = User::marketing()->active()->get();
        return view('admin.leads.create', compact('statuses', 'marketingUsers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_customer' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'status_prospek' => 'required|string',
            'assigned_to' => 'nullable|exists:users,id',
            'fase_followup' => 'nullable|integer',
            'tgl_next_followup' => 'nullable|date',
            'catatan_terakhir' => 'nullable|string',
        ]);

        if (!empty($validated['assigned_to'])) {
            $validated['assigned_at'] = now();
        }

        $lead = Lead::create($validated);

        // Record history
        $lead->histories()->create([
            'user_id' => auth()->id(),
            'action' => 'created',
            'new_values' => $lead->toArray(),
        ]);

        return redirect()->route('admin.leads.index')->with('success', 'Lead berhasil ditambahkan.');
    }

    public function show(Lead $lead)
    {
        $lead->load(['assignedUser', 'histories.user']);
        return view('admin.leads.show', compact('lead'));
    }

    public function edit(Lead $lead)
    {
        $statuses = StatusProspek::cases();
        $marketingUsers = User::marketing()->active()->get();
        return view('admin.leads.edit', compact('lead', 'statuses', 'marketingUsers'));
    }

    public function update(Request $request, Lead $lead)
    {
        $validated = $request->validate([
            'nama_customer' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'status_prospek' => 'required|string',
            'assigned_to' => 'nullable|exists:users,id',
            'fase_followup' => 'nullable|integer',
            'tgl_next_followup' => 'nullable|date',
            'catatan_terakhir' => 'nullable|string',
        ]);

        $oldValues = $lead->toArray();
        
        if (isset($validated['assigned_to']) && $validated['assigned_to'] != $lead->assigned_to) {
            $validated['assigned_at'] = now();
        }

        $lead->update($validated);

        // Record history
        $lead->histories()->create([
            'user_id' => auth()->id(),
            'action' => 'updated',
            'old_values' => $oldValues,
            'new_values' => $lead->fresh()->toArray(),
        ]);

        return redirect()->route('admin.leads.index')->with('success', 'Lead berhasil diupdate.');
    }

    public function destroy(Lead $lead)
    {
        $lead->delete();
        return redirect()->route('admin.leads.index')->with('success', 'Lead berhasil dihapus.');
    }

    public function history(Lead $lead)
    {
        $lead->load(['histories.user']);
        return view('admin.leads.history', compact('lead'));
    }

    public function updateStatus(Request $request, Lead $lead)
    {
        $request->validate(['status' => 'required|string']);
        $oldStatus = $lead->status_prospek->value ?? $lead->status_prospek;
        $lead->update(['status_prospek' => $request->status]);

        $lead->histories()->create([
            'user_id' => auth()->id(),
            'action' => 'status_changed',
            'old_values' => ['status_prospek' => $oldStatus],
            'new_values' => ['status_prospek' => $request->status],
        ]);

        return back()->with('success', 'Status lead berhasil diupdate.');
    }
}