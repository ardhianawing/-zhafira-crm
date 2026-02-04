@extends('layouts.app')

@section('title', 'Edit Lead - Zhafira CRM')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">
                <i class="bi bi-pencil" style="color: #0f3d2e;"></i> Edit Lead
            </h4>
            <a href="{{ route('admin.leads.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.leads.update', $lead) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="nama_customer" class="form-label">Nama Customer <span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control @error('nama_customer') is-invalid @enderror"
                                   id="nama_customer"
                                   name="nama_customer"
                                   value="{{ old('nama_customer', $lead->nama_customer) }}"
                                   required>
                            @error('nama_customer')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="no_hp" class="form-label">No HP <span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control @error('no_hp') is-invalid @enderror"
                                   id="no_hp"
                                   name="no_hp"
                                   value="{{ old('no_hp', $lead->no_hp) }}"
                                   required>
                            @error('no_hp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="status_prospek" class="form-label">Status Prospek <span class="text-danger">*</span></label>
                            <select class="form-select @error('status_prospek') is-invalid @enderror"
                                    id="status_prospek"
                                    name="status_prospek"
                                    required>
                                @foreach($statuses as $status)
                                    <option value="{{ $status->value }}" {{ old('status_prospek', $lead->status_prospek->value) == $status->value ? 'selected' : '' }}>
                                        {{ $status->value }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status_prospek')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="assigned_to" class="form-label">Assign ke Marketing</label>
                            <select class="form-select @error('assigned_to') is-invalid @enderror"
                                    id="assigned_to"
                                    name="assigned_to">
                                <option value="">-- Pilih Marketing --</option>
                                @foreach($marketingUsers as $user)
                                    <option value="{{ $user->id }}" {{ old('assigned_to', $lead->assigned_to) == $user->id ? 'selected' : '' }}>
                                        {{ $user->nama_lengkap }}
                                    </option>
                                @endforeach
                            </select>
                            @error('assigned_to')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="fase_followup" class="form-label">Fase Follow-up</label>
                            <select class="form-select @error('fase_followup') is-invalid @enderror"
                                    id="fase_followup"
                                    name="fase_followup">
                                <option value="0" {{ old('fase_followup', $lead->fase_followup) == 0 ? 'selected' : '' }}>Fase 0</option>
                                <option value="1" {{ old('fase_followup', $lead->fase_followup) == 1 ? 'selected' : '' }}>Fase 1</option>
                                <option value="2" {{ old('fase_followup', $lead->fase_followup) == 2 ? 'selected' : '' }}>Fase 2</option>
                                <option value="3" {{ old('fase_followup', $lead->fase_followup) == 3 ? 'selected' : '' }}>Fase 3</option>
                            </select>
                            @error('fase_followup')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="tgl_next_followup" class="form-label">Tanggal Next Follow-up</label>
                            <input type="date"
                                   class="form-control @error('tgl_next_followup') is-invalid @enderror"
                                   id="tgl_next_followup"
                                   name="tgl_next_followup"
                                   value="{{ old('tgl_next_followup', $lead->tgl_next_followup?->format('Y-m-d')) }}">
                            @error('tgl_next_followup')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="catatan_terakhir" class="form-label">Catatan</label>
                            <textarea class="form-control @error('catatan_terakhir') is-invalid @enderror"
                                      id="catatan_terakhir"
                                      name="catatan_terakhir"
                                      rows="3">{{ old('catatan_terakhir', $lead->catatan_terakhir) }}</textarea>
                            @error('catatan_terakhir')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.leads.history', $lead) }}" class="btn btn-outline-secondary">
                            <i class="bi bi-clock-history"></i> Lihat History
                        </a>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.leads.index') }}" class="btn btn-outline-secondary">Batal</a>
                            <button type="submit" class="btn" style="background-color: #0f3d2e; border-color: #0f3d2e; color: #fff;">
                                <i class="bi bi-save"></i> Update Lead
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
