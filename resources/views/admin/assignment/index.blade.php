@extends('layouts.app')

@section('title', 'Distribusi Lead - Zhafira CRM')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3 mb-md-4 px-2 px-md-0">
        <h4 class="mb-0 fs-5 fs-md-4">
            <i class="bi bi-person-plus" style="color: #0f3d2e;"></i> Distribusi Lead
        </h4>
        <a href="{{ route('admin.leads.create') }}" class="btn btn-sm" style="background-color: #0f3d2e; border-color: #0f3d2e; color: #fff; padding: 0.25rem 0.5rem; font-size: 0.75rem;">
            <i class="bi bi-plus-circle"></i> <span class="d-none d-sm-inline">Tambah Lead</span><span class="d-inline d-sm-none">Tambah</span>
        </a>
    </div>

    <div class="row g-3 g-md-4">
        <!-- Left Column: Unassigned Leads -->
        <div class="col-xl-6">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-header bg-white py-2 py-md-3 d-flex justify-content-between align-items-center border-bottom">
                    <h6 class="mb-0 fw-bold small-mobile">
                        <i class="bi bi-person-x text-danger me-1 me-md-2"></i> Lead Baru
                        <span class="badge bg-danger ms-1">{{ $unassignedLeads->total() }}</span>
                    </h6>
                    <div class="form-check small p-0 m-0 d-flex align-items-center">
                        <input class="form-check-input me-2" type="checkbox" id="selectAllUnassignedMaster" style="margin-top: 0;">
                        <label class="form-check-label small d-none d-sm-block" for="selectAllUnassignedMaster">Pilih Semua</label>
                        <label class="form-check-label small d-block d-sm-none" for="selectAllUnassignedMaster">Semua</label>
                    </div>
                </div>
                <div class="card-body p-0">
                    <form action="{{ route('admin.assignment.bulk') }}" method="POST" id="bulkAssignForm">
                        @csrf
                        <div class="p-2 p-md-3 border-bottom sticky-top" style="top: 0; z-index: 10; background-color: #f8f9fa;">
                            <div class="row g-1 g-md-2 align-items-center">
                                <div class="col">
                                    <select name="marketing_id" class="form-select form-select-sm" required>
                                        <option value="">Pilih Marketing...</option>
                                        @foreach($marketingUsers as $user)
                                            <option value="{{ $user->id }}">
                                                {{ $user->nama_lengkap }} ({{ $user->leads_count }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-sm px-2 px-md-3" style="background-color: #0f3d2e; border-color: #0f3d2e; color: #fff;">
                                        <i class="bi bi-person-check"></i> <span class="d-none d-sm-inline">Bagi Lead</span><span class="d-inline d-sm-none">Bagi</span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        @if($unassignedLeads->count() > 0)
                            <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="sticky-top" style="top: 0;">
                                        <tr style="background-color: #0f3d2e; color: #fff; font-size: 0.875rem; font-weight: 600;">
                                            <th style="width: 35px; background-color: #0f3d2e; color: #fff; padding-left: 0.5rem;" class="ps-2 ps-md-3">#</th>
                                            <th style="background-color: #0f3d2e; color: #fff;">Customer</th>
                                            <th class="d-none d-md-table-cell" style="background-color: #0f3d2e; color: #fff;">Status</th>
                                            <th class="text-end pe-2 pe-md-3" style="background-color: #0f3d2e; color: #fff;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($unassignedLeads as $lead)
                                            <tr class="small-mobile-row">
                                                <td class="ps-2 ps-md-3">
                                                    <input class="form-check-input unassigned-checkbox" type="checkbox"
                                                        name="lead_ids[]" value="{{ $lead->id }}">
                                                </td>
                                                <td>
                                                    <div class="fw-bold text-truncate" style="max-width: 150px;">{{ $lead->nama_customer }}</div>
                                                    <div class="d-flex align-items-center gap-1">
                                                        <small class="text-muted d-block">{{ $lead->no_hp }}</small>
                                                        <span class="d-md-none"><x-badge-status :status="$lead->status_prospek" /></span>
                                                    </div>
                                                </td>
                                                <td class="d-none d-md-table-cell"><x-badge-status :status="$lead->status_prospek" /></td>
                                                <td class="text-end pe-2 pe-md-3">
                                                    <div class="dropdown">
                                                        <button class="btn dropdown-toggle py-1" type="button" style="padding: 0.25rem 0.5rem; font-size: 0.75rem; background-color: #f8f9fa; border-color: #dee2e6;"
                                                            data-bs-toggle="dropdown">
                                                            <span class="d-none d-sm-inline">Assign</span><i class="bi bi-person-plus d-inline d-sm-none"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                                            @foreach($marketingUsers as $user)
                                                                <li>
                                                                    <form action="{{ route('admin.assignment.single', $lead) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        <input type="hidden" name="marketing_id"
                                                                            value="{{ $user->id }}">
                                                                        <button type="submit" class="dropdown-item py-2 small">
                                                                            <i class="bi bi-person me-2"></i> {{ $user->nama_lengkap }}
                                                                            <span
                                                                                class="badge bg-light text-dark ms-1">{{ $user->leads_count }}</span>
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
                            <div class="p-2 p-md-3 border-top">
                                {{ $unassignedLeads->links() }}
                            </div>
                        @else
                            <div class="text-center py-5 text-muted">
                                <i class="bi bi-check2-all fs-1 d-block mb-3 text-success"></i>
                                <p>Semua lead baru sudah di-assign!</p>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>

        <!-- Right Column: Assigned Leads & Controls -->
        <div class="col-xl-6">
            <div class="row g-4">
                <!-- Sidebar Info (Rotator & Stats) -->
                <div class="col-12">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div
                                class="card shadow-sm border-0 border-start border-4 {{ $rotatorEnabled ? 'border-success' : 'border-secondary' }}">
                                <div class="card-body py-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="text-muted mb-1 small uppercase fw-bold">Lead Rotator</h6>
                                            <h5 class="mb-0 {{ $rotatorEnabled ? 'text-success' : 'text-secondary' }}">
                                                {{ $rotatorEnabled ? 'AKTIF' : 'NONAKTIF' }}
                                            </h5>
                                        </div>
                                        <form action="{{ route('admin.assignment.toggle-rotator') }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="btn btn-sm {{ $rotatorEnabled ? 'btn-outline-danger' : 'btn-success' }}">
                                                {{ $rotatorEnabled ? 'Matikan' : 'Aktifkan' }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card shadow-sm border-0" style="border-left: 4px solid #0f3d2e !important;">
                                <div class="card-body py-3">
                                    <h6 class="text-muted mb-1 small uppercase fw-bold">Total Terdistribusi</h6>
                                    <h5 class="mb-0" style="color: #0f3d2e;">{{ $assignedLeads->total() }} Leads</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Assigned Leads Table -->
                <div class="col-12">
                    <div class="card shadow-sm border-0">
                        <div
                            class="card-header bg-white py-2 py-md-3 d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 gap-sm-3 border-bottom">
                            <h6 class="mb-0 fw-bold small-mobile">
                                <i class="bi bi-person-check-fill text-success me-1 me-md-2"></i> Terdistribusi
                            </h6>
                            <form action="{{ route('admin.assignment.index') }}" method="GET" class="d-flex gap-2">
                                <input type="hidden" name="per_page" value="{{ $perPage }}">
                                <select name="marketing_filter" class="form-select form-select-sm" style="min-width: 140px;"
                                    onchange="this.form.submit()">
                                    <option value="">Semua Marketing</option>
                                    @foreach($marketingUsers as $user)
                                        <option value="{{ $user->id }}" {{ request('marketing_filter') == $user->id ? 'selected' : '' }}>
                                            {{ $user->nama_lengkap }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </div>
                        <div class="card-body p-0">
                            <div class="p-2 p-md-3 bg-light border-bottom">
                                <div class="d-flex flex-wrap gap-1 gap-md-2 align-items-center">
                                    <div class="form-check me-1 me-md-2 p-0 d-flex align-items-center">
                                        <input class="form-check-input me-1" type="checkbox" id="selectAllAssignedMaster" style="margin-top: 0;">
                                        <label class="form-check-label small" for="selectAllAssignedMaster">Pilih</label>
                                    </div>

                                    <form action="{{ route('admin.assignment.transfer') }}" method="POST" id="transferForm"
                                        class="d-flex gap-1 flex-grow-1">
                                        @csrf
                                        <div id="transferLeadIds"></div>
                                        <select name="marketing_id" class="form-select form-select-sm"
                                            style="min-width: 120px;" required>
                                            <option value="">Oper ke...</option>
                                            @foreach($marketingUsers as $user)
                                                <option value="{{ $user->id }}">{{ $user->nama_lengkap }}</option>
                                            @endforeach
                                        </select>
                                        <button type="submit" class="btn btn-warning btn-sm text-nowrap px-2">
                                            <i class="bi bi-arrow-left-right"></i> <span class="d-none d-sm-inline">Oper</span>
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.assignment.delete') }}" method="POST" id="deleteForm"
                                        onsubmit="return confirm('Yakin hapus lead yang dipilih?')">
                                        @csrf
                                        <div id="deleteLeadIds"></div>
                                        <button type="submit" class="btn btn-outline-danger btn-sm px-2">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>

                            @if($assignedLeads->count() > 0)
                                <div class="table-responsive" style="max-height: 480px; overflow-y: auto;">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="sticky-top" style="top: 0;">
                                            <tr style="background-color: #0f3d2e; color: #fff; font-size: 0.875rem; font-weight: 600;">
                                                <th style="width: 35px; background-color: #0f3d2e; color: #fff; padding-left: 0.5rem;" class="ps-2 ps-md-3">#</th>
                                                <th style="background-color: #0f3d2e; color: #fff;">Customer</th>
                                                <th style="background-color: #0f3d2e; color: #fff;">Marketing</th>
                                                <th class="d-none d-md-table-cell" style="background-color: #0f3d2e; color: #fff;">Follow-up</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($assignedLeads as $lead)
                                                <tr class="small-mobile-row">
                                                    <td class="ps-2 ps-md-3">
                                                        <input class="form-check-input assigned-checkbox" type="checkbox"
                                                            value="{{ $lead->id }}">
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('admin.leads.show', $lead) }}"
                                                            class="text-decoration-none fw-bold text-dark d-block text-truncate" style="max-width: 140px;">
                                                            {{ $lead->nama_customer }}
                                                        </a>
                                                        <div class="d-flex align-items-center gap-1">
                                                            <x-badge-status :status="$lead->status_prospek" />
                                                            <div class="d-md-none small text-muted">
                                                                @if($lead->tgl_next_followup)
                                                                    {{ $lead->tgl_next_followup->format('d/m') }}
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="badge" style="background-color: rgba(15,61,46,0.1); color: #0f3d2e; border: 1px solid rgba(15,61,46,0.2);">
                                                            {{ $lead->assignedUser->nama_lengkap ?? '-' }}
                                                        </span>
                                                    </td>
                                                    <td class="d-none d-md-table-cell">
                                                        @if($lead->tgl_next_followup)
                                                            @if($lead->isOverdue())
                                                                <span class="text-danger small"><i class="bi bi-exclamation-circle"></i>
                                                                    {{ $lead->tgl_next_followup->format('d/m/y') }}</span>
                                                            @elseif($lead->isDueToday())
                                                                <span class="text-warning small fw-bold"><i class="bi bi-clock"></i> Hari
                                                                    ini</span>
                                                            @else
                                                                <span
                                                                    class="text-muted small">{{ $lead->tgl_next_followup->format('d/m/y') }}</span>
                                                            @endif
                                                        @else
                                                            <span class="text-muted small">-</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="p-2 p-md-3 border-top">
                                    {{ $assignedLeads->links() }}
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

                <!-- Marketing Team List -->
                <div class="col-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white py-3 border-bottom">
                            <h6 class="mb-0 fw-bold">
                                <i class="bi bi-people-fill me-2" style="color: #0f3d2e;"></i> Tim Marketing
                            </h6>
                        </div>
                        <div class="card-body p-0">
                            <div class="row g-0">
                                @foreach($marketingUsers as $user)
                                    <div class="col-md-6 border-end border-bottom">
                                        <div class="p-3 d-flex justify-content-between align-items-center h-100">
                                            <div>
                                                <div class="fw-bold">{{ $user->nama_lengkap }}</div>
                                                <small class="text-muted">@</small><small>{{ $user->username }}</small>
                                            </div>
                                            <div class="text-end">
                                                <div class="h5 mb-0" style="color: #0f3d2e;">{{ $user->leads_count }}</div>
                                                <small class="text-muted small">Leads</small>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Per Page Selector at Bottom -->
    <div class="mt-4 mb-2 d-flex justify-content-center justify-content-md-end">
        <div class="bg-white p-2 rounded shadow-sm border d-flex align-items-center gap-2">
            <form action="{{ url()->current() }}" method="GET" class="d-flex align-items-center gap-2 mb-0">
                <input type="hidden" name="marketing_filter" value="{{ request('marketing_filter') }}">
                <span class="text-muted small fw-bold">Tampilkan:</span>
                <select name="per_page" onchange="this.form.submit()" class="form-select form-select-sm"
                    style="width: auto;">
                    <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                    <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
                    <option value="500" {{ $perPage == 500 ? 'selected' : '' }}>500</option>
                    <option value="1000" {{ $perPage == 1000 ? 'selected' : '' }}>1000</option>
                </select>
                <span class="text-muted small">data per halaman</span>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Select All - Unassigned
            const selectAllUnassignedMaster = document.getElementById('selectAllUnassignedMaster');
            const unassignedCheckboxes = document.querySelectorAll('.unassigned-checkbox');

            if (selectAllUnassignedMaster) {
                selectAllUnassignedMaster.addEventListener('change', function () {
                    unassignedCheckboxes.forEach(cb => cb.checked = this.checked);
                });
            }

            // Select All - Assigned
            const selectAllAssignedMaster = document.getElementById('selectAllAssignedMaster');
            const assignedCheckboxes = document.querySelectorAll('.assigned-checkbox');

            if (selectAllAssignedMaster) {
                selectAllAssignedMaster.addEventListener('change', function () {
                    assignedCheckboxes.forEach(cb => {
                        cb.checked = this.checked;
                        updateSelectedLeads();
                    });
                });
            }

            // Individual checkbox changes
            assignedCheckboxes.forEach(cb => {
                cb.addEventListener('change', updateSelectedLeads);
            });

            function updateSelectedLeads() {
                const transferContainer = document.getElementById('transferLeadIds');
                const deleteContainer = document.getElementById('deleteLeadIds');

                if (!transferContainer || !deleteContainer) return;

                transferContainer.innerHTML = '';
                deleteContainer.innerHTML = '';

                const checked = document.querySelectorAll('.assigned-checkbox:checked');
                checked.forEach(box => {
                    const input1 = document.createElement('input');
                    input1.type = 'hidden';
                    input1.name = 'lead_ids[]';
                    input1.value = box.value;
                    transferContainer.appendChild(input1);

                    const input2 = document.createElement('input');
                    input2.type = 'hidden';
                    input2.name = 'lead_ids[]';
                    input2.value = box.value;
                    deleteContainer.appendChild(input2);
                });
            }
        });
    </script>
@endpush