@extends('layouts.app')

@section('title', 'Detail Lead - Zhafira CRM')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">
                <i class="bi bi-person" style="color: #0f3d2e;"></i> Detail Lead
            </h4>
            <div>
                <a href="{{ route('admin.leads.edit', $lead) }}" class="btn" style="background-color: #0f3d2e; border-color: #0f3d2e; color: #fff;">
                    <i class="bi bi-pencil"></i> Edit
                </a>
                <a href="{{ route('admin.leads.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-header" style="background-color: #0f3d2e; color: #fff;">
                        <i class="bi bi-info-circle"></i> Informasi Lead
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless mb-0">
                            <tr>
                                <th width="40%">Nama Customer</th>
                                <td>{{ $lead->nama_customer }}</td>
                            </tr>
                            <tr>
                                <th>No HP</th>
                                <td>
                                    {{ $lead->no_hp }}
                                    <x-whatsapp-button :phone="$lead->no_hp" class="btn-sm ms-2" />
                                </td>
                            </tr>
                            <tr>
                                <th>Status Prospek</th>
                                <td><x-badge-status :status="$lead->status_prospek" /></td>
                            </tr>
                            <tr>
                                <th>Fase Follow-up</th>
                                <td><span class="badge bg-secondary">Fase {{ $lead->fase_followup }}</span></td>
                            </tr>
                            <tr>
                                <th>Next Follow-up</th>
                                <td>
                                    @if($lead->tgl_next_followup)
                                        <span class="{{ $lead->isOverdue() ? 'text-danger fw-bold' : '' }}">
                                            {{ $lead->tgl_next_followup->format('d/m/Y') }}
                                        </span>
                                        @if($lead->isOverdue())
                                            <span class="badge bg-danger ms-1">Overdue</span>
                                        @elseif($lead->isDueToday())
                                            <span class="badge bg-warning text-dark ms-1">Hari ini</span>
                                        @endif
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Marketing</th>
                                <td>
                                    @if($lead->assignedUser)
                                        {{ $lead->assignedUser->nama_lengkap }}
                                    @else
                                        <span class="text-warning">Belum di-assign</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Tanggal Assign</th>
                                <td>{{ $lead->assigned_at?->format('d/m/Y H:i') ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Dibuat</th>
                                <td>{{ $lead->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-header" style="background-color: #0f3d2e; color: #fff;">
                        <i class="bi bi-chat-left-text"></i> Catatan
                    </div>
                    <div class="card-body">
                        @if($lead->catatan_terakhir)
                            <p>{{ $lead->catatan_terakhir }}</p>
                        @else
                            <p class="text-muted">Belum ada catatan</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- History -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #0f3d2e; color: #fff;">
                <span><i class="bi bi-clock-history"></i> Riwayat Perubahan</span>
                <a href="{{ route('admin.leads.history', $lead) }}" class="btn btn-sm" style="background-color: #c9a227; border-color: #c9a227; color: #000;">Lihat Detail</a>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @forelse($lead->histories->take(5) as $history)
                    <div class="list-group-item">
                        <div class="d-flex justify-content-between">
                            <div>
                                <span class="badge bg-secondary">{{ $history->action_label }}</span>
                                @if($history->user)
                                    <small class="text-muted">oleh {{ $history->user->nama_lengkap }}</small>
                                @endif
                            </div>
                            <small class="text-muted">{{ $history->created_at->format('d/m/Y H:i') }}</small>
                        </div>
                    </div>
                    @empty
                    <div class="list-group-item text-center text-muted py-3">
                        Belum ada riwayat
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
