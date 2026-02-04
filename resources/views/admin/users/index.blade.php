@extends('layouts.app')

@section('title', 'Kelola Users - Zhafira CRM')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">
        <i class="bi bi-person-gear" style="color: #0f3d2e;"></i> Kelola Users
    </h4>
    <a href="{{ route('admin.users.create') }}" class="btn" style="background-color: #0f3d2e; border-color: #0f3d2e; color: #fff;">
        <i class="bi bi-plus-circle"></i> Tambah User
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr style="background-color: #0f3d2e; color: #fff;">
                        <th style="background-color: #0f3d2e; color: #fff; font-weight: 500;">Username</th>
                        <th style="background-color: #0f3d2e; color: #fff; font-weight: 500;">Nama Lengkap</th>
                        <th style="background-color: #0f3d2e; color: #fff; font-weight: 500;">Role</th>
                        <th style="background-color: #0f3d2e; color: #fff; font-weight: 500; text-align: center;">Leads</th>
                        <th style="background-color: #0f3d2e; color: #fff; font-weight: 500; text-align: center;">Status</th>
                        <th style="background-color: #0f3d2e; color: #fff; font-weight: 500; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr class="{{ !$user->is_active ? 'table-secondary' : '' }}">
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->nama_lengkap }}</td>
                        <td>
                            <span class="badge" style="background-color: {{ $user->role === 'admin' ? '#0f3d2e' : '#0dcaf0' }}; color: {{ $user->role === 'admin' ? '#fff' : '#000' }};">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td class="text-center">{{ $user->leads_count }}</td>
                        <td class="text-center">
                            @if($user->is_active)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary">Nonaktif</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                @if($user->id !== auth()->id())
                                    <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-outline-{{ $user->is_active ? 'warning' : 'success' }} btn-sm" title="{{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                            <i class="bi bi-{{ $user->is_active ? 'x-circle' : 'check-circle' }}"></i>
                                        </button>
                                    </form>
                                    @if($user->leads_count === 0)
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus user ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                    @endif
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">
                            Belum ada user
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($users->hasPages())
    <div class="card-footer">
        {{ $users->links() }}
    </div>
    @endif
</div>
@endsection
