
<aside id="sidebar" class="collapse collapse-horizontal border-end">
    <!-- Content For Sidebar -->
    <div class="h-100">
        <div class="sidebar-logo ms-2">
            <a href="{{ route('admins.dashboard') }}" class="pe-md-0">
                <div class="d-flex flex-wrap gap-2 align-items-center">
                    <img src="https://ui-avatars.com/api/?background=0D8ABC&color=FFF&name={{urlencode(auth()->user()->name)}}" class="avatar img-fluid rounded" alt="">
                    <span>{{ auth()->user()->name }}</span>
                </div>
            </a>
        </div>
        <ul class="sidebar-nav">
            <li class="sidebar-item">
                <a href="{{ route('frontend.home') }}" class="sidebar-link text-dark bg-light border-0 fw-semibold {{ request()->routeIs('frontend.home') ? 'active' : '' }}">
                    <i class="bi bi-arrow-left-circle pe-2"></i>
                    Back To Website
                </a>
            </li>
            <li class="sidebar-item">
                <a href="{{ route('admins.dashboard') }}" class="sidebar-link {{ request()->routeIs('home') ? 'active' : '' }}"
                   wire:navigate>
                    <i class="bi bi-house pe-2"></i>
                    Dashboard
                </a>
           <li class="sidebar-item">
    <a href="{{ route('admins.notifications.index') }}"
       class="sidebar-link {{ request()->routeIs('admins.notifications.index') ? 'active' : '' }}">
        <div class="d-flex align-items-center">
            <i class="bi bi-bell pe-2"></i>
            <span>Notifications</span>
            <span class="ps-2">@include('partials.notifications._normal_unread-counts',['id'=>1])</span>
        </div>
    </a>
</li>

            @if(canAccessModule('enquiry'))
            <li class="sidebar-item">
                <a href="{{ route('enquiry.index') }}" wire:navigate
                   class="sidebar-link {{ request()->routeIs('enquiry.index') ? 'active' : '' }}">
                    <i class="bi bi-grid pe-2"></i>
                    Enquiry
                </a>
            </li>
            @endif

            @if(canAccessModule('jobs'))
            <li class="sidebar-item">
                <a href="{{ route('job-posts.index') }}" wire:navigate
                   class="sidebar-link {{ request()->routeIs('job-posts.index') ? 'active' : '' }}">
                    <i class="bi bi-box-seam pe-2"></i>
                    Jobs
                </a>
            </li>
            @endif


            {{-- ✅ Auctions Progress — naya section --}}
{{-- ✅ Auctions Progress --}}
{{-- ✅ Auctions Progress --}}
@if(canAccessModule('jobs'))
<li class="sidebar-item">
    <a href="#" class="sidebar-link collapsed"
       data-bs-target="#auctionsProgress"
       data-bs-toggle="collapse">
        <i class="bi bi-graph-up-arrow pe-2"></i>
        Auctions Progress
    </a>

    <ul id="auctionsProgress" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">

        {{-- 🟡 Upcoming --}}
        <li class="sidebar-item">
            <a href="{{ route('job-posts.index') }}?status=upcoming"
               class="sidebar-link d-flex align-items-center gap-2">
                <span style="width:8px;height:8px;border-radius:50%;background:#f59e0b;"></span>
                Upcoming

                @php
                $upcoming = \App\Models\JobPost::where('auction_status','pending')->count();
                @endphp

                @if($upcoming > 0)
                    <span class="badge ms-auto" style="background:#fef3c7;color:#b45309;">
                        {{ $upcoming }}
                    </span>
                @endif
            </a>
        </li>

        {{-- 🟢 Live --}}
        <li class="sidebar-item">
            <a href="{{ route('job-posts.index') }}?status=live"
               class="sidebar-link d-flex align-items-center gap-2">
                <span style="width:8px;height:8px;border-radius:50%;background:#10b981;animation:blink 1.2s infinite;"></span>
                Live

                @php 
                $live = \App\Models\JobPost::where('auction_status','open')->count(); 
                @endphp

                @if($live > 0)
                    <span class="badge ms-auto" style="background:#dcfce7;color:#15803d;">
                        {{ $live }}
                    </span>
                @endif
            </a>
        </li>

        {{-- 🟣 Under Verification --}}
        <li class="sidebar-item">
            <a href="{{ route('job-posts.index') }}?status=under_verification"
               class="sidebar-link d-flex align-items-center gap-2">
                <span style="width:8px;height:8px;border-radius:50%;background:#8b5cf6;"></span>
                Under Verification

                @php 
                $underVerif = \App\Models\JobPost::where('auction_status','closed')
                                ->whereNull('assigned_to')
                                ->where('status','under verification') // ✅ FIX
                                ->count(); 
                @endphp

                @if($underVerif > 0)
                    <span class="badge ms-auto" style="background:#f5f3ff;color:#7c3aed;">
                        {{ $underVerif }}
                    </span>
                @endif
            </a>
        </li>

        {{-- ⚫ Closed (Hired) --}}
        <li class="sidebar-item">
            <a href="{{ route('job-posts.index') }}?status=closed"
               class="sidebar-link d-flex align-items-center gap-2">
                <span style="width:8px;height:8px;border-radius:50%;background:#6b7280;"></span>
                Closed (Hired)

                @php 
                $closed = \App\Models\JobPost::where('auction_status','closed')
                            ->whereNotNull('assigned_to')
                            ->where('status','assigned') // ✅ FIX
                            ->count(); 
                @endphp

                @if($closed > 0)
                    <span class="badge ms-auto" style="background:#f3f4f6;color:#374151;">
                        {{ $closed }}
                    </span>
                @endif
            </a>
        </li>

    </ul>
