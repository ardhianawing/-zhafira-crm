<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Zhafira CRM')</title>

    <meta name="theme-color" content="#0f3d2e">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="Zhafira CRM">
    <link rel="manifest" href="/manifest.json">
    <link rel="icon" type="image/png" href="/favicon.png">
    <link rel="apple-touch-icon" href="/icons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/icons/icon-192x192.png">
    <link rel="icon" type="image/png" sizes="512x512" href="/icons/icon-512x512.png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --zhafira-green: #0f3d2e;
            --zhafira-gold: #c9a227;
            --zhafira-green-light: #1a5c44;
        }

        body {
            background-color: #f8f9fa;
            min-height: 100vh;
        }

        /* PERBAIKAN NOTIFIKASI MOBILE */
        .nav-link.position-relative {
            display: flex !important;
            align-items: center;
        }

        /* Menjaga angka notifikasi tetap sejajar di atas ikon lonceng */
        .navbar-zhafira .badge-notification {
            position: absolute;
            top: 5px;
            right: 5px;
            padding: 2px 5px;
            border-radius: 50%;
            font-size: 0.6rem;
            transform: translate(50%, -50%);
        }

        /* Styling CSS lainnya tetap sama */
        .navbar-zhafira {
            background-color: var(--zhafira-green) !important;
        }

        .navbar-zhafira .navbar-brand,
        .navbar-zhafira .nav-link {
            color: #fff !important;
        }

        .navbar-zhafira .nav-link:hover {
            color: var(--zhafira-gold) !important;
        }

        .navbar-zhafira .nav-link.active {
            color: var(--zhafira-gold) !important;
            font-weight: 600;
        }

        .btn-zhafira {
            background-color: var(--zhafira-green);
            border-color: var(--zhafira-green);
            color: #fff;
        }

        .btn-zhafira:hover {
            background-color: var(--zhafira-green-light);
            border-color: var(--zhafira-green-light);
            color: #fff;
        }

        .btn-outline-zhafira {
            border-color: var(--zhafira-green);
            color: var(--zhafira-green);
        }

        .btn-outline-zhafira:hover {
            background-color: var(--zhafira-green);
            color: #fff;
        }

        .btn-gold {
            background-color: var(--zhafira-gold);
            border-color: var(--zhafira-gold);
            color: #000;
        }

        .btn-gold:hover {
            background-color: #b8921f;
            border-color: #b8921f;
            color: #000;
        }

        .card-header-zhafira {
            background-color: var(--zhafira-green);
            color: #fff;
        }

        .text-zhafira {
            color: var(--zhafira-green);
        }

        .text-gold {
            color: var(--zhafira-gold);
        }

        .bg-zhafira {
            background-color: var(--zhafira-green);
        }

        .bg-zhafira-light {
            background-color: rgba(15, 61, 46, 0.1);
        }

        .border-zhafira-light {
            border-color: rgba(15, 61, 46, 0.2) !important;
        }

        .table th {
            background-color: var(--zhafira-green);
            color: #fff;
            font-weight: 500;
        }

        .stat-card {
            border-left: 4px solid var(--zhafira-gold);
            transition: transform 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-2px);
        }

        .stat-card .stat-icon {
            font-size: 2rem;
            color: var(--zhafira-gold);
        }

        .lead-card {
            border-left: 4px solid var(--zhafira-gold);
            margin-bottom: 1rem;
        }

        .lead-card.overdue {
            border-left-color: #dc3545;
            background-color: #fff5f5;
        }

        .badge-new {
            background-color: #6c757d;
        }

        .badge-cold {
            background-color: #0dcaf0;
            color: #000;
        }

        .badge-warm {
            background-color: #ffc107;
            color: #000;
        }

        .badge-hot {
            background-color: #dc3545;
        }

        .badge-deal {
            background-color: #198754;
        }

        .whatsapp-btn {
            background-color: #25D366;
            border-color: #25D366;
            color: #fff;
        }

        .whatsapp-btn:hover {
            background-color: #1da851;
            border-color: #1da851;
            color: #fff;
        }

        @media (max-width: 768px) {
            .table-responsive {
                font-size: 0.875rem;
            }

            .btn-mobile-full {
                width: 100%;
                margin-bottom: 0.5rem;
            }

            /* Khusus Mobile: Geser angka notif agar tidak nabrak teks */
            .navbar-zhafira .badge-notification {
                top: 15px;
                right: auto;
                left: 25px;
            }
        }

        .sidebar {
            min-height: calc(100vh - 56px);
            background-color: #fff;
            border-right: 1px solid #dee2e6;
        }

        .sidebar .nav-link {
            color: var(--zhafira-green);
            padding: 0.75rem 1rem;
        }

        .sidebar .nav-link:hover {
            background-color: #f8f9fa;
        }

        .sidebar .nav-link.active {
            background-color: var(--zhafira-green);
            color: #fff;
        }

        .sidebar .nav-link i {
            width: 24px;
        }
    </style>
    @stack('styles')
</head>

