@extends('layouts.app')

@section('title', 'Tambah Lead - Zhafira CRM')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">
                <i class="bi bi-person-plus" style="color: #0f3d2e;"></i> Tambah Lead Baru
            </h4>
            <a href="{{ route('marketing.leads.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('marketing.leads.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="nama_customer" class="form-label">Nama Customer <span class="text-danger">*</span></label>
                        <input type="text"
                               class="form-control @error('nama_customer') is-invalid @enderror"
                               id="nama_customer"
                               name="nama_customer"
                               value="{{ old('nama_customer') }}"
                               required>
                        @error('nama_customer')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="no_hp" class="form-label">No HP <span class="text-danger">*</span></label>
                        <input type="text"
                               class="form-control @error('no_hp') is-invalid @enderror"
                               id="no_hp"
                               name="no_hp"
                               value="{{ old('no_hp') }}"
                               placeholder="08xxxxxxxxxx"
                               required>
                        @error('no_hp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="status_prospek" class="form-label">Status Prospek <span class="text-danger">*</span></label>
                        <select class="form-select @error('status_prospek') is-invalid @enderror"
                                id="status_prospek"
                                name="status_prospek"
                                required>
                            @foreach($statuses as $status)
                                <option value="{{ $status->value }}" {{ old('status_prospek', 'New') == $status->value ? 'selected' : '' }}>
                                    {{ $status->value }}
                                </option>
                            @endforeach
                        </select>
                        @error('status_prospek')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="catatan_terakhir" class="form-label">Catatan</label>
                        <textarea class="form-control @error('catatan_terakhir') is-invalid @enderror"
                                  id="catatan_terakhir"
                                  name="catatan_terakhir"
                                  rows="3">{{ old('catatan_terakhir') }}</textarea>
                        @error('catatan_terakhir')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i>
                        Lead baru akan otomatis di-set untuk follow-up 3 hari ke depan (Fase 0).
                    </div>

                    <hr>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn" style="background-color: #0f3d2e; border-color: #0f3d2e; color: #fff;">
                            <i class="bi bi-save"></i> Simpan Lead
                        </button>
                        <a href="{{ route('marketing.leads.index') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