</li>
@endif
<style>
@keyframes blink {
    0%,100% { opacity:1; }
    50%      { opacity:0.3; }
}
</style>

            @if(canAccessModule('jobs'))
<li class="sidebar-item">
    <a href="{{ route('admin.auction.room') }}" wire:navigate
       class="sidebar-link {{ request()->routeIs('admin.auction.room') ? 'active' : '' }}">
        <i class="bi bi-person-check-fill pe-2"></i>
        Registration Status
    </a>
</li>
@endif

            @if(canAccessModule('admins'))
            <li class="sidebar-item">
                <a href="{{ route('admins.index') }}" wire:navigate
                   class="sidebar-link {{ request()->routeIs('admins.index') ? 'active' : '' }}">
                    <i class="bi bi-people pe-2"></i>
                    Admins
                </a>
            </li>
            @endif
             

             

@if(canAccessModule('Bids'))
<li class="sidebar-item">
    <a href="{{ route('admin.manage-bids.index') }}" wire:navigate
       class="sidebar-link {{ request()->routeIs('admin.manage-bids.index') ? 'active' : '' }}">
        <i class="bi bi-hammer pe-2"></i> Manage Bids
    </a>
</li>
@endif
            @if(canAccessModule('users'))
            <li class="sidebar-item">
                <a href="{{ route('users.index') }}" wire:navigate
                   class="sidebar-link {{ request()->routeIs('users.index') ? 'active' : '' }}">
                    <i class="bi bi-people pe-2"></i>
                    Users
                </a>
            </li>
            @endif

            @if(canAccessModule('service_providers'))
            <li class="sidebar-item">
                <a href="{{ route('serviceproviders.index') }}" wire:navigate
                   class="sidebar-link {{ request()->routeIs('serviceproviders.index') ? 'active' : '' }}">
                    <i class="bi bi-people pe-2"></i>
                    Service Providers
                </a>
            </li>
            @endif

            @if(canAccessModule('categories'))
            <li class="sidebar-item">
                <a href="{{ route('categories.index') }}" wire:navigate
                   class="sidebar-link {{ request()->routeIs('categories.index') ? 'active' : '' }}">
                    <i class="bi bi-grid pe-2"></i>
                    Categories
                </a>
            </li>
            @endif

            @if(canAccessModule('services'))
            <li class="sidebar-item">
                <a href="{{ route('services.index') }}" wire:navigate
                   class="sidebar-link {{ request()->routeIs('services.index') ? 'active' : '' }}">
                    <i class="bi bi-person-gear pe-2"></i>
                    Services
                </a>
            </li>
            @endif
            @if(canAccessModule('blogs'))
            <li class="sidebar-item">
                <a href="{{ route('blogs.index') }}" wire:navigate
                   class="sidebar-link {{ request()->routeIs('blogs.index') ? 'active' : '' }}">
                    <i class="bi bi-pencil-square pe-2"></i>
                    Blogs
                </a>
            </li>
            @endif

            @if(canAccessModule('subscription_plan'))
            <li class="sidebar-item">
                <a href="{{ route('subscription-plans.index') }}" wire:navigate
                   class="sidebar-link {{ request()->routeIs('subscription-plans.index') ? 'active' : '' }}">
                    <i class="bi bi-star pe-2"></i>
                    Subscription Plans
                </a>
            </li>
            @endif

            @if(canAccessModule('roles_permissions'))
            <li class="sidebar-item">
                <a href="{{ route('roles-permissions.index') }}" wire:navigate
                   class="sidebar-link {{ request()->routeIs('roles-permissions.index') ? 'active' : '' }}">
                    <i class="bi bi-person-lines-fill pe-2"></i>
                    Roles & Permissions
                </a>
            </li>
            @endif

            @if(canAccessModule('reports'))
            <li class="sidebar-item">
                <a href="#" class="sidebar-link collapsed" data-bs-target="#reports" data-bs-toggle="collapse"
                   aria-expanded="false"><i class="bi bi-file-earmark-bar-graph pe-2"></i>
                    Reports
                </a>
                <ul id="reports" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#reports-sidebar">
                    <li class="sidebar-item">
                        <a href="{{ route('job-accepted-declined.index') }}" wire:navigate class="sidebar-link {{ request()->routeIs('job-accepted-declined.index') ? 'active' : '' }}">Job Accepted/Declined</a>
                    </li>
                </ul>
            </li>
            @endif

            @if(canAccessModule('billing'))
            <li class="sidebar-item">
                <a href="#" class="sidebar-link collapsed" data-bs-target="#billing" data-bs-toggle="collapse"
                   aria-expanded="false"><i class="bi bi-receipt pe-2"></i>
                    Billing
                </a>
                <ul id="billing" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                    <li class="sidebar-item">
                        <a href="{{ route('billing.subscriptions.index') }}" wire:navigate class="sidebar-link {{ request()->routeIs('billing.subscriptions.index') ? 'active' : '' }}">Subscriptions</a>
                    </li>
                    <li class="sidebar-item">
                        <a href="{{ route('billing.payment-requests.index') }}" class="sidebar-link" wire:navigate>Payment Request</a>
                    </li>
                    <li class="sidebar-item">
                        <a href="{{ route('billing.payments.index') }}" class="sidebar-link" wire:navigate>Payments</a>
                    </li>
                </ul>
            </li>
            @endif

            

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

            <!--Settings-->
            @if(canAccessModule('settings'))
            <li class="sidebar-item border-top border-light">
                <a href="{{ route('settings.index') }}" wire:navigate
                   class="sidebar-link">
                    <i class="bi bi-gear pe-2"></i>
                    Settings
                </a>
            </li>
            @endif



        </ul>
    </div>
</aside>
