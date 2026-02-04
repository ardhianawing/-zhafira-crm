@extends('layouts.app')

@section('title', 'Distribusi Lead - Zhafira CRM')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">
        <i class="bi bi-person-plus " style="color: #0f3d2e;"></i> Distribusi Lead
    </h4>
</div>

<div class="row g-4">
    <!-- Main Content -->
    <div class="col-md-8">
        <!-- Tab Navigation -->
        <ul class="nav nav-tabs mb-3" id="leadTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="unassigned-tab" data-bs-toggle="tab" data-bs-target="#unassigned" type="button">
                    <i class="bi bi-person-x"></i> Belum Di-assign
                    <span class="badge bg-danger">{{ $unassignedLeads->count() }}</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="assigned-tab" data-bs-toggle="tab" data-bs-target="#assigned" type="button">
                    <i class="bi bi-person-check"></i> Sudah Di-assign
                    <span class="badge bg-success">{{ $assignedLeads->count() }}</span>
                </button>
            </li>
        </ul>

        <div class="tab-content" id="leadTabsContent">
            <!-- Tab: Unassigned Leads -->
            <div class="tab-pane fade show active" id="unassigned" role="tabpanel">
                <div class="card">
                    <div class="card-header card-header" style="background-color: #0f3d2e; color: #fff;">
                        <i class="bi bi-people"></i> Lead Belum Di-assign
                    </div>
                    <div class="card-body">
                        @if($unassignedLeads->count() > 0)
                        <form action="{{ route('admin.assignment.bulk') }}" method="POST" id="bulkAssignForm">
                            @csrf

                            <div class="mb-3">
                                <div class="row g-2 align-items-center mb-2">
                                    <div class="col-12 col-md-auto">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="selectAllUnassigned">
                                            <label class="form-check-label" for="selectAllUnassigned">Pilih Semua</label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md">
                                        <div class="d-flex flex-column flex-sm-row gap-2">
                                            <select name="marketing_id" class="form-select form-select-sm" required>
                                                <option value="">Pilih Marketing</option>
                                                @foreach($marketingUsers as $user)
                                                    <option value="{{ $user->id }}">
                                                        {{ $user->nama_lengkap }} ({{ $user->leads_count }} leads)
                                                    </option>
                                                @endforeach
                                            </select>
                                            <button type="submit" class="btn btn" style="background-color: #0f3d2e; border-color: #0f3d2e; color: #fff; btn-sm">
                                                <i class="bi bi-person-check"></i> Assign
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th style="width: 40px;">
                                                <input class="form-check-input" type="checkbox" id="selectAllUnassignedHeader" title="Pilih Semua">
                                            </th>
                                            <th>Nama Customer</th>
                                            <th>No HP</th>
                                            <th>Status</th>
                                            <th>Dibuat</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($unassignedLeads as $lead)
                                        <tr>
                                            <td>
                                                <input class="form-check-input unassigned-checkbox" type="checkbox" name="lead_ids[]" value="{{ $lead->id }}">
                                            </td>
                                            <td>{{ $lead->nama_customer }}</td>
                                            <td>{{ $lead->no_hp }}</td>
                                            <td><x-badge-status :status="$lead->status_prospek" /></td>
                                            <td>{{ $lead->created_at->format('d/m/Y H:i') }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn" style="border-color: #0f3d2e; color: #0f3d2e; dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                        Assign ke
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        @foreach($marketingUsers as $user)
                                                        <li>
                                                            <form action="{{ route('admin.assignment.single', $lead) }}" method="POST">
                                                                @csrf
                                                                <input type="hidden" name="marketing_id" value="{{ $user->id }}">
                                                                <button type="submit" class="dropdown-item">
                                                                    {{ $user->nama_lengkap }}
                                                                    <small class="text-muted">({{ $user->leads_count }})</small>
                                                                </button>
                                                            </form>
                                                        </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </form>
                        @else
                        <div class="text-center py-5 text-muted">
                            <i class="bi bi-check-circle fs-1 d-block mb-3"></i>
                            <p>Semua lead sudah di-assign!</p>
                            <a href="{{ route('admin.leads.create') }}" class="btn btn" style="background-color: #0f3d2e; border-color: #0f3d2e; color: #fff;">
                                <i class="bi bi-plus-circle"></i> Tambah Lead Baru
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Tab: Assigned Leads -->
            <div class="tab-pane fade" id="assigned" role="tabpanel">
                <div class="card">
                    <div class="card-header card-header" style="background-color: #0f3d2e; color: #fff; d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-people-fill"></i> Lead Sudah Di-assign</span>
                        <!-- Filter -->
                        <form action="{{ route('admin.assignment.index') }}" method="GET" class="d-flex gap-2">
                            <select name="marketing_filter" class="form-select form-select-sm" style="width: auto;" onchange="this.form.submit()">
                                <option value="">Semua Marketing</option>
                                @foreach($marketingUsers as $user)
                                    <option value="{{ $user->id }}" {{ request('marketing_filter') == $user->id ? 'selected' : '' }}>
                                        {{ $user->nama_lengkap }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                    <div class="card-body">
                        @if($assignedLeads->count() > 0)
                        <!-- Bulk Actions -->
                        <div class="mb-3 p-3 bg-light rounded">
                            <div class="row g-2 align-items-center">
                                <div class="col-12 col-md-auto">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="selectAllAssigned">
                                        <label class="form-check-label fw-bold" for="selectAllAssigned">Pilih Semua</label>
                                    </div>
                                </div>
                                <div class="col-12 col-md">
                                    <div class="d-flex flex-wrap gap-2">
                                        <!-- Transfer Form -->
                                        <form action="{{ route('admin.assignment.transfer') }}" method="POST" id="transferForm" class="d-flex gap-2">
                                            @csrf
                                            <div id="transferLeadIds"></div>
                                            <select name="marketing_id" class="form-select form-select-sm" style="width: auto;" required>
                                                <option value="">Transfer ke...</option>
                                                @foreach($marketingUsers as $user)
                                                    <option value="{{ $user->id }}">{{ $user->nama_lengkap }}</option>
                                                @endforeach
                                            </select>
                                            <button type="submit" class="btn btn-warning btn-sm">
                                                <i class="bi bi-arrow-left-right"></i> Transfer
                                            </button>
                                        </form>

                                        <!-- Delete Form -->
                                        <form action="{{ route('admin.assignment.delete') }}" method="POST" id="deleteForm" onsubmit="return confirm('Yakin hapus lead yang dipilih? Data tidak bisa dikembalikan!')">
                                            @csrf
                                            <div id="deleteLeadIds"></div>
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 40px;">
                                            <input class="form-check-input" type="checkbox" id="selectAllAssignedHeader" title="Pilih Semua">
                                        </th>
                                        <th>Nama Customer</th>
                                        <th>No HP</th>
                                        <th>Status</th>
                                        <th>Marketing</th>
                                        <th>Follow-up</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($assignedLeads as $lead)
                                    <tr>
                                        <td>
                                            <input class="form-check-input assigned-checkbox" type="checkbox" value="{{ $lead->id }}">
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.leads.show', $lead) }}" class="text-decoration-none">
                                                {{ $lead->nama_customer }}
                                            </a>
                                        </td>
                                        <td>{{ $lead->no_hp }}</td>
                                        <td><x-badge-status :status="$lead->status_prospek" /></td>
                                        <td>
                                            <span class="badge badge" style="background-color: #0f3d2e; color: #fff;">{{ $lead->assignedUser->nama_lengkap ?? '-' }}</span>
                                        </td>
                                        <td>
                                            @if($lead->tgl_next_followup)
                                                @if($lead->isOverdue())
                                                    <span class="text-danger"><i class="bi bi-exclamation-circle"></i> {{ $lead->tgl_next_followup->format('d/m/Y') }}</span>
                                                @elseif($lead->isDueToday())
                                                    <span class="text-warning"><i class="bi bi-clock"></i> Hari ini</span>
                                                @else
                                                    <span class="text-muted">{{ $lead->tgl_next_followup->format('d/m/Y') }}</span>
                                                @endif
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="text-center py-5 text-muted">
                            <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                            <p>Belum ada lead yang di-assign.</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-md-4">
        <!-- Lead Rotator Card -->
        <div class="card mb-3">
            <div class="card-header card-header" style="background-color: #0f3d2e; color: #fff;">
                <i class="bi bi-arrow-repeat"></i> Lead Rotator
            </div>
            <div class="card-body">
                <p class="mb-3 small text-muted">
                    Jika aktif, lead baru dari Spreadsheet akan otomatis dibagi rata ke semua marketing.
                </p>
                <form action="{{ route('admin.assignment.toggle-rotator') }}" method="POST">
                    @csrf
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-bold">
                            Status:
                            @if($rotatorEnabled)
                                <span class="text-success"><i class="bi bi-check-circle-fill"></i> Aktif</span>
                            @else
                                <span class="text-secondary"><i class="bi bi-x-circle"></i> Nonaktif</span>
                            @endif
                        </span>
                        <button type="submit" class="btn btn-sm {{ $rotatorEnabled ? 'btn-outline-danger' : 'btn-success' }}">
                            @if($rotatorEnabled)
                                <i class="bi bi-pause-circle"></i> Nonaktifkan
                            @else
                                <i class="bi bi-play-circle"></i> Aktifkan
                            @endif
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header card-header" style="background-color: #0f3d2e; color: #fff;">
                <i class="bi bi-person-badge"></i> Tim Marketing
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @forelse($marketingUsers as $user)
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong>{{ $user->nama_lengkap }}</strong>
                            <br>
                            <small class="text-muted">@</small><small>{{ $user->username }}</small>
                        </div>
                        <span class="badge badge" style="background-color: #0f3d2e; color: #fff; rounded-pill">{{ $user->leads_count }} leads</span>
                    </div>
                    @empty
                    <div class="list-group-item text-center text-muted py-4">
                        Belum ada marketing aktif
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Select All - Unassigned (both checkboxes)
    var selectAllUnassigned = document.getElementById('selectAllUnassigned');
    var selectAllUnassignedHeader = document.getElementById('selectAllUnassignedHeader');

    function selectAllUnassignedLeads(isChecked) {
        var checkboxes = document.querySelectorAll('.unassigned-checkbox');
        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = isChecked;
        }
        // Sync both select-all checkboxes
        if (selectAllUnassigned) selectAllUnassigned.checked = isChecked;
        if (selectAllUnassignedHeader) selectAllUnassignedHeader.checked = isChecked;
    }

    if (selectAllUnassigned) {
        selectAllUnassigned.onclick = function() {
            selectAllUnassignedLeads(this.checked);
        };
    }

    if (selectAllUnassignedHeader) {
        selectAllUnassignedHeader.onclick = function() {
            selectAllUnassignedLeads(this.checked);
        };
    }

    // Select All - Assigned (both checkboxes)
    var selectAllAssigned = document.getElementById('selectAllAssigned');
    var selectAllAssignedHeader = document.getElementById('selectAllAssignedHeader');

    function selectAllAssignedLeads(isChecked) {
        var checkboxes = document.querySelectorAll('.assigned-checkbox');
        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = isChecked;
        }
        // Sync both select-all checkboxes
        if (selectAllAssigned) selectAllAssigned.checked = isChecked;
        if (selectAllAssignedHeader) selectAllAssignedHeader.checked = isChecked;
        updateSelectedLeads();
    }

    if (selectAllAssigned) {
        selectAllAssigned.onclick = function() {
            selectAllAssignedLeads(this.checked);
        };
    }

    if (selectAllAssignedHeader) {
        selectAllAssignedHeader.onclick = function() {
            selectAllAssignedLeads(this.checked);
        };
    }

    // Update on individual checkbox change
    var assignedCheckboxes = document.querySelectorAll('.assigned-checkbox');
    for (var i = 0; i < assignedCheckboxes.length; i++) {
        assignedCheckboxes[i].onclick = function() {
            updateSelectedLeads();
        };
    }

    function updateSelectedLeads() {
        var transferContainer = document.getElementById('transferLeadIds');
        var deleteContainer = document.getElementById('deleteLeadIds');

        if (!transferContainer || !deleteContainer) return;

        // Clear existing
        transferContainer.innerHTML = '';
        deleteContainer.innerHTML = '';

        // Add hidden inputs for checked boxes
        var checked = document.querySelectorAll('.assigned-checkbox:checked');
        for (var i = 0; i < checked.length; i++) {
            var input1 = document.createElement('input');
            input1.type = 'hidden';
            input1.name = 'lead_ids[]';
            input1.value = checked[i].value;
            transferContainer.appendChild(input1);

            var input2 = document.createElement('input');
            input2.type = 'hidden';
            input2.name = 'lead_ids[]';
            input2.value = checked[i].value;
            deleteContainer.appendChild(input2);
        }
    }

    // Show assigned tab if filtered
    @if(request('marketing_filter'))
        var assignedTab = document.getElementById('assigned-tab');
        if (assignedTab) assignedTab.click();
    @endif
});
</script>
@endpush
