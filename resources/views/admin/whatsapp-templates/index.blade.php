@extends('layouts.app')

@section('title', 'WhatsApp Templates - Zhafira CRM')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">
        <i class="bi bi-whatsapp text-success"></i> WhatsApp Templates
    </h4>
    <a href="{{ route('admin.whatsapp-templates.create') }}" class="btn" style="background-color: #0f3d2e; border-color: #0f3d2e; color: #fff;">
        <i class="bi bi-plus-circle"></i> Tambah Template
    </a>
</div>

<div class="card">
    <div class="card-body">
        @if($templates->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr style="background-color: #0f3d2e; color: #fff;">
                        <th style="width: 50px; background-color: #0f3d2e; color: #fff; font-weight: 500;">#</th>
                        <th style="background-color: #0f3d2e; color: #fff; font-weight: 500;">Nama Template</th>
                        <th style="background-color: #0f3d2e; color: #fff; font-weight: 500;">Preview</th>
                        <th style="width: 100px; background-color: #0f3d2e; color: #fff; font-weight: 500;">Status</th>
                        <th style="width: 150px; background-color: #0f3d2e; color: #fff; font-weight: 500;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($templates as $template)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><strong>{{ $template->nama_template }}</strong></td>
                        <td>
                            <small class="text-muted">
                                {{ Str::limit($template->isi_template, 100) }}
                            </small>
                        </td>
                        <td>
                            @if($template->is_active)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary">Nonaktif</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.whatsapp-templates.edit', $template) }}" class="btn btn-outline-primary" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.whatsapp-templates.toggle-status', $template) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-outline-{{ $template->is_active ? 'warning' : 'success' }}" title="{{ $template->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                        <i class="bi bi-{{ $template->is_active ? 'pause' : 'play' }}"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.whatsapp-templates.destroy', $template) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus template ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center py-5 text-muted">
            <i class="bi bi-chat-text fs-1 d-block mb-3"></i>
            <p>Belum ada template WhatsApp.</p>
            <a href="{{ route('admin.whatsapp-templates.create') }}" class="btn" style="background-color: #0f3d2e; border-color: #0f3d2e; color: #fff;">
                <i class="bi bi-plus-circle"></i> Tambah Template Pertama
            </a>
        </div>
        @endif
    </div>
</div>

<div class="card mt-4">
    <div class="card-header" style="background-color: #0f3d2e; color: #fff;">
        <i class="bi bi-lightbulb"></i> Cara Penggunaan
    </div>
    <div class="card-body">
        <ol class="mb-0">
            <li>Buat template pesan untuk follow-up</li>
            <li>Marketing bisa melihat dan copy template di halaman detail lead</li>
            <li>Paste ke WhatsApp untuk follow-up customer</li>
        </ol>
    </div>
</div>
@endsection
