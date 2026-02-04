<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Login - Zhafira CRM')</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="/favicon.png">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --zhafira-green: #0f3d2e;
            --zhafira-gold: #c9a227;
        }

        body {
            background: linear-gradient(135deg, var(--zhafira-green) 0%, #1a5c44 100%);
            min-height: 100vh;
        }

        .login-card {
            background: #fff;
            border-radius: 1rem;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            overflow: hidden;
            max-width: 400px;
            width: 100%;
        }

        .login-header {
            background-color: var(--zhafira-green);
            color: #fff;
            padding: 2rem;
            text-align: center;
        }

        .login-header h1 {
            font-size: 1.75rem;
            margin-bottom: 0.5rem;
        }

        .login-header .logo-text {
            color: var(--zhafira-gold);
            font-weight: 700;
        }

        .login-body {
            padding: 2rem;
        }

        .btn-login {
            background-color: var(--zhafira-green);
            border-color: var(--zhafira-green);
            color: #fff;
            padding: 0.75rem;
            font-weight: 500;
        }

        .btn-login:hover {
            background-color: #1a5c44;
            border-color: #1a5c44;
            color: #fff;
        }

        .form-control:focus {
            border-color: var(--zhafira-gold);
            box-shadow: 0 0 0 0.25rem rgba(201, 162, 39, 0.25);
        }

        .input-group-text {
            background-color: var(--zhafira-green);
            border-color: var(--zhafira-green);
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="container d-flex align-items-center justify-content-center min-vh-100">
        @yield('content')
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
