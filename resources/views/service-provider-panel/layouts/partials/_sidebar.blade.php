<aside id="sidebar" class="collapse collapse-horizontal border-end">
    <!-- Content For Sidebar -->
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

            @endphp
            <a href="{{ route('service-providers.dashboard') }}" class="d-flex justify-content-start align-items-center">
                <img class="me-2 shadow-lg" src="{{ $url }}" height="50" width="50">
                <h6 class="mb-0">{{ $compName }}</h6>
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
                <a href="{{ route('service-providers.dashboard') }}" class="sidebar-link {{ request()->routeIs('service-providers.dashboard') ? 'active' : '' }}"
                   wire:navigate>
                    <i class="bi bi-house pe-2"></i>
                    Dashboard
                </a>
            </li>
            <li class="sidebar-item">
                <a href="{{ route('service-providers.notifications.index') }}" wire:navigate
                   class="sidebar-link {{ request()->routeIs('service-providers.notifications.index') ? 'active' : '' }}">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-bell pe-2"></i>
                        <span>Notifications</span>
                        <span class="ps-2">@include('partials.notifications._normal_unread-counts',['id'=>1])</span>
                    </div>

                </a>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link collapsed" data-bs-target="#posts" data-bs-toggle="collapse"
                   aria-expanded="false"><i class="bi bi-briefcase pe-2"></i>
                    Jobs
                </a>
                <ul id="posts" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                    <li class="sidebar-item {{ request()->routeIs('service-providers.job-posts.index') ? 'active' : '' }}">
                        <a href="{{ route('service-providers.request-job-posts.index') }}" wire:navigate class="sidebar-link">New Request</a>
                    </li>
                    <li class="sidebar-item {{ request()->routeIs('service-providers.my-jobs.index') ? 'active' : '' }}">
                        <a href="{{ route('service-providers.my-jobs.index') }}" class="sidebar-link" wire:navigate>My Jobs</a>
                    </li>
                    <li class="sidebar-item {{ request()->routeIs('service-providers.my-job-posts.index') ? 'active' : '' }}">
                        <a href="{{ route('service-providers.my-job-posts.index') }}" class="sidebar-link" wire:navigate>My Job Posts [ Hire ]</a>
                    </li>
                </ul>
            </li>
            <li class="sidebar-item">
                <a href="{{ route('profile-settings.index') }}" wire:navigate
                   class="sidebar-link {{ request()->routeIs('profile-settings.index') ? 'active' : '' }}">
                    <i class="bi bi-sliders pe-2"></i>
                    My Profile
                </a>
            </li>
            <li class="sidebar-item">
                <a href="{{ route('provider.subscriptions.index') }}" wire:navigate
                   class="sidebar-link {{ request()->routeIs('provider.subscriptions.index') ? 'active' : '' }}">
                    <i class="bi bi-bag pe-2"></i>
                    Subscriptions
                </a>
            </li>
            <li class="sidebar-item">
                <a href="javascript:void(0)" id="delete-account" data-id="{{ auth()->user()->id }}"
                   class="sidebar-link">
                    <i class="bi bi-trash pe-2 text-danger"></i>
                    Delete Account
                </a>
            </li>
        </ul>
{{--        <div class="d-flex flex-column justify-content-center mt-3 mx-3 text-center">--}}
{{--            <div class="progress" role="progressbar" aria-label="Animated striped example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">--}}
{{--                <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning" style="width: 75%"></div>--}}
{{--            </div>--}}
{{--            <small class="text-white mt-1">Profile Completed</small>--}}
{{--        </div>--}}


    </div>
</aside>

@push('js')
    <script type="module">
        $(function () {
            document.addEventListener('click', function (e) {
                if (e.target.matches('#delete-account')) {
                    e.preventDefault(); // Prevent default anchor behavior
                    let id = e.target.getAttribute('data-id'); // Get user ID
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
