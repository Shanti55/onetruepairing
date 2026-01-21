<aside id="sidebar" class="js-sidebar ">
    <!-- Content For Sidebar -->
    <div class="h-100">
        <div class="sidebar-logo ms-2">
            <a href="#">OTP</a>
        </div>
        <ul class="sidebar-nav">
            <li class="sidebar-item">
                <a href="{{ route('admins.dashboard') }}" class="sidebar-link {{ request()->routeIs('home') ? 'active' : '' }}"
                   wire:navigate>
                    <i class="bi bi-house pe-2"></i>
                    Dashboard
                </a>
            </li>
            <li class="sidebar-item">
                <a href="{{ route('admins.index') }}" wire:navigate
                   class="sidebar-link {{ request()->routeIs('admins.index') ? 'active' : '' }}">
                    <i class="bi bi-people pe-2"></i>
                    Admins
                </a>
            </li>
            <li class="sidebar-item">
                <a href="{{ route('users.index') }}" wire:navigate
                   class="sidebar-link {{ request()->routeIs('users.index') ? 'active' : '' }}">
                    <i class="bi bi-people pe-2"></i>
                    Users
                </a>
            </li>
            <li class="sidebar-item">
                <a href="{{ route('serviceproviders.index') }}" wire:navigate
                   class="sidebar-link {{ request()->routeIs('serviceproviders.index') ? 'active' : '' }}">
                    <i class="bi bi-people pe-2"></i>
                    Service Providers
                </a>
            </li>

            <li class="sidebar-item">
                <a href="{{ route('categories.index') }}" wire:navigate
                   class="sidebar-link {{ request()->routeIs('categories.index') ? 'active' : '' }}">
                    <i class="bi bi-grid pe-2"></i>
                    Categories
                </a>
            </li>

            <li class="sidebar-item">
                <a href="{{ route('services.index') }}" wire:navigate
                   class="sidebar-link {{ request()->routeIs('services.index') ? 'active' : '' }}">
                    <i class="bi bi-person-gear pe-2"></i>
                    Services
                </a>
            </li>

            <li class="sidebar-item">
                <a href="{{ route('subscription-plans.index') }}" wire:navigate
                   class="sidebar-link {{ request()->routeIs('subscription-plans.index') ? 'active' : '' }}">
                    <i class="bi bi-star pe-2"></i>
                    Subscription Plans
                </a>
            </li>
            <li class="sidebar-item">
                <a href="{{ route('job-posts.index') }}" wire:navigate
                   class="sidebar-link {{ request()->routeIs('job-posts.index') ? 'active' : '' }}">
                    <i class="bi bi-box-seam pe-2"></i>
                    Jobs
                </a>
            </li>


{{--            <li class="sidebar-item">--}}
{{--                <a href="#" class="sidebar-link collapsed" data-bs-target="#posts" data-bs-toggle="collapse"--}}
{{--                   aria-expanded="false"><i class="bi bi-receipt pe-2"></i>--}}
{{--                    Sales--}}
{{--                </a>--}}
{{--                <ul id="posts" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">--}}
{{--                    <li class="sidebar-item">--}}
{{--                        <a href="" wire:navigate class="sidebar-link">All Sales</a>--}}
{{--                    </li>--}}
{{--                    <li class="sidebar-item">--}}
{{--                        <a href="" class="sidebar-link" wire:navigate>Add Sale</a>--}}
{{--                    </li>--}}

{{--                </ul>--}}
{{--            </li>--}}




        </ul>
    </div>
</aside>
