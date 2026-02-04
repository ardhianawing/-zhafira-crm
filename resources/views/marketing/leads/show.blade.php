@extends('layouts.app')

@section('title', 'Detail Lead - Zhafira CRM')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">
                <i class="bi bi-person" style="color: #0f3d2e;"></i> Detail Lead
            </h4>
            <a href="{{ route('marketing.leads.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

        <!-- Lead Info Card -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #0f3d2e; color: #fff;">
                <span>{{ $lead->nama_customer }}</span>
                <x-badge-status :status="$lead->status_prospek" />
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="text-muted small">No HP</label>
                        <p class="mb-2">
                            {{ $lead->no_hp }}
                            <x-whatsapp-button :phone="$lead->no_hp" class="btn-sm ms-2">Chat</x-whatsapp-button>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small">Fase Follow-up</label>
                        <p class="mb-2">
                            <span class="badge bg-secondary">Fase {{ $lead->fase_followup }}</span>
                            @if($lead->fase_followup < 3)
                                <small class="text-muted ms-2">
                                    (Next: +{{ [3,5,7][$lead->fase_followup] ?? 7 }} hari)
                                </small>
                            @else
                                <small class="text-muted ms-2">(Manual)</small>
                            @endif
                        </p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small">Next Follow-up</label>
                        <p class="mb-2">
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
                        </p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small">Tanggal Dibuat</label>
                        <p class="mb-2">{{ $lead->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    @if($lead->catatan_terakhir)
                    <div class="col-12">
                        <label class="text-muted small">Catatan Terakhir</label>
                        <p class="mb-0">{{ $lead->catatan_terakhir }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- WhatsApp Templates -->
        <div class="card mb-4">
            <div class="card-header" style="background-color: #25D366; color: #fff;">
                <i class="bi bi-whatsapp"></i> Template WhatsApp
            </div>
            <div class="card-body">
                @if($whatsappTemplates->count() > 0)
                    <div class="accordion" id="templateAccordion">
                        @foreach($whatsappTemplates as $index => $template)
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button {{ $index > 0 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#template{{ $template->id }}">
                                    {{ $template->nama_template }}
                                </button>
                            </h2>
                            <div id="template{{ $template->id }}" class="accordion-collapse collapse {{ $index == 0 ? 'show' : '' }}" data-bs-parent="#templateAccordion">
                                <div class="accordion-body">
                                    <pre class="mb-3 p-3 bg-light rounded" style="white-space: pre-wrap; font-family: inherit;" id="template-{{ $template->id }}">{{ $template->isi_template }}</pre>
                                    <div class="d-flex gap-2 flex-wrap">
                                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="copyTemplate({{ $template->id }})">
                                            <i class="bi bi-clipboard"></i> Copy
                                        </button>
                                        <x-whatsapp-button :phone="$lead->no_hp" :message="$template->isi_template" class="btn-sm">
                                            Kirim via WhatsApp
                                        </x-whatsapp-button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted mb-0">Belum ada template. Hubungi admin untuk menambahkan template.</p>
                @endif
            </div>
        </div>

        <!-- Edit Form -->
        <div class="card mb-4">
            <div class="card-header" style="background-color: #0f3d2e; color: #fff;">
                <i class="bi bi-pencil"></i> Edit Lead
            </div>
            <div class="card-body">
                <form action="{{ route('marketing.leads.update', $lead) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="nama_customer" class="form-label">Nama Customer</label>
                            <input type="text" class="form-control" id="nama_customer" name="nama_customer"
                                   value="{{ old('nama_customer', $lead->nama_customer) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="no_hp" class="form-label">No HP</label>
                            <input type="text" class="form-control" id="no_hp" name="no_hp"
                                   value="{{ old('no_hp', $lead->no_hp) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="status_prospek" class="form-label">Status Prospek</label>
                            <select class="form-select" id="status_prospek" name="status_prospek" required>
                                @foreach($statuses as $status)
                                    <option value="{{ $status->value }}" {{ old('status_prospek', $lead->status_prospek->value) == $status->value ? 'selected' : '' }}>
                                        {{ $status->value }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="catatan_terakhir" class="form-label">Catatan</label>
                            <textarea class="form-control" id="catatan_terakhir" name="catatan_terakhir" rows="3">{{ old('catatan_terakhir', $lead->catatan_terakhir) }}</textarea>
                        </div>
                    </div>

                    <hr>

                    <button type="submit" class="btn" style="background-color: #0f3d2e; border-color: #0f3d2e; color: #fff;">
                        <i class="bi bi-save"></i> Update Lead
                    </button>
                </form>
            </div>
        </div>

        <!-- History -->
        <div class="card">
            <div class="card-header" style="background-color: #0f3d2e; color: #fff;">
                <i class="bi bi-clock-history"></i> Riwayat
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @forelse($lead->histories->take(10) as $history)
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

@push('scripts')
<script>
function copyTemplate(templateId) {
    const text = document.getElementById('template-' + templateId).innerText;
    navigator.clipboard.writeText(text).then(() => {
        alert('Template berhasil di-copy!');
    });
}
</script>
@endpush