<body>
    @include('layouts.partials.navbar')

    <!-- PWA Install Instruction Modal -->
    @auth
    @if(auth()->user()->role === 'marketing')
    <div class="modal fade" id="installInstructionModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-zhafira text-white">
                    <h5 class="modal-title">
                        <i class="bi bi-phone me-2"></i>Install Aplikasi
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-4">
                    <div class="text-center mb-4">
                        <img src="/icons/icon-192x192.png" alt="Zhafira CRM" style="width: 64px; height: 64px; border-radius: 12px;">
                    </div>

                    <!-- Auto Install Button -->
                    <div id="autoInstallSection" style="display: none;" class="text-center mb-4">
                        <button type="button" class="btn btn-zhafira btn-lg w-100" onclick="installPWA()">
                            <i class="bi bi-download me-2"></i>Install Sekarang
                        </button>
                        <hr class="my-4">
                        <p class="text-muted small">Atau install manual:</p>
                    </div>

                    <!-- Manual Install Instructions -->
                    <div class="accordion" id="installAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#androidInstall">
                                    <i class="bi bi-android2 me-2 text-success"></i> Android (Chrome)
                                </button>
                            </h2>
                            <div id="androidInstall" class="accordion-collapse collapse show" data-bs-parent="#installAccordion">
                                <div class="accordion-body">
                                    <ol class="mb-0 ps-3">
                                        <li>Tap tombol <strong>⋮</strong> (menu) di pojok kanan atas</li>
                                        <li>Pilih <strong>"Install app"</strong> atau <strong>"Add to Home screen"</strong></li>
                                        <li>Tap <strong>"Install"</strong></li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#iosInstall">
                                    <i class="bi bi-apple me-2"></i> iPhone (Safari)
                                </button>
                            </h2>
                            <div id="iosInstall" class="accordion-collapse collapse" data-bs-parent="#installAccordion">
                                <div class="accordion-body">
                                    <ol class="mb-0 ps-3">
                                        <li>Tap tombol <strong>Share</strong> <i class="bi bi-box-arrow-up"></i> di bawah</li>
                                        <li>Scroll dan pilih <strong>"Add to Home Screen"</strong></li>
                                        <li>Tap <strong>"Add"</strong></li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info mt-3 mb-0 small">
                        <i class="bi bi-info-circle me-1"></i>
                        Setelah install, Anda akan mendapat notifikasi setiap ada lead baru!
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    @endauth

    <main class="py-4">
        <div class="container-fluid px-4">
            @if(session('success'))
                <x-alert type="success" :message="session('success')" />
            @endif

            @if(session('error'))
                <x-alert type="danger" :message="session('error')" />
            @endif

            @if(session('warning'))
                <x-alert type="warning" :message="session('warning')" />
            @endif

            @yield('content')
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Service Worker Registration
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js')
                    .then(reg => {
                        console.log('SW registered');
                        @auth
                        // Subscribe to push notifications after SW is ready
                        subscribeToPush(reg);
                        @endauth
                    })
                    .catch(err => console.log('SW registration failed'));
            });
        }

        // Push Notification Subscription
        async function subscribeToPush(registration) {
            try {
                // Check if already subscribed
                const existingSubscription = await registration.pushManager.getSubscription();
                if (existingSubscription) {
                    console.log('Already subscribed to push');
                    return;
                }

                // Get VAPID public key from server
                const response = await fetch('/push/key');
                const { publicKey } = await response.json();

                if (!publicKey) {
                    console.log('VAPID key not configured');
                    return;
                }

                // Request notification permission
                const permission = await Notification.requestPermission();
                if (permission !== 'granted') {
                    console.log('Notification permission denied');
                    return;
                }

                // Subscribe to push
                const subscription = await registration.pushManager.subscribe({
                    userVisibleOnly: true,
                    applicationServerKey: urlBase64ToUint8Array(publicKey)
                });

                // Send subscription to server
                await fetch('/push/subscribe', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(subscription)
                });

                console.log('Push subscription successful');
            } catch (error) {
                console.error('Push subscription failed:', error);
            }
        }

        // Helper function to convert VAPID key
        function urlBase64ToUint8Array(base64String) {
            const padding = '='.repeat((4 - base64String.length % 4) % 4);
            const base64 = (base64String + padding).replace(/-/g, '+').replace(/_/g, '/');
            const rawData = window.atob(base64);
            const outputArray = new Uint8Array(rawData.length);
            for (let i = 0; i < rawData.length; ++i) {
                outputArray[i] = rawData.charCodeAt(i);
            }
            return outputArray;
        }

        // PWA Install
        let deferredPrompt;
        const installBtnAuto = document.getElementById('installBtnAuto');
        const installBtnManual = document.getElementById('installBtnManual');
        const autoInstallSection = document.getElementById('autoInstallSection');

        // Hide install buttons if already running as PWA
        if (isInstalledPWA()) {
            if (installBtnManual) installBtnManual.style.display = 'none';
            if (installBtnAuto) installBtnAuto.style.display = 'none';
        }

        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            deferredPrompt = e;

            // Show auto install button, hide manual
            if (installBtnAuto) installBtnAuto.style.display = 'block';
            if (installBtnManual) installBtnManual.style.display = 'none';
            if (autoInstallSection) autoInstallSection.style.display = 'block';
        });

        function installPWA() {
            if (deferredPrompt) {
                deferredPrompt.prompt();
                deferredPrompt.userChoice.then((choiceResult) => {
                    if (choiceResult.outcome === 'accepted') {
                        console.log('PWA installed');
                        localStorage.setItem('pwaInstalled', 'true');
                        // Hide all install buttons
                        if (installBtnAuto) installBtnAuto.style.display = 'none';
                        if (installBtnManual) installBtnManual.style.display = 'none';
                    }
                    deferredPrompt = null;

                    // Close modal if open
                    const modalEl = document.getElementById('installInstructionModal');
                    if (modalEl) {
                        const modal = bootstrap.Modal.getInstance(modalEl);
                        if (modal) modal.hide();
                    }
                });
            }
        }

        function isInstalledPWA() {
            return window.matchMedia('(display-mode: standalone)').matches
                || window.navigator.standalone === true;
        }
    </script>
    @stack('scripts')
</body>

</html>