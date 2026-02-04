@extends('layouts.app')

@section('title', 'Berita - Zhafira CRM')

@section('content')
<div class="mb-4">
    <h4 class="mb-0">
        <i class="bi bi-newspaper" style="color: #0f3d2e;"></i> Berita & Promo
    </h4>
</div>

<div class="row">
    @forelse($news as $item)
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-header" style="background-color: #0f3d2e; color: #fff;">
                {{ $item->judul }}
            </div>
            <div class="card-body">
                <p class="text-muted small mb-2">
                    <i class="bi bi-calendar"></i> {{ $item->tgl_post->format('d F Y') }}
                </p>
                <div class="card-text">
                    {!! nl2br(e($item->isi_berita)) !!}
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="card">
            <div class="card-body text-center py-5 text-muted">
                <i class="bi bi-newspaper fs-1 d-block mb-3"></i>
                <p>Belum ada berita</p>
            </div>
        </div>
    </div>
    @endforelse
</div>

@if($news->hasPages())
<div class="d-flex justify-content-center">
    {{ $news->links() }}
</div>
@endif
@endsection
