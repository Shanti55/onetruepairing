<nav class="navbar navbar-expand py-1 px-3 shadow-sm border-bottom" style="background: white;">
    <a href="#" data-bs-target="#sidebar" data-bs-toggle="collapse" class="text-decoration-none">
        <span class="navbar-toggler-icon"></span>
    </a>
    
    <div class="navbar-collapse navbar">
        @if (!auth()->user()->hasVerifiedEmail())
            <div class="alert alert-warning alert-dismissible fade show mb-0 ms-3 py-1" role="alert" style="font-size: 0.85rem;">
                <strong>Notice:</strong> Please <a href="{{ route('verification.notice') }}" class="alert-link">verify your email</a>.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="padding: 0.5rem;"></button>
            </div>
        @endif

        <ul class="navbar-nav ms-auto align-items-center">  
            {{-- Notification Dropdown --}}
            <li class="nav-item dropdown me-3">
                <a class="nav-link nav-icon position-relative" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-bell fs-5 text-dark"></i>
                    @if(auth()->user()->unreadNotifications->count() > 0)
                        <span class="badge bg-danger badge-number pulse-animation position-absolute top-0 start-100 translate-middle rounded-circle" style="font-size: 0.65rem; padding: 4px 6px;">
                            {{ auth()->user()->unreadNotifications->count() }}
                        </span>
                    @endif
                </a>

                <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 mt-3 py-0" aria-labelledby="notificationDropdown" style="width: 320px; z-index: 999999;">
                    <li class="dropdown-header fw-bold border-bottom p-3">
                        Recent Notifications ({{ auth()->user()->unreadNotifications->count() }})
                    </li>

                    <div class="notification-scroll-area" style="max-height: 350px; overflow-y: auto;">
                        @forelse(auth()->user()->notifications->take(10) as $notification)
                            <li class="notification-item border-bottom {{ $notification->unread() ? 'bg-white' : 'bg-light' }}">
                                <a href="{{ route('notifications.read', $notification->id) }}" class="text-decoration-none p-3 d-block">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle p-2 me-3 {{ $notification->unread() ? 'bg-danger-light text-danger' : 'bg-light text-secondary' }} d-flex align-items-center justify-content-center" style="min-width: 40px; height: 40px;">
                                            <i class="bi {{ $notification->data['icon'] ?? 'bi-bell' }}"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            {{-- Tinker data support: Title > Type > Default --}}
                                            <p class="text-dark {{ $notification->unread() ? 'fw-bold' : '' }} mb-0 small">
                                                {{ $notification->data['title'] ?? ($notification->data['type'] ?? 'New Update') }}
                                            </p>
                                            <p class="text-muted mb-1" style="font-size: 0.75rem;">
                                                {{ $notification->data['message'] ?? 'You have a new notification.' }}
                                            </p>
                                            <div class="text-muted" style="font-size: 0.65rem;">
                                                <i class="bi bi-clock me-1"></i>{{ $notification->created_at->diffForHumans() }}
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        @empty
                            <li class="p-4 text-center text-muted small">No notifications yet</li>
                        @endforelse
                    </div>

                    <li class="dropdown-footer p-2 text-center border-top bg-light">
                        <a href="{{ route('service-providers.notifications.index') }}" class="text-primary small fw-bold text-decoration-none">View All Notifications</a>
                    </li>
                </ul>
            </li>

            {{-- Profile Dropdown --}}
            <li class="nav-item dropdown">
                <a href="#" data-bs-toggle="dropdown" class="nav-icon pe-md-0" id="profileDropdown" aria-expanded="false">
                    <img src="https://ui-avatars.com/api/?background=FFCCA6&color=000&name={{urlencode(auth()->user()->name)}}" class="avatar img-fluid rounded" alt="User" style="width: 35px; height: 35px;">
                </a>
                <div class="dropdown-menu dropdown-menu-end shadow border-0 mt-2" aria-labelledby="profileDropdown">
                    <a href="{{ route('profile-settings.index') }}" class="dropdown-item py-2"><i class="bi bi-person me-2"></i> Profile</a>
                    <hr class="dropdown-divider my-1">
                    <a href="#" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="dropdown-item py-2 text-danger">
                        <i class="bi bi-box-arrow-left me-2"></i> Logout
                    </a>
                </div>
            </li>
        </ul>
    </div>
</nav>

<style>
    .bg-danger-light { background-color: #ffe5e5; }
    .notification-item:hover { background-color: #f8f9fa; transition: 0.3s; }
    .notification-scroll-area::-webkit-scrollbar { width: 4px; }
    .notification-scroll-area::-webkit-scrollbar-thumb { background: #ddd; border-radius: 10px; }

    .pulse-animation {
        animation: pulse-red 2s infinite;
        border: 2px solid #fff;
    }
    @keyframes pulse-red {
        0% { box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.7); }
        70% { box-shadow: 0 0 0 8px rgba(220, 53, 69, 0); }
        100% { box-shadow: 0 0 0 0 rgba(220, 53, 69, 0); }
    }
</style>