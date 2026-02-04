@extends('layouts.app')

@section('title', 'Kelola News - Zhafira CRM')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">
        <i class="bi bi-newspaper" style="color: #0f3d2e;"></i> Kelola Berita
    </h4>
    <a href="{{ route('admin.news.create') }}" class="btn" style="background-color: #0f3d2e; border-color: #0f3d2e; color: #fff;">
        <i class="bi bi-plus-circle"></i> Tambah Berita
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr style="background-color: #0f3d2e; color: #fff;">
                        <th style="background-color: #0f3d2e; color: #fff; font-weight: 500;">Judul</th>
                        <th style="background-color: #0f3d2e; color: #fff; font-weight: 500;">Tanggal Post</th>
                        <th style="background-color: #0f3d2e; color: #fff; font-weight: 500;">Preview</th>
                        <th style="background-color: #0f3d2e; color: #fff; font-weight: 500; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($news as $item)
                    <tr>
                        <td><strong>{{ $item->judul }}</strong></td>
                        <td>{{ $item->tgl_post->format('d/m/Y') }}</td>
                        <td>{{ Str::limit(strip_tags($item->isi_berita), 80) }}</td>
                        <td class="text-center">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.news.edit', $item) }}" class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.news.destroy', $item) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus berita ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-4 text-muted">
                            <i class="bi bi-newspaper fs-3 d-block mb-2"></i>
                            Belum ada berita
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($news->hasPages())
    <div class="card-footer">
        {{ $news->links() }}
    </div>
    @endif
</div>
@endsection
