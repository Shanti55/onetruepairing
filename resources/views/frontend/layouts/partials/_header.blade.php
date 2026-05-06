<header id="header" class="header d-flex align-items-center fixed-top border-bottom py-2">
    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

        <a href="{{ route('frontend.home') }}" class="logo d-flex align-items-center d-none d-md-flex">
            <!-- Uncomment the line below if you also wish to use an image logo -->
            <img src="{{ $setting->logo }}" alt="ctrlf"  loading="lazy">
            <h1 class="sitename">CtrlF</h1>
        </a>

        <nav id="navmenu" class="navmenu">
            <ul>
                <li><a href="{{ route('frontend.home') }}" class="{{ request()->routeIs('frontend.home') ? 'active' : '' }}">Home</a></li>
                <li><a href="{{ route('frontend.about-us') }}" class="{{ request()->routeIs('frontend.about-us') ? 'active' : '' }}">About Us</a></li>
                @if(!auth()->check() || (auth()->check() && !auth()->user()->isUser()))
                <li class="dropdown {{ request()->routeIs('frontend.business-listings.createOrUpdate') ? 'active' : '' }}"><a href="javascript:void(0)"><span>Business Listing</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                    <ul>
                        <li><a href="{{ auth()->check() && auth()->user() && auth()->user()->serviceproviderprofile()->first() ? route('profile-settings.index') : route('frontend.business-listings.createOrUpdate') }}">{{ auth()->check() && auth()->user() && auth()->user()->serviceproviderprofile()->first() ? 'Edit Your Listing' : 'Add Listing' }}</a></li>
                        <li><a href="{{ route('frontend.pricing.index') }}">Pricing</a></li>
                        <li><a href="{{ route('frontend.benefits-of-listings') }}">Benefits of Listing</a></li>
                    </ul>
                </li>
                @endif
                <li><a href="{{ route('frontend.browse-listings.index') }}" class="{{ request()->routeIs('frontend.browse-listings.index') ? 'active' : '' }}">Listing</a></li>

                <li><a href="{{ route('frontend.job-posts.createOrUpdate') }}" class="{{ request()->routeIs('frontend.job-posts.createOrUpdate') ? 'active' : '' }}">Post a Job</a></li>
                <li><a href="{{ route('frontend.jobs.index') }}" class="{{ request()->routeIs('frontend.jobs.index') ? 'active' : '' }}">Project Auctions</a></li>
                <li><a href="{{ route('frontend.blogs') }}" class="{{ request()->routeIs('frontend.blogs') ? 'active' : '' }}">Blogs</a></li>
                <li><a href="{{ route('frontend.contact') }}" class="{{ request()->routeIs('frontend.contact') ? 'active' : '' }}">Contact Us</a></li>
                @if(auth()->user())
                    <li class="dropdown">
                        <a href="javascript:void(0)">
                            <div>
                                <span class="text-dark fw-semibold">{{ auth()->user()->name }}</span>
                                <img  loading="lazy" src="https://ui-avatars.com/api/?background=FFCCA6&color=000&name={{urlencode(auth()->user()->name)}}" class="avatar m-1 img-fluid rounded" alt="">
                            </div>
                            <i class="bi bi-chevron-down toggle-dropdown"></i>
                        </a>
                        <ul>
                            @if(auth()->check() && auth()->user()->isServiceProvider())
                                @php
                                $verificationStatus = auth()->user()->status->value == 'pending' ? 'Not Verified' : auth()->user()->status;
                                $verificationColor = auth()->user()->status->value == 'verified' ? 'soft-success' : 'bg-warning';
                                @endphp
                                <li><a href="{{ route('service-providers.dashboard') }}">My Account <span class="badge {{ $verificationColor }} ms-1" type="button">{{$verificationStatus}}</span></a></li>
                                <li><a href="{{ route('service-providers.my-jobs.index') }}">Jobs</a></li>
                                <li><a href="{{ route('service-providers.notifications.index') }}">Notifications <span class="position-relative">@include('partials.notifications._unread-counts',['id'=>2])</span></a></li>
                                <li class="border-top ">
                                    <a href="javascript:void(0)" onclick="event.preventDefault();$('#logout-form').submit();">Logout</a>
                                    <form method="POST" id="logout-form" action="{{ route('logout') }}" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            @elseif(auth()->check() && auth()->user()->isAdmin())
                                <li><a href="{{ route('admins.dashboard') }}">Go to Dashboard</a></li>
                                <li class="border-top ">
                                    <a href="javascript:void(0)" onclick="event.preventDefault();$('#logout-form').submit();">Logout</a>
                                    <form method="POST" id="logout-form" action="{{ route('logout') }}" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            @else
                                @php
                                    $verificationStatus = isset(auth()->user()->email_verified_at) ? 'Verified' : 'Email Not Verified';
                                    $verificationColor = isset(auth()->user()->email_verified_at) ? 'soft-success' : 'bg-warning';
                                @endphp
                                <li class="d-flex flex-column">
                                    <a href="{{ route('users.profile.index') }}">My Account <span class="badge {{ $verificationColor }} ms-1" type="button">{{$verificationStatus}}</span></a>
                                </li>
                                <li><a href="{{ route('users.jobs.index') }}">Jobs</a></li>
                                <li><a href="{{ route('users.notifications.index') }}">Notifications <span class="position-relative">@include('partials.notifications._unread-counts',['id'=>2])</span></a></li>
                                <li><a href="javascript:void(0)" data-id="{{ auth()->user()->id }}" id="becomeServiceProvider">Become Service Provider</a></li>
                                <li class="border-top ">
                                    <a href="javascript:void(0)" onclick="event.preventDefault();$('#logout-form').submit();">Logout</a>
                                    <form method="POST" id="logout-form" action="{{ route('logout') }}" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            @endif
                        </ul>
                    </li>
                    <button type="button" class="btn btn-sm btn-light border-0 position-relative px-4 px-md-0" onclick="window.location='{{ route('users.notifications.index') }}'" style="background: none!important;">
                        <i class="bi bi-bell" style="font-size: 16px!important;"></i>
                        @include('partials.notifications._unread-counts',['id'=>1])
                    </button>

                @else
                    <li><a href="{{ route('otp-login') }}" class="btn btn-sm fw-semibold border-0"><i class="bi bi-person-circle me-2" style="font-size: 20px!important;"></i>Login / Signup</a></li>
                @endif
            </ul>

            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>

        <a href="{{ route('frontend.home') }}" class="logo d-flex align-items-center d-flex d-md-none ">
            <!-- Uncomment the line below if you also wish to use an image logo -->
            <img  loading="lazy" src="{{ $setting->logo }}" alt="ctrlf">
            {{--            <h1 class="sitename">CtrlF</h1>--}}
        </a>


        <div class="d-flex d-md-none">
            @if(auth()->user())
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="javascript:void(0)" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <div>
                            <img  loading="lazy" src="https://ui-avatars.com/api/?background=FFCCA6&color=000&name={{ urlencode(auth()->user()->name) }}" class="avatar m-1 img-fluid rounded" alt="">
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        @if(auth()->check() && auth()->user()->isServiceProvider())
                            @php
                                $verificationStatus = auth()->user()->status->value == 'pending' ? 'Not Verified' : auth()->user()->status;
                                $verificationColor = auth()->user()->status->value == 'verified' ? 'soft-success' : 'bg-warning';
                            @endphp
                            <li><a class="dropdown-item" href="{{ route('service-providers.dashboard') }}">My Account <span class="badge {{ $verificationColor }} ms-1">{{$verificationStatus}}</span></a></li>
                            <li><a class="dropdown-item" href="{{ route('service-providers.my-jobs.index') }}">Jobs</a></li>
                            <li><a class="dropdown-item" href="{{ route('service-providers.notifications.index') }}">Notifications <span class="position-relative">@include('partials.notifications._unread-counts',['id'=>2])</span></a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                                <form method="POST" id="logout-form" action="{{ route('logout') }}" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        @elseif(auth()->check() && auth()->user()->isAdmin())
                            <li><a class="dropdown-item" href="{{ route('admins.dashboard') }}">Go to Dashboard</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                                <form method="POST" id="logout-form" action="{{ route('logout') }}" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        @else
                            @php
                                $verificationStatus = isset(auth()->user()->email_verified_at) ? 'Verified' : 'Email Not Verified';
                                $verificationColor = isset(auth()->user()->email_verified_at) ? 'soft-success' : 'bg-warning';
                            @endphp
                            <li><a class="dropdown-item" href="{{ route('users.profile.index') }}">My Account <span class="badge {{ $verificationColor }} ms-1">{{$verificationStatus}}</span></a></li>
                            <li><a class="dropdown-item" href="{{ route('users.jobs.index') }}">Jobs</a></li>
                            <li><a class="dropdown-item" href="{{ route('users.notifications.index') }}">Notifications <span class="position-relative">@include('partials.notifications._unread-counts',['id'=>2])</span></a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                                <form method="POST" id="logout-form" action="{{ route('logout') }}" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        @endif
                    </ul>
                </li>
            @else
                <a href="{{ route('otp-login') }}" class="btn btn-sm fw-semibold border-0 text-primary"><i class="bi bi-person-circle me-2" style="font-size: 20px!important;"></i></a>
            @endif
        </div>



    </div>
</header>
