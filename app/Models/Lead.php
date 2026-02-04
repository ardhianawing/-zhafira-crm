<?php

namespace App\Models;

use App\Enums\StatusProspek;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lead extends Model
{
    use HasFactory;

    protected $attributes = [
        'fase_followup' => 0,
        'status_prospek' => 'New',
    ];

    protected static function booted(): void
    {
        static::creating(function (Lead $lead) {
            if (!$lead->tgl_next_followup) {
                $lead->tgl_next_followup = now()->toDateString();
            }
        });

        static::updating(function (Lead $lead) {
            if ($lead->isDirty('assigned_to') && $lead->assigned_to !== null) {
                $lead->tgl_next_followup = now()->toDateString();
            }
        });
    }

    protected $fillable = [
        'nama_customer',
        'no_hp',
        'status_prospek',
        'fase_followup',
        'tgl_next_followup',
        'catatan_terakhir',
        'assigned_to',
        'assigned_at',
        'sumber_lead',
        'keterangan',
    ];

    protected function casts(): array
    {
        return [
            'status_prospek' => StatusProspek::class,
            'tgl_next_followup' => 'date',
            'assigned_at' => 'datetime',
            'fase_followup' => 'integer',
        ];
    }

    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function histories(): HasMany
    {
        return $this->hasMany(LeadHistory::class)->orderBy('created_at', 'desc');
    }

    // Fungsi Baru untuk Badge Operan
    public function isTransferred(): bool
    {
        return $this->histories()->where('action', 'transferred')->exists();
    }

    public function scopeUnassigned($query)
    {
        return $query->whereNull('assigned_to');
    }

    public function scopeAssignedTo($query, $userId)
    {
        return $query->where('assigned_to', $userId);
    }

    public function scopeTodaysTasks($query)
    {
        return $query->whereNotNull('tgl_next_followup')
            ->where('tgl_next_followup', '<=', now()->toDateString());
    }

    public function scopeOverdue($query)
    {
        return $query->whereNotNull('tgl_next_followup')
            ->where('tgl_next_followup', '<', now()->toDateString());
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status_prospek', $status);
    }

    public function getWhatsappUrlAttribute(): string
    {
        $phone = preg_replace('/[^0-9]/', '', $this->no_hp);
        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        } elseif (!str_starts_with($phone, '62')) {
            $phone = '62' . $phone;
        }
        return "https://wa.me/{$phone}";
    }

    public function getNormalizedPhoneAttribute(): string
    {
        $phone = preg_replace('/[^0-9]/', '', $this->no_hp);
        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        } elseif (!str_starts_with($phone, '62')) {
            $phone = '62' . $phone;
        }
        return $phone;
    }

    public function isOverdue(): bool
    {
        return $this->tgl_next_followup && $this->tgl_next_followup->lt(now()->startOfDay());
    }

    public function isDueToday(): bool
    {
        return $this->tgl_next_followup && $this->tgl_next_followup->isToday();
    }
}