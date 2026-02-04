<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\WhatsappTemplate;
use App\Enums\StatusProspek;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LeadController extends Controller
{
    public function index(Request $request): View
    {
        $userId = auth()->id();
        $statuses = StatusProspek::cases();

        $leads = Lead::assignedTo($userId)
            ->when($request->search, function ($query, $search) {
                return $query->where(function($q) use ($search) {
                    $q->where('nama_customer', 'like', "%{$search}%")
                      ->orWhere('no_hp', 'like', "%{$search}%");
                });
            })
            ->when($request->status, function ($query, $status) {
                return $query->where('status_prospek', $status);
            })
            ->orderByRaw("CASE WHEN status_prospek = 'Hot' THEN 0 ELSE 1 END")
            ->orderBy('tgl_next_followup', 'asc')
            ->paginate(15)
            ->withQueryString();

        return view('marketing.leads.index', compact('leads', 'statuses'));
    }

    public function create(): View
    {
        $statuses = StatusProspek::cases();
        return view('marketing.leads.create', compact('statuses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_customer' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'status_prospek' => 'required|string',
            'catatan_terakhir' => 'nullable|string',
        ]);

        $validated['assigned_to'] = auth()->id();
        $validated['assigned_at'] = now();
        $validated['fase_followup'] = 0;
        $validated['tgl_next_followup'] = now()->addDays(3);

        $lead = Lead::create($validated);

        // Record history
        $lead->histories()->create([
            'user_id' => auth()->id(),
            'action' => 'created',
            'new_values' => $lead->toArray(),
        ]);

        return redirect()->route('marketing.leads.index')->with('success', 'Lead berhasil dibuat.');
    }

    public function show(Lead $lead): View
    {
        if ($lead->assigned_to !== auth()->id()) {
            abort(403);
        }
        
        $lead->load(['histories.user']);
        $whatsappTemplates = WhatsappTemplate::active()->ordered()->get();
        $statuses = StatusProspek::cases();

        return view('marketing.leads.show', compact('lead', 'whatsappTemplates', 'statuses'));
    }

    public function update(Request $request, Lead $lead)
    {
        if ($lead->assigned_to !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'nama_customer' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'status_prospek' => 'required|string',
            'catatan_terakhir' => 'nullable|string',
        ]);

        $oldValues = $lead->toArray();
        $lead->update($validated);

        // Record history
        $lead->histories()->create([
            'user_id' => auth()->id(),
            'action' => 'updated',
            'old_values' => $oldValues,
            'new_values' => $lead->fresh()->toArray(),
        ]);

        return redirect()->route('marketing.leads.show', $lead)->with('success', 'Lead berhasil diupdate.');
    }
}