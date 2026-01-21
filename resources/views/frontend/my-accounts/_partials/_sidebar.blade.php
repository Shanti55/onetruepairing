<aside>
    <!-- Content For Sidebar -->
    <div class="h-100">
        <div class="card border-0 shadow-sm rounded-0 mb-3">
            <div class="card-body">
                <div class="d-flex align-items-center gap-3">
                    @if(isset($profile) && !empty($profile->avatar))
                        <img  loading="lazy" src="{{ url($profile->avatar) }}" alt="Profile Avatar" class="rounded-circle object-fit-cover" width="50" height="50">
                    @else
                        <img  loading="lazy" src="{{ asset('frontend-images/profile.png') }}" alt="Placeholder Avatar" class="rounded-circle object-fit-cover" width="50" height="50">
                    @endif
                    <div>
                        <span class="m-0 small">Hello,</span>
                        <h6 class="mb-0 fw-semibold">{{ auth()->user()->name }}</h6>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-0 m-0 p-0">
            <div class="card-body m-0 p-0">
                <div class="d-flex align-items-center">
                    <div class="list-group list-group-flush w-100">
                        <a href="{{ route('users.profile.index') }}" class="list-group-item list-group-item-action p-3 border-0 {{ request()->routeIs('users.profile.index') ? 'active' : '' }}" aria-current="true">
                            <i class="bi bi-person-gear me-2"></i>Manage Profile
                        </a>
                        <a href="{{ route('users.notifications.index') }}" class="list-group-item list-group-item-action p-3 border-0 {{ request()->routeIs('users.notifications.index') ? 'active' : '' }}">
                            <i class="bi bi-bell me-2"></i>Notifications
                        </a>
                        <a href="{{ route('users.jobs.index') }}" class="list-group-item list-group-item-action p-3 border-0  {{ request()->routeIs('users.jobs.index') ? 'active' : '' }}">
                            <i class="bi bi-bag me-2"></i>My Jobs
                        </a>
                        <a href="{{ route('frontend.job-posts.createOrUpdate') }}" class="list-group-item list-group-item-action p-3 border-0  {{ request()->routeIs('frontend.job-posts.createOrUpdate') ? 'active' : '' }}">
                            <i class="bi bi-arrow-up-right-circle me-2"></i></i>Post New Job
                        </a>
                        <a href="#" class="list-group-item list-group-item-action p-3" onclick="event.preventDefault();$('#logout-form').submit();"> <i class="bi bi-power me-2"></i>Logout</a>
                        <form method="POST" id="logout-form" action="{{ route('logout') }}" class="d-none">
                            @csrf
                        </form>
                        <a href="javascript:void(0)" data-id="{{ auth()->user()->id }}" id="delete-account" class="list-group-item list-group-item-action p-3 border-0 text-muted">
                            <i class="bi bi-trash me-2"></i></i>Delete Account
                        </a>
                    </div>
                </div>
            </div>
        </div>

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
