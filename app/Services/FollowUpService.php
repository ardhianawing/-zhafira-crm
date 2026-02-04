<?php

namespace App\Services;

use App\Models\Lead;
use App\Models\LeadHistory;
use Carbon\Carbon;

class FollowUpService
{
    /**
     * Follow-up cycle days:
     * Fase 0 -> +3 days -> Fase 1
     * Fase 1 -> +5 days -> Fase 2
     * Fase 2 -> +7 days -> Fase 3
     * Fase 3 -> Manual input required
     */
    private const CYCLE_DAYS = [
        0 => 3,
        1 => 5,
        2 => 7,
    ];

    public function completeFollowUp(Lead $lead, array $data, int $userId): Lead
    {
        $oldValues = $lead->toArray();

        $updateData = [
            'catatan_terakhir' => $data['catatan'] ?? $lead->catatan_terakhir,
            'status_prospek' => $data['status_prospek'] ?? $lead->status_prospek,
        ];

        // Calculate next follow-up date based on fase
        if ($lead->fase_followup < 3) {
            $daysToAdd = self::CYCLE_DAYS[$lead->fase_followup] ?? 7;
            $updateData['tgl_next_followup'] = Carbon::today()->addDays($daysToAdd);
            $updateData['fase_followup'] = $lead->fase_followup + 1;
        } else {
            // Fase 3: Require manual date input
            if (isset($data['tgl_next_followup']) && $data['tgl_next_followup']) {
                $updateData['tgl_next_followup'] = $data['tgl_next_followup'];
            }
            // Stay at fase 3
        }

        $lead->update($updateData);

        // Log the follow-up completion
        LeadHistory::create([
            'lead_id' => $lead->id,
            'user_id' => $userId,
            'action' => 'followup_completed',
            'old_values' => $oldValues,
            'new_values' => $lead->fresh()->toArray(),
        ]);

        return $lead->fresh();
    }

    public function getWhatsAppTemplate(Lead $lead): string
    {
        $templates = [
            0 => "Halo {$lead->nama_customer}, saya dari Zhafira Villa. Terima kasih telah menghubungi kami. Apakah ada yang bisa saya bantu mengenai villa kami?",
            1 => "Halo {$lead->nama_customer}, ini follow-up dari Zhafira Villa. Apakah sudah sempat melihat info villa kami? Ada pertanyaan yang bisa saya bantu?",
            2 => "Halo {$lead->nama_customer}, sekedar mengingatkan mengenai villa kami. Jika berminat, kami sedang ada promo menarik. Silakan hubungi saya untuk info lebih lanjut.",
            3 => "Halo {$lead->nama_customer}, semoga dalam keadaan baik. Jika masih tertarik dengan villa kami, silakan hubungi saya kapan saja. Terima kasih.",
        ];

        return $templates[$lead->fase_followup] ?? $templates[3];
    }

    public function getNextFollowUpDays(int $fase): ?int
    {
        return self::CYCLE_DAYS[$fase] ?? null;
    }
}
