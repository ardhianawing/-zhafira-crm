@extends('layouts.app')

@section('title', 'Marketing Tools - Zhafira CRM')

@section('content')
<div class="mb-4">
    <h4 class="mb-0">
        <i class="bi bi-tools" style="color: #0f3d2e;"></i> Marketing Tools
    </h4>
</div>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card h-100 text-center">
            <div class="card-body">
                <i class="bi bi-palette" style="font-size: 3rem; color: #0f3d2e;"></i>
                <h5 class="card-title mt-3">Canva</h5>
                <p class="card-text text-muted">Buat desain marketing, flyer, dan konten sosial media.</p>
                <a href="https://www.canva.com/design/DAG-6tXXWQw/U8IrGkNf0WPXYLt8GUXJlw/edit?utm_content=DAG-6tXXWQw&utm_campaign=designshare&utm_medium=link2&utm_source=sharebutton" target="_blank" class="btn" style="background-color: #0f3d2e; border-color: #0f3d2e; color: #fff;">
                    <i class="bi bi-box-arrow-up-right"></i> Buka Canva
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card h-100 text-center">
            <div class="card-body">
                <i class="bi bi-whatsapp text-success" style="font-size: 3rem;"></i>
                <h5 class="card-title mt-3">WhatsApp Web</h5>
                <p class="card-text text-muted">Buka WhatsApp Web untuk follow-up customer.</p>
                <a href="https://web.whatsapp.com" target="_blank" class="btn btn-success">
                    <i class="bi bi-box-arrow-up-right"></i> Buka WhatsApp
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card h-100 text-center">
            <div class="card-body">
                <i class="bi bi-folder text-warning" style="font-size: 3rem;"></i>
                <h5 class="card-title mt-3">Google Drive</h5>
                <p class="card-text text-muted">Akses file marketing, brosur, dan dokumen.</p>
                <a href="https://drive.google.com" target="_blank" class="btn btn-warning">
                    <i class="bi bi-box-arrow-up-right"></i> Buka Drive
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card mt-4">
    <div class="card-header" style="background-color: #0f3d2e; color: #fff;">
        <i class="bi bi-lightbulb"></i> Tips Follow-up
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h6>Siklus Follow-up 3-5-7</h6>
                <ul class="mb-0">
                    <li><strong>Fase 0:</strong> Follow-up pertama setelah 3 hari</li>
                    <li><strong>Fase 1:</strong> Follow-up kedua setelah 5 hari</li>
                    <li><strong>Fase 2:</strong> Follow-up ketiga setelah 7 hari</li>
                    <li><strong>Fase 3:</strong> Follow-up manual sesuai kebutuhan</li>
                </ul>
            </div>
            <div class="col-md-6">
                <h6>Best Practices</h6>
                <ul class="mb-0">
                    <li>Selalu catat hasil follow-up</li>
                    <li>Update status prospek sesuai progress</li>
                    <li>Gunakan template WhatsApp yang sudah disediakan</li>
                    <li>Jangan skip follow-up yang sudah dijadwalkan</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
