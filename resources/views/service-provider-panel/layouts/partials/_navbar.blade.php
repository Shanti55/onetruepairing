<nav class="navbar navbar-expand py-1 px-3 shadow-sm border-bottom">
{{--    <button class="btn" id="sidebar-toggle" type="button" >--}}
{{--        <span class="navbar-toggler-icon"></span>--}}
{{--    </button>--}}
    <a href="#" data-bs-target="#sidebar" data-bs-toggle="collapse"
       class=" text-decoration-none">
        <span class="navbar-toggler-icon"></span>
    </a>
    <div class="navbar-collapse navbar">
        @if (!auth()->user()->hasVerifiedEmail())
            <div class="alert alert-warning alert-dismissible fade show mb-0" role="alert">
                <strong>Notice:</strong> Your email is not verified.
                Please <a href="{{ route('verification.notice') }}" class="alert-link">verify your email</a> to unlock full access.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <ul class="navbar-nav">

            <li class="nav-item dropdown">
                <a href="#" data-bs-toggle="dropdown" class="nav-icon pe-md-0">
                    <img src="https://ui-avatars.com/api/?background=FFCCA6&color=000&name={{urlencode(auth()->user()->name)}}" class="avatar img-fluid rounded" alt="">
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                    <a href="{{ route('profile-settings.index') }}" class="dropdown-item"><i class="bi bi-person"></i> Profile</a>
                    <a href="#" onclick="event.preventDefault();$('#logout-form').submit();" class="dropdown-item"><i class="bi bi-box-arrow-left"></i>  Logout</a>
                    <form method="POST" id="logout-form" action="{{ route('logout') }}" class="d-none">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
    </div>
</nav>
