<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'لوحة التحكم') — {{ config('vip.company_name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body>
    <nav class="vip-sidebar">
        <div class="brand">
            <h4><i class="bi bi-shield-check"></i> شركة البديل</h4>
            <small style="font-size:0.65rem; opacity:0.8;">للخدمات العامة واللوجستية</small>
            <p style="color:#fff; opacity:1;" class="mb-2">نظام إدارة بطاقات العضوية</p>
            
        </div>
        <ul class="nav flex-column mt-3">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                    <i class="bi bi-speedometer2"></i> لوحة التحكم
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('customers.*') ? 'active' : '' }}" href="{{ route('customers.index') }}">
                    <i class="bi bi-people"></i> العملاء
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('cards.*') ? 'active' : '' }}" href="{{ route('cards.index') }}">
                    <i class="bi bi-credit-card-2-front"></i> البطاقات
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('messages.*') ? 'active' : '' }}" href="{{ route('messages.index') }}">
                    <i class="bi bi-chat-dots"></i> الرسائل الجماعية
                </a>
            </li>
            @if(auth()->user()->isAdmin())
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}" href="{{ route('users.index') }}">
                    <i class="bi bi-person-gear"></i> المستخدمين
                </a>
            </li>
            @endif
        </ul>
        <div class="position-absolute bottom-0 w-100 p-3 border-top border-secondary border-opacity-25">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="nav-link w-100 border-0 bg-transparent text-start">
                    <i class="bi bi-box-arrow-right"></i> تسجيل الخروج
                </button>
            </form>
        </div>
    </nav>

    <main class="vip-main">
        <div class="vip-topbar">
            <div>
                <h5 class="mb-0 text-dark">@yield('page-title', 'لوحة التحكم')</h5>
                <small class="text-muted">@yield('page-subtitle')</small>
            </div>
            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-light text-dark">
                    <i class="bi bi-person-circle"></i> {{ auth()->user()->name }}
                </span>
                <span class="badge {{ auth()->user()->isAdmin() ? 'bg-warning text-dark' : 'bg-info' }}">
                    {{ auth()->user()->role->label() }}
                </span>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
