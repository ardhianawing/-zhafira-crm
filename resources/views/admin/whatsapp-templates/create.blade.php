@extends('layouts.app')

@section('title', 'Tambah WhatsApp Template - Zhafira CRM')

@section('content')
<div class="mb-4">
    <h4 class="mb-0">
        <i class="bi bi-plus-circle" style="color: #0f3d2e;"></i> Tambah WhatsApp Template
    </h4>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.whatsapp-templates.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="nama_template" class="form-label">Nama Template <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama_template') is-invalid @enderror"
                            id="nama_template" name="nama_template" value="{{ old('nama_template') }}"
                            placeholder="Contoh: Follow-up Awal, Penawaran Promo, dll" required>
                        @error('nama_template')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="isi_template" class="form-label">Isi Template <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('isi_template') is-invalid @enderror"
                            id="isi_template" name="isi_template" rows="8"
                            placeholder="Tulis pesan template di sini..." required>{{ old('isi_template') }}</textarea>
                        @error('isi_template')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Tulis pesan WhatsApp yang akan digunakan untuk follow-up customer.</small>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn" style="background-color: #0f3d2e; border-color: #0f3d2e; color: #fff;">
                            <i class="bi bi-check-circle"></i> Simpan Template
                        </button>
                        <a href="{{ route('admin.whatsapp-templates.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header" style="background-color: #0f3d2e; color: #fff;">
                <i class="bi bi-lightbulb"></i> Tips
            </div>
            <div class="card-body">
                <ul class="mb-0 small">
                    <li class="mb-2">Buat template untuk berbagai situasi (follow-up awal, penawaran, closing)</li>
                    <li class="mb-2">Gunakan bahasa yang ramah dan personal</li>
                    <li class="mb-2">Jangan terlalu panjang, fokus pada poin penting</li>
                    <li>Marketing bisa edit sebelum kirim ke customer</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
