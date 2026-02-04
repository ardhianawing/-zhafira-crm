@extends('layouts.app')

@section('title', 'Database Leads - Zhafira CRM')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-0 fw-bold"><i class="bi bi-people-fill" style="color: #0f3d2e;"></i> Database Leads</h4>
        <p class="text-muted mb-0">Total database: <b>{{ $leads->total() }}</b> baris data.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.leads.create') }}" class="btn" style="background-color: #0f3d2e; border-color: #0f3d2e; color: #fff;">
            <i class="bi bi-plus-circle"></i> Tambah Lead
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-md-6">
                <form action="{{ route('admin.leads.index') }}" method="GET" class="d-flex align-items-center gap-3">
                    <div class="d-flex align-items-center gap-2 bg-light px-3 py-1 rounded border">
                        <span class="small fw-bold text-nowrap">Tampilkan:</span>
                        <select name="per_page" class="form-select form-select-sm border-0 bg-transparent fw-bold" style="width: 100px;" onchange="this.form.submit()">
                            @foreach([50, 100, 500, 1000] as $value)
                                <option value="{{ $value }}" {{ $perPage == $value ? 'selected' : '' }}>{{ $value }} Baris</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="input-group input-group-sm" style="width: 250px;">
                        <input type="text" name="search" class="form-control" placeholder="Cari nama/hp..." value="{{ request('search') }}">
                        <button class="btn btn-outline-secondary" type="submit"><i class="bi bi-search"></i></button>
                    </div>
                </form>
            </div>
            <div class="col-md-6 text-md-end">
                <span class="text-muted small">Menampilkan {{ $leads->firstItem() }} - {{ $leads->lastItem() }} dari {{ $leads->total() }} data</span>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr style="background-color: #0f3d2e; color: #fff;">
                    <th style="background-color: #0f3d2e; color: #fff; font-weight: 500;">Customer</th>
                    <th style="background-color: #0f3d2e; color: #fff; font-weight: 500;">WhatsApp</th>
                    <th style="background-color: #0f3d2e; color: #fff; font-weight: 500;">Sumber</th>
                    <th style="background-color: #0f3d2e; color: #fff; font-weight: 500;">Marketing</th>
                    <th style="background-color: #0f3d2e; color: #fff; font-weight: 500;">Status</th>
                    <th style="background-color: #0f3d2e; color: #fff; font-weight: 500; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($leads as $lead)
                <tr>
                    <td>
                        <div class="fw-bold">{{ $lead->nama_customer }}</div>
                        <small class="text-muted">{{ $lead->created_at->format('d M Y') }}</small>
                    </td>
                    <td>{{ $lead->no_hp }}</td>
                    <td><span class="badge" style="background-color: #f8f9fa; color: #212529; border: 1px solid #dee2e6;">{{ $lead->sumber_lead ?? '-' }}</span></td>
                    <td>
                        @if($lead->assignedUser)
                            <span class="badge" style="background-color: rgba(13,202,240,0.1); color: #0dcaf0; border: 1px solid rgba(13,202,240,0.2);">{{ $lead->assignedUser->nama_lengkap }}</span>
                        @else
                            <span class="badge" style="background-color: rgba(220,53,69,0.1); color: #dc3545;">Belum Di-assign</span>
                        @endif
                    </td>
                    <td>
                        <x-badge-status :status="$lead->status_prospek" />
                    </td>
                    <td class="text-center">
                        <div class="btn-group">
                            <a href="{{ route('admin.leads.edit', $lead->id) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil text-primary"></i></a>
                            <form action="{{ route('admin.leads.destroy', $lead->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus data ini?')"><i class="bi bi-trash text-danger"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center py-5">Tidak ada data leads.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-white border-top-0 py-3">
        {{ $leads->links() }}
    </div>
</div>
@endsection