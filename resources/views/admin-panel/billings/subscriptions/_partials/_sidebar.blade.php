<aside>
    <!-- Content For Sidebar -->
    <div class="h-100">
        <div class="card border-0 shadow-sm rounded-0 ">
            <div class="card-body">
                <div class="d-flex align-items-center gap-3">
                    @if(isset($profile) && !empty($profile->avatar))
                        <img src="{{ url($profile->avatar) }}" alt="Profile Avatar" class="rounded-circle object-fit-cover" width="50" height="50">
                    @else
                        <img src="{{ asset('frontend-images/profile.png') }}" alt="Placeholder Avatar" class="rounded-circle object-fit-cover" width="50" height="50">
                    @endif
                    <div>
                        <h6 class="mb-0 fw-semibold">{{ isset($profile) && isset($profile->company_name) ? $profile->company_name : $provider->name }}</h6>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-0 m-0 p-0 mb-3">
            <div class="card-body m-0 p-0">
                <div class="d-flex align-items-center">
                    <ul class="nav nav-tabs flex-column flex-fill" role="tablist" id="myTab">
                        <li class="nav-item rounded-0 mt-2">
                            <a href="#overviewTab" class="nav-link active border-0 rounded-0" data-bs-toggle="tab" ><i class="bi bi-person-gear me-2"></i>Overview</a>
                        </li>
                        <li class="nav-item border-0 rounded-0 mb-2">
                            <a href="#subscriptionTab" class="nav-link border-0 rounded-0" data-bs-toggle="tab" ><i class="bi bi-bag me-2"></i>Subscription</a>
                        </li>
                    </ul>

                </div>
            </div>
        </div>

    </div>
</aside>
