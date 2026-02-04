@extends('layouts.app')

@section('title', 'Tambah Berita - Zhafira CRM')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">
                <i class="bi bi-plus-circle" style="color: #0f3d2e;"></i> Tambah Berita Baru
            </h4>
            <a href="{{ route('admin.news.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.news.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="judul" class="form-label">Judul <span class="text-danger">*</span></label>
                        <input type="text"
                               class="form-control @error('judul') is-invalid @enderror"
                               id="judul"
                               name="judul"
                               value="{{ old('judul') }}"
                               required>
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="tgl_post" class="form-label">Tanggal Post <span class="text-danger">*</span></label>
                        <input type="date"
                               class="form-control @error('tgl_post') is-invalid @enderror"
                               id="tgl_post"
                               name="tgl_post"
                               value="{{ old('tgl_post', now()->format('Y-m-d')) }}"
                               required>
                        @error('tgl_post')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="isi_berita" class="form-label">Isi Berita <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('isi_berita') is-invalid @enderror"
                                  id="isi_berita"
                                  name="isi_berita"
                                  rows="10"
                                  required>{{ old('isi_berita') }}</textarea>
                        @error('isi_berita')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.news.index') }}" class="btn btn-outline-secondary">Batal</a>
                        <button type="submit" class="btn" style="background-color: #0f3d2e; border-color: #0f3d2e; color: #fff;">
                            <i class="bi bi-save"></i> Simpan Berita
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
