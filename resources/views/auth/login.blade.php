@extends('layouts.guest')

@section('title', 'Login - Zhafira CRM')

@section('content')
<div class="login-card">
    <div class="login-header">
        <h1><span class="logo-text">Zhafira</span> CRM</h1>
        <p class="mb-0 opacity-75">Customer Relationship Management</p>
    </div>

    <div class="login-body">
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" autocomplete="off">
            @csrf

            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                    <input type="text"
                           class="form-control @error('username') is-invalid @enderror"
                           id="username"
                           name="username"
                           value="{{ old('username') }}"
                           placeholder="Masukkan username"
                           autocomplete="username"
                           autofocus
                           required>
                </div>
                @error('username')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password"
                           class="form-control @error('password') is-invalid @enderror"
                           id="password"
                           name="password"
                           placeholder="Masukkan password"
                           autocomplete="current-password"
                           required>
                </div>
                @error('password')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4 form-check">
                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                <label class="form-check-label" for="remember">Ingat saya</label>
            </div>

            <button type="submit" class="btn btn-login w-100">
                <i class="bi bi-box-arrow-in-right"></i> Login
            </button>
        </form>
    </div>
</div>
@endsection
