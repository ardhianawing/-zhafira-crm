<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeadHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'lead_id',
        'user_id',
        'action',
        'old_values',
        'new_values',
    ];

    protected function casts(): array
    {
        return [
            'old_values' => 'array',
            'new_values' => 'array',
        ];
    }

    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getActionLabelAttribute(): string
    {
        return match($this->action) {
            'created' => 'Lead dibuat',
            'updated' => 'Lead diupdate',
            'assigned' => 'Lead di-assign',
            'transferred' => 'Lead ditransfer',
            'followup_completed' => 'Follow-up selesai',
            'status_changed' => 'Status berubah',
            default => $this->action,
        };
    }
}
