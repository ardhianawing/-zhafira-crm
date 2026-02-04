@extends('layouts.app')

@section('title', 'Tugas Hari Ini - Zhafira CRM')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">
        <i class="bi bi-calendar-check" style="color: #0f3d2e;"></i> Tugas Follow-up Hari Ini
    </h4>
    <span class="badge fs-6" style="background-color: #0f3d2e; color: #fff;">{{ $leads->count() }} tugas</span>
</div>

@if($leads->count() > 0)
<div class="row">
    @foreach($leads as $lead)
    <div class="col-md-6 mb-4">
        <div class="card lead-card {{ $lead->isOverdue() ? 'overdue' : '' }}">
            <div class="card-header d-flex justify-content-between align-items-center">
                <strong>{{ $lead->nama_customer }}</strong>
                <x-badge-status :status="$lead->status_prospek" />
            </div>
            <div class="card-body">
                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <small class="text-muted d-block">No HP</small>
                        <span>{{ $lead->no_hp }}</span>
                    </div>
                    <div class="col-6">
                        <small class="text-muted d-block">Fase</small>
                        <span class="badge bg-secondary">Fase {{ $lead->fase_followup }}</span>
                    </div>
                    <div class="col-6">
                        <small class="text-muted d-block">Jadwal</small>
                        <span class="{{ $lead->isOverdue() ? 'text-danger fw-bold' : '' }}">
                            {{ $lead->tgl_next_followup->format('d/m/Y') }}
                            @if($lead->isOverdue())
                                <br><small class="text-danger">{{ $lead->tgl_next_followup->diffForHumans() }}</small>
                            @endif
                        </span>
                    </div>
                    <div class="col-6">
                        <small class="text-muted d-block">Next Cycle</small>
                        @if($lead->fase_followup < 3)
                            <span>+{{ [3,5,7][$lead->fase_followup] }} hari</span>
                        @else
                            <span class="text-warning">Manual</span>
                        @endif
                    </div>
                </div>

                @if($lead->catatan_terakhir)
                <div class="mb-3">
                    <small class="text-muted d-block">Catatan Terakhir</small>
                    <small>{{ Str::limit($lead->catatan_terakhir, 100) }}</small>
                </div>
                @endif

                <div class="d-flex gap-2 mb-3">
                    <x-whatsapp-button :phone="$lead->no_hp" class="btn-sm flex-fill">
                        Chat
                    </x-whatsapp-button>
                    <a href="{{ route('marketing.leads.show', $lead) }}" class="btn btn-sm flex-fill" style="border-color: #0f3d2e; color: #0f3d2e;">
                        <i class="bi bi-eye"></i> Detail
                    </a>
                </div>

                <!-- Complete Follow-up Form -->
                <form action="{{ route('marketing.tasks.complete', $lead) }}" method="POST" class="border-top pt-3">
                    @csrf

                    <div class="mb-2">
                        <label class="form-label small">Status Prospek Baru</label>
                        <select name="status_prospek" class="form-select form-select-sm" required>
                            @foreach($statuses as $status)
                                <option value="{{ $status->value }}" {{ $lead->status_prospek->value == $status->value ? 'selected' : '' }}>
                                    {{ $status->value }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-2">
                        <label class="form-label small">Catatan Follow-up</label>
                        <textarea name="catatan" class="form-control form-control-sm" rows="2" placeholder="Hasil follow-up..."></textarea>
                    </div>

                    @if($lead->fase_followup >= 3)
                    <div class="mb-2">
                        <label class="form-label small">Tanggal Follow-up Berikutnya</label>
                        <input type="date" name="tgl_next_followup" class="form-control form-control-sm"
                               min="{{ now()->format('Y-m-d') }}" value="{{ now()->addDays(7)->format('Y-m-d') }}">
                        <small class="text-muted">Wajib diisi untuk Fase 3</small>
                    </div>
                    @endif

                    <button type="submit" class="btn btn-success btn-sm w-100">
                        <i class="bi bi-check-circle"></i> Selesai Follow-up
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>
@else
<div class="card">
    <div class="card-body text-center py-5">
        <i class="bi bi-check-circle text-success fs-1 d-block mb-3"></i>
        <h5>Tidak ada tugas follow-up hari ini</h5>
        <p class="text-muted">Semua follow-up sudah dikerjakan atau belum ada jadwal untuk hari ini.</p>
        <a href="{{ route('marketing.leads.index') }}" class="btn" style="background-color: #0f3d2e; border-color: #0f3d2e; color: #fff;">
            <i class="bi bi-people"></i> Lihat Semua Leads
        </a>
    </div>
</div>
@endif
@endsection
