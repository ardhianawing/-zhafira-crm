@props(['lead', 'showActions' => true])

<div class="card lead-card {{ $lead->isOverdue() ? 'overdue' : '' }}">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-start mb-2">
            <div>
                <h6 class="card-title mb-1">
                    {{ $lead->nama_customer }}
                    
                    {{-- Tambahan: Ikon Api untuk Hot Lead --}}
                    @if($lead->status_prospek->value == 'Hot' || $lead->status_prospek == 'Hot')
                        <i class="bi bi-fire text-danger ms-1" title="HOT LEAD"></i>
                    @endif

                    {{-- Tambahan: Tanda Lead Operan --}}
                    @if($lead->isTransferred())
                        <span class="badge bg-warning text-dark ms-1" style="font-size: 0.65rem; padding: 2px 5px;">
                            <i class="bi bi-arrow-left-right"></i> OPERAN
                        </span>
                    @endif
                </h6>
                <small class="text-muted">{{ $lead->no_hp }}</small>
            </div>
            <x-badge-status :status="$lead->status_prospek" />
        </div>

        <div class="row g-2 mb-2">
            <div class="col-6">
                <small class="text-muted d-block">Fase Follow-up</small>
                <span class="badge bg-secondary">Fase {{ $lead->fase_followup }}</span>
            </div>
            <div class="col-6">
                <small class="text-muted d-block">Next Follow-up</small>
                @if($lead->tgl_next_followup)
                    <span class="{{ $lead->isOverdue() ? 'text-danger fw-bold' : '' }}">
                        {{ $lead->tgl_next_followup->format('d/m/Y') }}
                        @if($lead->isOverdue())
                            <i class="bi bi-exclamation-triangle-fill text-danger"></i>
                        @elseif($lead->isDueToday())
                            <span class="badge bg-warning text-dark">Hari ini</span>
                        @endif
                    </span>
                @else
                    <span class="text-muted">-</span>
                @endif
            </div>
        </div>

        @if($lead->catatan_terakhir)
            <div class="mb-2">
                <small class="text-muted d-block">Catatan Terakhir</small>
                <small>{{ Str::limit($lead->catatan_terakhir, 100) }}</small>
            </div>
        @endif

        @if($showActions)
            <div class="d-flex gap-2 mt-3">
                <x-whatsapp-button :phone="$lead->no_hp" class="btn-sm flex-fill">
                    Chat
                </x-whatsapp-button>
                <a href="{{ route('marketing.leads.show', $lead) }}" class="btn btn-sm flex-fill" style="border-color: #0f3d2e; color: #0f3d2e;">
                    <i class="bi bi-eye"></i> Detail
                </a>
            </div>
        @endif
    </div>
</div>