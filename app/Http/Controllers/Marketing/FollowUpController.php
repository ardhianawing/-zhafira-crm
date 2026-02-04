<?php

namespace App\Http\Controllers\Marketing;

use App\Enums\StatusProspek;
use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Services\FollowUpService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FollowUpController extends Controller
{
    public function __construct(
        private FollowUpService $followUpService
    ) {}

    public function todaysTasks(): View
    {
        $leads = Lead::assignedTo(auth()->id())
            ->todaysTasks()
            ->orderBy('tgl_next_followup', 'asc')
            ->get();

        $statuses = StatusProspek::cases();

        return view('marketing.tasks.today', compact('leads', 'statuses'));
    }

    public function complete(Request $request, Lead $lead): RedirectResponse
    {
        // Authorization
        if ($lead->assigned_to !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke lead ini.');
        }

        $validated = $request->validate([
            'catatan' => 'nullable|string',
            'status_prospek' => 'required|in:New,Cold,Warm,Hot,Deal',
            'tgl_next_followup' => 'nullable|date|after_or_equal:today',
        ], [
            'status_prospek.required' => 'Status prospek wajib dipilih.',
            'tgl_next_followup.after_or_equal' => 'Tanggal follow-up harus hari ini atau setelahnya.',
        ]);

        $this->followUpService->completeFollowUp($lead, $validated, auth()->id());

        return back()->with('success', "Follow-up untuk {$lead->nama_customer} berhasil diselesaikan.");
    }
}
