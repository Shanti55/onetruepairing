<aside id="sidebar" class="collapse collapse-horizontal border-end">
    <div class="h-100">
        <div class="sidebar-logo ms-2">
            @php
                $url = null;
                $compName = null;
                $headerData = null;
                if(auth()->check() && auth()->user()->serviceproviderprofile()->first()){
                   $headerData = auth()->user()->serviceproviderprofile()->first();
                   $url = $headerData->avatar;
                   $compName = $headerData->company_name;
                }else{
                    $compName = auth()->user()->name;
                }
                $userId = auth()->id();

                // ✅ Auction counts
                $sb_upcoming = \App\Models\JobPost::where('auction_status','live')
                    ->whereDoesntHave('bids', fn($q) => $q->where('vendor_id', $userId))
                    ->count();

                $sb_total = \App\Models\JobBid::where('vendor_id', $userId)->count();

                $sb_closed = \App\Models\JobBid::where('vendor_id', $userId)
                    ->whereHas('jobPost', fn($q) => $q->whereIn('status',['closed','assigned','completed'])
                        ->where('assigned_to','!=',$userId))
                    ->count();

                $sb_won = \App\Models\JobPost::where('assigned_to', $userId)->count();
            @endphp
            <a href="{{ route('service-providers.dashboard') }}" class="d-flex justify-content-start align-items-center">
                <img class="me-2 shadow-lg" src="{{ $url }}" height="50" width="50">
                <h6 class="mb-0">{{ $compName }}</h6>
            </a>
        </div>

        <ul class="sidebar-nav">

            {{-- Back To Website --}}
            <li class="sidebar-item">
                <a href="{{ route('frontend.home') }}" class="sidebar-link text-dark bg-light border-0 fw-semibold">
                    <i class="bi bi-arrow-left-circle pe-2"></i>Back To Website
                </a>
            </li>

            {{-- Dashboard --}}
            <li class="sidebar-item">
                <a href="{{ route('service-providers.dashboard') }}"
                   class="sidebar-link {{ request()->routeIs('service-providers.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-house pe-2"></i>Dashboard
                </a>
            </li>

            {{-- Notifications --}}
            <li class="sidebar-item">
                <a href="{{ route('service-providers.notifications.index') }}"
                   class="sidebar-link {{ request()->routeIs('service-providers.notifications.index') ? 'active' : '' }}">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-bell pe-2"></i>
                        <span>Notifications</span>
                        <span class="ps-2">@include('partials.notifications._normal_unread-counts',['id'=>1])</span>
                    </div>
                </a>
            </li>

            {{-- Jobs --}}
            <li class="sidebar-item">
                <a href="#" class="sidebar-link collapsed"
                   data-bs-target="#posts" data-bs-toggle="collapse" aria-expanded="false">
                    <i class="bi bi-briefcase pe-2"></i>Jobs
                  
                </a>
               
              <ul id="posts" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">      
                    <li class="sidebar-item {{ request()->routeIs('service-providers.my-jobs.index') ? 'active' : '' }}">
                        <a href="{{ route('service-providers.my-jobs.index') }}" class="sidebar-link">My Jobs</a>
                    </li>
                    <li class="sidebar-item {{ request()->routeIs('service-providers.my-job-posts.index') ? 'active' : '' }}">
                        <a href="{{ route('service-providers.my-job-posts.index') }}" class="sidebar-link">My Job Posts [Hire]</a>
                    </li>
                    <li class="sidebar-item {{ request()->routeIs('vendor.bids') ? 'active' : '' }}">
                        <a href="{{ route('vendor.bids') }}" class="sidebar-link">Bid Status</a>
                    </li>
                </ul>
            </li>

            {{-- ✅ Auctions Progress --}}
            <li class="sidebar-item">
                <a href="#" class="sidebar-link collapsed"
                   data-bs-target="#auctionProgress" data-bs-toggle="collapse" aria-expanded="false">
                    <i class="bi bi-graph-up-arrow pe-2"></i>Auctions Progress
                   
                </a>
                <ul id="auctionProgress" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">

                    {{-- Upcoming --}}
                    <li class="sidebar-item">
                        <a href="{{ route('service-providers.request-job-posts.index') }}"
                           class="sidebar-link d-flex align-items-center gap-2">
                            <span style="width:8px;height:8px;border-radius:50%;background:#f59e0b;flex-shrink:0;"></span>
                            Upcoming
                            @if($sb_upcoming > 0)
                                <span class="badge ms-auto" style="background:#fef3c7;color:#b45309;font-size:10px;">
                                    {{ $sb_upcoming }}
                                </span>
                            @endif
                        </a>
                    </li>

                    {{-- Total Participated --}}
                    <li class="sidebar-item">
                        <a href="{{ route('vendor.bids') }}"
                           class="sidebar-link d-flex align-items-center gap-2">
                            <span style="width:8px;height:8px;border-radius:50%;background:#8b5cf6;flex-shrink:0;"></span>
                            Total Participated
                            @if($sb_total > 0)
                                <span class="badge ms-auto" style="background:#f5f3ff;color:#7c3aed;font-size:10px;">
                                    {{ $sb_total }}
                                </span>
                            @endif
                        </a>
                    </li>

                    {{-- Closed — Not Hired --}}
                    <li class="sidebar-item">
                        <a href="{{ route('service-providers.my-jobs.index') }}"
                           class="sidebar-link d-flex align-items-center gap-2">
                            <span style="width:8px;height:8px;border-radius:50%;background:#6b7280;flex-shrink:0;"></span>
                            Closed (Not Hired)
                            @if($sb_closed > 0)
                                <span class="badge ms-auto" style="background:#f3f4f6;color:#374151;font-size:10px;">
                                    {{ $sb_closed }}
                                </span>
                            @endif
                        </a>
                    </li>

                    {{-- Won — Hired --}}
                    <li class="sidebar-item">
                        <a href="{{ route('service-providers.my-jobs.index') }}"
                           class="sidebar-link d-flex align-items-center gap-2">
                            <span style="width:8px;height:8px;border-radius:50%;background:#f59e0b;flex-shrink:0;"></span>
                            Won 🏆
                            @if($sb_won > 0)
                                <span class="badge ms-auto" style="background:#fffbeb;color:#b45309;font-size:10px;">
                                    {{ $sb_won }}
                                </span>
                            @endif
                        </a>
                    </li>

                     {{-- ✅ Manage Bids --}}
        <li class="sidebar-item">
            <a href="{{ route('vendor.bids') }}"
               class="sidebar-link d-flex align-items-center gap-2 {{ request()->routeIs('vendor.bids') ? 'active' : '' }}">
                <span style="width:8px;height:8px;border-radius:50%;background:#2563eb;flex-shrink:0;"></span>
                Manage Bids
                @if($sb_total > 0)
                    <span class="badge ms-auto" style="background:#eff6ff;color:#2563eb;font-size:10px;">
                        {{ $sb_total }}
                    </span>
                @endif
            </a>
        </li>

                </ul>
            </li>

           

            {{-- My Profile --}}
            <li class="sidebar-item">
                <a href="{{ route('profile-settings.index') }}"
                   class="sidebar-link {{ request()->routeIs('profile-settings.index') ? 'active' : '' }}">
                    <i class="bi bi-sliders pe-2"></i>My Profile
                </a>
            </li>

            {{-- Subscriptions --}}
            <li class="sidebar-item">
                <a href="{{ route('provider.subscriptions.index') }}"
                   class="sidebar-link {{ request()->routeIs('provider.subscriptions.index') ? 'active' : '' }}">
                    <i class="bi bi-bag pe-2"></i>Subscriptions
                </a>
            </li>

            {{-- Delete Account --}}
            <li class="sidebar-item">
                <a href="javascript:void(0)" id="delete-account" data-id="{{ auth()->user()->id }}"
                   class="sidebar-link">
                    <i class="bi bi-trash pe-2 text-danger"></i>Delete Account
                </a>
            </li>

        </ul>
    </div>
</aside>

@push('js')
<script type="module">
$(function () {
    document.addEventListener('click', function (e) {
        if (e.target.matches('#delete-account')) {
            e.preventDefault();
            let id = e.target.getAttribute('data-id');
            $.easyDelete({
                url: route('account.delete', {user: id}),
                confirmationMessage: 'Do you really want to delete account ?',
                confirmationButtonText: 'Yes, want to delete!',
                onComplete: () => {
                    window.location.href = route('frontend.home');
                }
            });
        }
    });
});
</script>
@endpush