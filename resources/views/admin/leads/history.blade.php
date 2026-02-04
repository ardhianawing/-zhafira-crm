@extends('layouts.app')

@section('title', 'History Lead - Zhafira CRM')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">
                <i class="bi bi-clock-history" style="color: #0f3d2e;"></i> History Lead
            </h4>
            <a href="{{ route('admin.leads.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

        <!-- Lead Info Card -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5>{{ $lead->nama_customer }}</h5>
                        <p class="mb-1">
                            <i class="bi bi-phone"></i> {{ $lead->no_hp }}
                            <x-whatsapp-button :phone="$lead->no_hp" class="btn-sm ms-2" />
                        </p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <x-badge-status :status="$lead->status_prospek" />
                        <span class="badge bg-secondary ms-1">Fase {{ $lead->fase_followup }}</span>
                        @if($lead->assignedUser)
                            <br>
                            <small class="text-muted">Marketing: {{ $lead->assignedUser->nama_lengkap }}</small>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- History Timeline -->
        <div class="card">
            <div class="card-header" style="background-color: #0f3d2e; color: #fff;">
                <i class="bi bi-list-ul"></i> Riwayat Perubahan
            </div>
            <div class="card-body">
                @forelse($lead->histories as $history)
                <div class="d-flex mb-4">
                    <div class="me-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background-color: #0f3d2e; color: #fff;">
                            @switch($history->action)
                                @case('created')
                                    <i class="bi bi-plus"></i>
                                    @break
                                @case('updated')
                                    <i class="bi bi-pencil"></i>
                                    @break
                                @case('assigned')
                                    <i class="bi bi-person-check"></i>
                                    @break
                                @case('followup_completed')
                                    <i class="bi bi-check2"></i>
                                    @break
                                @default
                                    <i class="bi bi-circle"></i>
                            @endswitch
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between">
                            <div>
                                <strong>{{ $history->action_label }}</strong>
                                @if($history->user)
                                    <span class="text-muted">oleh {{ $history->user->nama_lengkap }}</span>
                                @endif
                            </div>
                            <small class="text-muted">{{ $history->created_at->format('d/m/Y H:i') }}</small>
                        </div>

                        @if($history->action === 'assigned' && $history->new_values)
                            <div class="mt-2 p-2 bg-light rounded">
                                <small class="text-muted">Di-assign ke marketing ID: {{ $history->new_values['assigned_to'] ?? '-' }}</small>
                            </div>
                        @endif

                        @if($history->action === 'updated' && $history->old_values && $history->new_values)
                            <div class="mt-2 p-2 bg-light rounded">
                                <small>
                                    @php
                                        $changes = [];
                                        $trackFields = ['nama_customer', 'no_hp', 'status_prospek', 'fase_followup', 'tgl_next_followup', 'catatan_terakhir', 'assigned_to'];
                                        foreach ($trackFields as $field) {
                                            $old = $history->old_values[$field] ?? null;
                                            $new = $history->new_values[$field] ?? null;
                                            if ($old !== $new) {
                                                $changes[] = ucfirst(str_replace('_', ' ', $field)) . ": " . ($old ?: '(kosong)') . " → " . ($new ?: '(kosong)');
                                            }
                                        }
                                    @endphp
                                    @if(count($changes) > 0)
                                        @foreach($changes as $change)
                                            <div>{{ $change }}</div>
                                        @endforeach
                                    @else
                                        <span class="text-muted">Tidak ada perubahan terdeteksi</span>
                                    @endif
                                </small>
                            </div>
                        @endif

                        @if($history->action === 'followup_completed' && $history->new_values)
                            <div class="mt-2 p-2 bg-light rounded">
                                <small>
                                    <div>Fase: {{ $history->old_values['fase_followup'] ?? '?' }} → {{ $history->new_values['fase_followup'] ?? '?' }}</div>
                                    @if(isset($history->new_values['catatan_terakhir']))
                                        <div>Catatan: {{ $history->new_values['catatan_terakhir'] }}</div>
                                    @endif
                                </small>
                            </div>
                        @endif
                    </div>
                </div>
                @empty
                <div class="text-center py-4 text-muted">
                    <i class="bi bi-clock fs-3 d-block mb-2"></i>
                    Belum ada riwayat perubahan
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
