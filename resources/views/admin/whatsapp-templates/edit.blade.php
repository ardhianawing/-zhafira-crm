@extends('layouts.app')

@section('title', 'Edit WhatsApp Template - Zhafira CRM')

@section('content')
<div class="mb-4">
    <h4 class="mb-0">
        <i class="bi bi-pencil" style="color: #0f3d2e;"></i> Edit WhatsApp Template
    </h4>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.whatsapp-templates.update', $whatsappTemplate) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="nama_template" class="form-label">Nama Template <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama_template') is-invalid @enderror"
                            id="nama_template" name="nama_template"
                            value="{{ old('nama_template', $whatsappTemplate->nama_template) }}" required>
                        @error('nama_template')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="isi_template" class="form-label">Isi Template <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('isi_template') is-invalid @enderror"
                            id="isi_template" name="isi_template" rows="8" required>{{ old('isi_template', $whatsappTemplate->isi_template) }}</textarea>
                        @error('isi_template')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn" style="background-color: #0f3d2e; border-color: #0f3d2e; color: #fff;">
                            <i class="bi bi-check-circle"></i> Update Template
                        </button>
                        <a href="{{ route('admin.whatsapp-templates.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
