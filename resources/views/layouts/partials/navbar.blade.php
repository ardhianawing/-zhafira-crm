<nav class="navbar navbar-expand-lg navbar-dark sticky-top" style="background-color: #0f3d2e;">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('marketing.dashboard') }}" style="color: #fff;">
            <span style="color: #c9a227;">Zhafira</span> CRM
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMain">
            @auth
                @if(auth()->user()->isAdmin())
                    {{-- Admin Menu --}}
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.leads.*') ? 'active' : '' }}" href="{{ route('admin.leads.index') }}">
                                <i class="bi bi-people"></i> Leads
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.assignment.*') ? 'active' : '' }}" href="{{ route('admin.assignment.index') }}">
                                <i class="bi bi-person-plus"></i> Distribusi Lead
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.news.*') ? 'active' : '' }}" href="{{ route('admin.news.index') }}">
                                <i class="bi bi-newspaper"></i> News
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                                <i class="bi bi-person-gear"></i> Users
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.whatsapp-templates.*') ? 'active' : '' }}" href="{{ route('admin.whatsapp-templates.index') }}">
                                <i class="bi bi-whatsapp"></i> WA Template
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="https://docs.google.com/spreadsheets/d/1iiO70Pr4uqcPb5-o1cSE8ufXRcDYuRz-VgSKatIQS4A/edit" target="_blank">
                                <i class="bi bi-file-earmark-spreadsheet"></i> Spreadsheet
                            </a>
                        </li>
                    </ul>
                @else
                    {{-- Marketing Menu --}}
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('marketing.dashboard') ? 'active' : '' }}" href="{{ route('marketing.dashboard') }}">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('marketing.leads.*') ? 'active' : '' }}" href="{{ route('marketing.leads.index') }}">
                                <i class="bi bi-people"></i> Leads Saya
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('marketing.tasks.*') ? 'active' : '' }}" href="{{ route('marketing.tasks.today') }}">
                                <i class="bi bi-calendar-check"></i> Tugas Hari Ini
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('marketing.news.*') ? 'active' : '' }}" href="{{ route('marketing.news.index') }}">
                                <i class="bi bi-newspaper"></i> News
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('marketing.tools') ? 'active' : '' }}" href="{{ route('marketing.tools') }}">
                                <i class="bi bi-tools"></i> Tools
                            </a>
                        </li>
                    </ul>
                @endif

                <ul class="navbar-nav">
                    {{-- Install PWA Button --}}
                    <li class="nav-item">
                        <a class="nav-link" href="#" id="installBtn" onclick="installPWA()" style="display: none;" title="Install Aplikasi">
                            <i class="bi bi-download"></i> <span class="d-lg-none">Install</span>
                        </a>
                    </li>

                    {{-- Notification Bell Perbaikan Sejajar --}}
                    @if(!auth()->user()->isAdmin())
                    @php
                        $overdueCount = \App\Models\Lead::where('assigned_to', auth()->id())
                            ->whereNotNull('tgl_next_followup')
                            ->where('tgl_next_followup', '<=', now()->toDateString())
                            ->whereNotIn('status_prospek', ['Deal', 'Loss'])
                            ->count();
                    @endphp
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center" href="{{ route('marketing.tasks.today') }}" title="Tugas Follow-up">
                            <div class="position-relative">
                                <i class="bi bi-bell{{ $overdueCount > 0 ? '-fill' : '' }} fs-5"></i>
                                @if($overdueCount > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem; padding: 0.25rem 0.4rem;">
                                    {{ $overdueCount > 9 ? '9+' : $overdueCount }}
                                </span>
                                @endif
                            </div>
                            <span class="d-lg-none ms-3">Notifikasi</span>
                        </a>
                    </li>
                    @endif

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle"></i> {{ auth()->user()->nama_lengkap }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                            <li>
                                <span class="dropdown-item-text text-muted">
                                    <small>{{ ucfirst(auth()->user()->role) }}</small>
                                </span>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            @endauth
        </div>
    </div>
</nav>