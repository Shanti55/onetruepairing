<div class="gy-2 my-3">
    <div class="row">
        <div class="col-lg-4">
            <div class="d-flex flex-column">
                <h5 class="fw-bold">Job Details</h5>
                <h6 class="fw-semibold text-secondary"><i class="fa-solid fa-briefcase me-1"></i>{{ $job->title }}</h6>
                <h6 class="text-secondary"><i class="fa-solid fa-location-dot me-1"></i>{{ $job->location }}</h6>
                <h6 class="text-secondary"> <i class="fa-solid fa-clock me-1"></i>{{ $job->duration_value }} {{ $job->duration_type }}</h6>
                <h6 class="text-secondary"> <i class="fa-solid fa-indian-rupee-sign me-1"></i>{{ $job->cost }}</h6>
                <h6 class="text-secondary">
                    @php
                        $categories = $job->categories()->count() > 0 ? $job->categories()->get() : null;
                    @endphp
                    @if(isset($categories))
                        <div class="me-1">
                            @foreach($categories as $category)
                                <span class="badge soft-secondary align-middle"><i class="bi bi-tags text-muted me-1"></i>{{ $category->name }}</span>
                            @endforeach
                        </div>
                    @endif
                </h6>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="d-flex flex-column">
                <h5 class="fw-bold">Service Provider Details</h5>
                <h6 class="fw-semibold text-secondary"><i class="fa-regular fa-building me-1"></i>{{ isset($job->assignedTo) ? $job->assignedTo->serviceproviderprofile->company_name : 'NA' }}</h6>
                <h6 class="text-secondary"><i class="fa-solid fa-location-dot me-1"></i>{{ isset($job->assignedTo) ? $job->assignedTo->serviceproviderprofile->address : 'NA' }}</h6>
                <h6 class="text-secondary"><i class="fa-solid fa-location-dot me-1"></i>{{ isset($job->assignedTo) ? $job->assignedTo->serviceproviderprofile->city : '' }}, {{ isset($job->assignedTo) ? $job->assignedTo->serviceproviderprofile->state : '' }} {{ isset($job->assignedTo) ? $job->assignedTo->serviceproviderprofile->pin_code : '' }}</h6>
                <h6 class="text-secondary"><i class="fa-solid fa-mobile-screen-button me-1"></i>{{ isset($job->assignedTo) ? $job->assignedTo->serviceproviderprofile->contact_number.' / '.$job->assignedTo->serviceproviderprofile->alternate_contact_number : '' }}</h6>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="d-flex flex-column gap-2">
                <h6 class="progress-title">{{ $job->status->value }}</h6>
                @include('partials.job-posts._job-progress-bar')
                <div class="d-flex flex-row gap-2">
                    <a href="#chat-section" class="btn btn-sm btn-outline-primary w-100"><i class="bi bi-chat-fill me-1"></i> Chat with Provider</a>
                    @if($job->status->value == 'completed')
                        <button type="button" class="btn btn-sm btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#rateReviewModal"><i class="bi bi-star-fill me-1"></i> Rate and Review Job</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-lg-6">
            <h6 class="fw-bold">Rating and Review</h6>
            <div>
                @php
                    $maxStars = 5; // Total number of stars
                    $rating =  $job->rating; // Example rating (out of 5)

                    for ($star = 1; $star <= $maxStars; $star++) {
                        // Determine the class for each star
                        $starClass = '';
                        if ($star <= floor($rating)) {
                            $starClass = 'bi-star-fill'; // Full star
                        } elseif ($star > floor($rating) && $star <= ceil($rating) && $rating % 1 !== 0) {
                            $starClass = 'bi-star-half'; // Half star
                        } else {
                            $starClass = 'bi-star'; // Empty star
                        }

                        // Output the star
                        echo '<i class="bi star ' . $starClass . ' me-2"></i>';
                    }
                @endphp
            </div>
            <p>{{ $job->review }}</p>

        </div>
    </div>
</div>
