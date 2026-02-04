@extends('layouts.app')

@section('title', 'Leads Saya - Zhafira CRM')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">
        <i class="bi bi-people" style="color: #0f3d2e;"></i> Leads Saya
    </h4>
    <a href="{{ route('marketing.leads.create') }}" class="btn" style="background-color: #0f3d2e; border-color: #0f3d2e; color: #fff;">
        <i class="bi bi-plus-circle"></i> Tambah Lead
    </a>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Cari nama/no HP..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    @foreach($statuses as $status)
                        <option value="{{ $status->value }}" {{ request('status') == $status->value ? 'selected' : '' }}>
                            {{ $status->value }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn" style="background-color: #0f3d2e; border-color: #0f3d2e; color: #fff;">
                    <i class="bi bi-search"></i> Filter
                </button>
                <a href="{{ route('marketing.leads.index') }}" class="btn btn-outline-secondary">Reset</a>
            </div>
        </form>
    </div>
</div>

<!-- Leads List (Card View for Mobile) -->
<div class="d-md-none">
    @forelse($leads as $lead)
        <x-lead-card :lead="$lead" />
    @empty
    <div class="text-center py-5 text-muted">
        <i class="bi bi-inbox fs-1 d-block mb-3"></i>
        <p>Belum ada lead</p>
        <a href="{{ route('marketing.leads.create') }}" class="btn" style="background-color: #0f3d2e; border-color: #0f3d2e; color: #fff;">
            <i class="bi bi-plus-circle"></i> Tambah Lead Pertama
        </a>
    </div>
    @endforelse
</div>

<!-- Leads Table (Desktop) -->
<div class="card d-none d-md-block">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr style="background-color: #0f3d2e; color: #fff;">
                        <th style="background-color: #0f3d2e; color: #fff; font-weight: 500;">Nama Customer</th>
                        <th style="background-color: #0f3d2e; color: #fff; font-weight: 500;">No HP</th>
                        <th style="background-color: #0f3d2e; color: #fff; font-weight: 500;">Status</th>
                        <th style="background-color: #0f3d2e; color: #fff; font-weight: 500;">Fase</th>
                        <th style="background-color: #0f3d2e; color: #fff; font-weight: 500;">Next Follow-up</th>
                        <th style="background-color: #0f3d2e; color: #fff; font-weight: 500; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($leads as $lead)
                    <tr class="{{ $lead->isOverdue() ? 'table-danger' : ($lead->isDueToday() ? 'table-warning' : '') }}">
                        <td>
                            <strong>{{ $lead->nama_customer }}</strong>
                            @if($lead->isOverdue())
                                <i class="bi bi-exclamation-triangle-fill text-danger" title="Overdue"></i>
                            @elseif($lead->isDueToday())
                                <span class="badge bg-warning text-dark">Hari ini</span>
                            @endif
                        </td>
                        <td>{{ $lead->no_hp }}</td>
                        <td><x-badge-status :status="$lead->status_prospek" /></td>
                        <td><span class="badge bg-secondary">Fase {{ $lead->fase_followup }}</span></td>
                        <td>
                            @if($lead->tgl_next_followup)
                                {{ $lead->tgl_next_followup->format('d/m/Y') }}
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="btn-group btn-group-sm">
                                <x-whatsapp-button :phone="$lead->no_hp" class="btn-sm" />
                                <a href="{{ route('marketing.leads.show', $lead) }}" class="btn btn-sm" style="border-color: #0f3d2e; color: #0f3d2e;">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">
                            <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                            Belum ada lead
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($leads->hasPages())
    <div class="card-footer">
        {{ $leads->links() }}
    </div>
    @endif
</div>

<!-- Mobile Pagination -->
<div class="d-md-none mt-3">
    {{ $leads->links() }}
</div>
@endsection
