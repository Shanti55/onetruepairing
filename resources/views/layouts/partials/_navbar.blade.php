<nav class="navbar navbar-expand py-1 px-3 shadow-sm border-bottom" style="background: white;">
    <button class="btn" id="sidebar-toggle" type="button">
        <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="navbar-collapse navbar">
        <ul class="navbar-nav ms-auto align-items-center">
            
            {{-- 1. Theme Toggle --}}
            <li class="nav-item me-2 theme-toggle">
                <a class="nav-link" href="#"><i class="bi bi-moon"></i></a>
            </li>

            {{-- 2. Notification Dropdown (NEW ADDED) --}}
            <li class="nav-item dropdown me-3">
                <a class="nav-link nav-icon position-relative" href="javascript:void(0)" id="notificationDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-bell fs-5 text-dark"></i>
                    @if(auth()->user()->unreadNotifications->count() > 0)
                        <span class="badge bg-danger badge-number pulse-animation position-absolute top-0 start-100 translate-middle rounded-circle" style="font-size: 0.6rem; padding: 4px 6px;">
                            {{ auth()->user()->unreadNotifications->count() }}
                        </span>
                    @endif
                </a>

                <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 mt-3 py-0" aria-labelledby="notificationDropdown" style="width: 320px; z-index: 9999;">
                    <li class="dropdown-header fw-bold border-bottom p-3">Recent Notifications</li>

                    <div class="notification-scroll-area" style="max-height: 350px; overflow-y: auto;">
                        @forelse(auth()->user()->notifications->take(10) as $notification)
                            <li class="notification-item border-bottom {{ $notification->unread() ? 'bg-white' : 'bg-light' }}">
                                <a href="{{ route('notifications.read', $notification->id) }}" class="text-decoration-none p-3 d-block">
                                    <div class="d-flex align-items-center">
                                        <div class="{{ $notification->unread() ? 'bg-danger-light text-danger' : 'bg-secondary-light text-secondary' }} rounded-circle p-2 me-3 d-flex align-items-center justify-content-center" style="min-width: 40px; height: 40px;">
                                            <i class="bi {{ $notification->data['icon'] ?? 'bi-bell' }}"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <p class="text-dark {{ $notification->unread() ? 'fw-bold' : '' }} mb-0 small">
                                                {{ $notification->data['title'] ?? ($notification->data['type'] ?? 'Notification') }}
                                            </p>
                                            <p class="text-muted extra-small mb-1 line-clamp" style="font-size: 0.75rem;">
                                                {{ $notification->data['message'] ?? 'New update received.' }}
                                            </p>
                                            <div class="text-muted mt-1" style="font-size: 0.65rem;">
                                                <i class="bi bi-clock me-1"></i>{{ $notification->created_at->diffForHumans() }}
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        @empty
                            <li class="p-4 text-center text-muted small">No notifications found</li>
                        @endforelse
                    </div>
                    <li class="p-2 text-center border-top">
                        <a href="{{ route('service-providers.notifications.index') }}" class="small fw-bold text-decoration-none text-primary">View All</a>
                    </li>
                </ul>
            </li>

            {{-- 3. Profile Dropdown --}}
            <li class="nav-item dropdown">
                <a href="#" data-bs-toggle="dropdown" class="nav-icon pe-md-0">
                    <img src="https://ui-avatars.com/api/?background=FFCCA6&color=000&name={{urlencode(auth()->user()->name)}}" class="avatar img-fluid rounded" alt="User" style="width: 35px; height: 35px;">
                </a>
                <div class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                    <a href="{{ route('profile-settings.index') }}" class="dropdown-item py-2"><i class="bi bi-person me-2"></i> Profile</a>
                    <a href="#" class="dropdown-item py-2"><i class="bi bi-gear me-2"></i> Settings</a>
                    <hr class="dropdown-divider">
                    <a href="#" onclick="event.preventDefault();$('#logout-form').submit();" class="dropdown-item py-2 text-danger">
                        <i class="bi bi-box-arrow-left me-2"></i> Logout
                    </a>

                    <form method="POST" id="logout-form" action="{{ route('logout') }}" class="d-none">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
    </div>
</nav>

<style>
    .bg-danger-light { background-color: #ffe5e5; }
    .bg-secondary-light { background-color: #f8f9fa; }
    .line-clamp {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .notification-item:hover { background-color: #f1f1f1; transition: 0.2s; }
    
    .pulse-animation {
        animation: pulse-red 2s infinite;
        border: 2px solid #fff;
    }
    @keyframes pulse-red {
        0% { box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.7); }
        70% { box-shadow: 0 0 0 6px rgba(220, 53, 69, 0); }
        100% { box-shadow: 0 0 0 0 rgba(220, 53, 69, 0); }
    }
    .notification-scroll-area::-webkit-scrollbar { width: 4px; }
    .notification-scroll-area::-webkit-scrollbar-thumb { background: #ccc; border-radius: 10px; }
</style>