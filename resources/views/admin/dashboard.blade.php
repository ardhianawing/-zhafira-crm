@extends('layouts.app')

@section('title', 'Admin Dashboard - Zhafira CRM')

@section('content')
<div class="mb-4">
    <h4 class="mb-0">Selamat Datang, <span style="color: #0f3d2e;">{{ auth()->user()->nama_lengkap }}</span></h4>
    <p class="text-muted">Berikut ringkasan performa CRM hari ini.</p>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3 col-6">
        <div class="card stat-card h-100">
            <div class="card-body">
                <h6 class="text-muted mb-1">Total Leads</h6>
                <h3 class="mb-0">{{ number_format($stats['total_leads']) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="card stat-card h-100 border-warning">
            <div class="card-body">
                <h6 class="text-muted mb-1 text-warning">Hot Leads</h6>
                <h3 class="mb-0">{{ number_format($stats['hot_leads']) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="card stat-card h-100 border-success">
            <div class="card-body">
                <h6 class="text-muted mb-1 text-success">Total Deal</h6>
                <h3 class="mb-0">{{ number_format($stats['deal_leads']) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="card stat-card h-100 border-danger">
            <div class="card-body">
                <h6 class="text-muted mb-1 text-danger">Unassigned</h6>
                <h3 class="mb-0">{{ number_format($stats['unassigned']) }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold"><i class="bi bi-trophy me-2" style="color: #c9a227;"></i> Performa Tim Marketing</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr style="background-color: #0f3d2e; color: #fff;">
                                <th style="background-color: #0f3d2e; color: #fff; font-weight: 500;">Nama Marketing</th>
                                <th style="background-color: #0f3d2e; color: #fff; font-weight: 500; text-align: center;">Total Lead</th>
                                <th style="background-color: #0f3d2e; color: #fff; font-weight: 500; text-align: center;">Hot 🔥</th>
                                <th style="background-color: #0f3d2e; color: #fff; font-weight: 500; text-align: center;">Deal 🚀</th>
                                <th style="background-color: #0f3d2e; color: #fff; font-weight: 500; text-align: center;">Closing Rate</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($marketingPerformance as $m)
                            <tr>
                                <td>
                                    <div class="fw-bold">{{ $m->nama_lengkap }}</div>
                                    <small class="text-muted">{{ $m->username }}</small>
                                </td>
                                <td class="text-center">{{ $m->total }}</td>
                                <td class="text-center"><span class="badge bg-danger">{{ $m->hot }}</span></td>
                                <td class="text-center"><span class="badge bg-success">{{ $m->deal }}</span></td>
                                <td class="text-center">
                                    @php
                                        $rate = $m->total > 0 ? ($m->deal / $m->total) * 100 : 0;
                                    @endphp
                                    <div class="fw-bold" style="color: #0f3d2e;">{{ number_format($rate, 1) }}%</div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold"><i class="bi bi-graph-up me-2" style="color: #0f3d2e;"></i> Leads 7 Hari Terakhir</h6>
            </div>
            <div class="card-body">
                @foreach($last7Days as $data)
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <small class="fw-bold">{{ $data['day'] }}</small>
                        <small class="text-muted">{{ $data['count'] }} Leads</small>
                    </div>
                    <div class="progress" style="height: 8px;">
                        @php
                            $max = collect($last7Days)->max('count');
                            $width = $max > 0 ? ($data['count'] / $max) * 100 : 0;
                        @endphp
                        <div class="progress-bar" role="progressbar" style="width: {{ $width }}%; background-color: #0f3d2e;"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection