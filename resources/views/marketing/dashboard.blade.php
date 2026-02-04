@extends('layouts.app')

@section('title', 'Dashboard - Zhafira CRM')

@if($todayTasksCount > 0)
    <div class="alert alert-warning alert-dismissible fade show" role="alert" style="border-left: 5px solid #ffc107;">
        <i class="bi bi-bell-fill me-2"></i>
        <strong>Perhatian!</strong> Kamu punya <strong>{{ $todayTasksCount }}</strong> tugas follow-up yang harus diselesaikan hari ini.
        <a href="{{ route('marketing.leads.index') }}" class="alert-link">Klik di sini untuk lihat daftar.</a>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">
        <i class="bi bi-speedometer2" style="color: #0f3d2e;"></i> Dashboard
    </h4>
    <span class="text-muted">{{ now()->format('l, d F Y') }}</span>
</div>

<!-- Statistics Cards -->
<div class="row g-3 mb-4">
    <div class="col-md-4 col-6">
        <div class="card stat-card h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="text-muted mb-1">Total Leads Saya</h6>
                        <h3 class="mb-0">{{ number_format($totalLeads) }}</h3>
                    </div>
                    <div class="stat-icon">
                        <i class="bi bi-people"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-6">
        <div class="card stat-card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="text-muted mb-1">Tugas Hari Ini</h6>
                        <h3 class="mb-0 {{ $todaysTasks > 0 ? 'text-warning' : '' }}">{{ number_format($todaysTasks) }}</h3>
                    </div>
                    <div class="stat-icon ms-2">
                        <i class="bi bi-calendar-check"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-12">
        <div class="card stat-card h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="text-muted mb-1">Overdue</h6>
                        <h3 class="mb-0 {{ $overdueLeads > 0 ? 'text-danger' : '' }}">{{ number_format($overdueLeads) }}</h3>
                    </div>
                    <div class="stat-icon">
                        <i class="bi bi-exclamation-triangle {{ $overdueLeads > 0 ? 'text-danger' : '' }}"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Leads by Status -->
<div class="card mb-4">
    <div class="card-header" style="background-color: #0f3d2e; color: #fff;">
        <i class="bi bi-bar-chart"></i> Status Leads Saya
    </div>
    <div class="card-body">
        <div class="row text-center">
            <div class="col">
                <div class="p-2 bg-light rounded">
                    <span class="badge mb-1" style="background-color: #6c757d; color: #fff;">New</span>
                    <h5 class="mb-0">{{ $leadsByStatus['New'] ?? 0 }}</h5>
                </div>
            </div>
            <div class="col">
                <div class="p-2 bg-light rounded">
                    <span class="badge mb-1" style="background-color: #0dcaf0; color: #000;">Cold</span>
                    <h5 class="mb-0">{{ $leadsByStatus['Cold'] ?? 0 }}</h5>
                </div>
            </div>
            <div class="col">
                <div class="p-2 bg-light rounded">
                    <span class="badge mb-1" style="background-color: #ffc107; color: #000;">Warm</span>
                    <h5 class="mb-0">{{ $leadsByStatus['Warm'] ?? 0 }}</h5>
                </div>
            </div>
            <div class="col">
                <div class="p-2 bg-light rounded">
                    <span class="badge mb-1" style="background-color: #dc3545; color: #fff;">Hot</span>
                    <h5 class="mb-0">{{ $leadsByStatus['Hot'] ?? 0 }}</h5>
                </div>
            </div>
            <div class="col">
                <div class="p-2 bg-light rounded">
                    <span class="badge mb-1" style="background-color: #198754; color: #fff;">Deal</span>
                    <h5 class="mb-0">{{ $leadsByStatus['Deal'] ?? 0 }}</h5>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <!-- Today's Follow-ups -->
    <div class="col-md-7">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #0f3d2e; color: #fff;">
                <span><i class="bi bi-calendar-check"></i> Follow-up Hari Ini</span>
                <a href="{{ route('marketing.tasks.today') }}" class="btn btn-sm" style="background-color: #c9a227; border-color: #c9a227; color: #000;">Lihat Semua</a>
            </div>
            <div class="card-body">
                @forelse($todaysFollowups as $lead)
                    <x-lead-card :lead="$lead" />
                @empty
                <div class="text-center py-4 text-muted">
                    <i class="bi bi-check-circle fs-3 d-block mb-2"></i>
                    <p class="mb-0">Tidak ada tugas hari ini</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Recent News & Quick Actions -->
    <div class="col-md-5">
        <div class="card mb-3">
            <div class="card-header" style="background-color: #0f3d2e; color: #fff;">
                <i class="bi bi-lightning"></i> Quick Actions
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('marketing.leads.create') }}" class="btn" style="background-color: #0f3d2e; border-color: #0f3d2e; color: #fff;">
                        <i class="bi bi-plus-circle"></i> Tambah Lead Baru
                    </a>
                    <a href="{{ route('marketing.tasks.today') }}" class="btn" style="border-color: #0f3d2e; color: #0f3d2e;">
                        <i class="bi bi-calendar-check"></i> Lihat Tugas Hari Ini
                    </a>
                    <a href="{{ route('marketing.tools') }}" class="btn" style="border-color: #0f3d2e; color: #0f3d2e;">
                        <i class="bi bi-tools"></i> Marketing Tools
                    </a>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header" style="background-color: #0f3d2e; color: #fff;">
                <i class="bi bi-newspaper"></i> Berita Terbaru
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @forelse($recentNews as $news)
                    <div class="list-group-item">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <strong>{{ $news->judul }}</strong>
                                <br>
                                <small>{{ Str::limit(strip_tags($news->isi_berita), 60) }}</small>
                            </div>
                            <small class="text-muted">{{ $news->tgl_post->format('d/m') }}</small>
                        </div>
                    </div>
                    @empty
                    <div class="list-group-item text-center text-muted py-3">
                        Belum ada berita
                    </div>
                    @endforelse
                </div>
            </div>
            <div class="card-footer text-center">
                <a href="{{ route('marketing.news.index') }}" style="color: #0f3d2e;">Lihat Semua Berita</a>
            </div>
        </div>
    </div>
</div>
@endsection
