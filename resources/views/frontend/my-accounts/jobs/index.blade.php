@extends('frontend.layouts.app')

@section('title', 'My Jobs | CtrlF')

@section('content')

    <section id="profile" class="hero section light-background">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-3">
                   @include('frontend.my-accounts._partials._sidebar')
                </div>
                <div class="col-lg-9 justify-content-between align-items-center">
                    <div class="card border-0 shadow rounded-0">
                        <!--Personal Information-->
                        <div class="card-header bg-white mt-2 ">
                            <div class="d-flex justify-content-between center mb-2">
                                <h4 class="mx-1"><i class="bi bi-file-earmark-text"></i> My Jobs</h4>
                                @if(request()->has('filter'))
                                    <a href="{{ route('users.jobs.index') }}" class="btn btn-sm pt-0 text-secondary border-0"><i class="bi bi-funnel"></i> Clear Filters</a>
                                @endif
                            </div>
                            <div class="d-flex flex-wrap">
                                <a href="{{ route('users.jobs.index',['filter'=>'open']) }}" class="btn btn-sm border-0 bg-white rounded-0 {{ request()->has('filter') && request('filter') == 'open' ? 'fw-bold' : '' }}"><span class="badge bg-primary">{{ $counts['open'] }}</span> Open</a>
                                <a href="{{ route('users.jobs.index',['filter'=>'under verification']) }}" class="btn btn-sm soft-warning border-0 bg-white border-start rounded-0 {{ request()->has('filter') && request('filter') == 'under verification' ? 'fw-bold' : '' }}"><span class="badge bg-warning">{{ $counts['under_verification'] }}</span> Under Verification</a>
                                <a href="{{ route('users.jobs.index',['filter'=>'verified']) }}" class="btn btn-sm soft-success border-0 bg-white border-start rounded-0 {{ request()->has('filter') && request('filter') == 'verified' ? 'fw-bold' : '' }}"><span class="badge bg-success">{{ $counts['verified'] }}</span> Verified</a>
                                <a href="{{ route('users.jobs.index',['filter'=>'assigned']) }}" class="btn btn-sm soft-info border-0 bg-white border-start rounded-0 {{ request()->has('filter') && request('filter') == 'assigned' ? 'fw-bold' : '' }}"><span class="badge bg-info">{{ $counts['assigned'] }}</span> Assigned</a>
                                <a href="{{ route('users.jobs.index',['filter'=>'not started']) }}" class="btn btn-sm soft-light border-0 bg-white border-start rounded-0 {{ request()->has('filter') && request('filter') == 'not started' ? 'fw-bold' : '' }}"><span class="badge bg-secondary">{{ $counts['not_started'] }}</span> Not Started</a>
                                <a href="{{ route('users.jobs.index',['filter'=>'in progress']) }}" class="btn btn-sm soft-primary border-0 bg-white border-start rounded-0 {{ request()->has('filter') && request('filter') == 'in progress' ? 'fw-bold' : '' }}"><span class="badge bg-primary">{{ $counts['in_progress'] }}</span> In Progress</a>
                                <a href="{{ route('users.jobs.index',['filter'=>'on hold']) }}" class="btn btn-sm soft-danger border-0 bg-white border-start rounded-0 {{ request()->has('filter') && request('filter') == 'on hold' ? 'fw-bold' : '' }}"><span class="badge bg-danger">{{ $counts['on_hold'] }}</span> On Hold</a>
                                <a href="{{ route('users.jobs.index',['filter'=>'completed']) }}" class="btn btn-sm soft-success border-0 bg-white border-start rounded-0 {{ request()->has('filter') && request('filter') == 'completed' ? 'fw-bold' : '' }}"><span class="badge bg-success">{{ $counts['completed'] }}</span> Completed</a>
                            </div>
                        </div>
                        <div class="card-body bg-light" style="height: 500px;overflow-y: scroll;">
                            <div class="gy-2 my-3">
                                @foreach($jobs as $job)
                                    <div class="card border-end-0 border-top-0 border-bottom-0 border-accent border-start border-4 shadow-sm mb-3">
                                            <div class="card-body ">
                                                @php
                                                    $categories = $job->categories()->count() > 0 ? $job->categories()->get() : null;
                                                @endphp
                                                <div class="row m-0 p-0">
                                                    <div class="col-lg-8 border-end">
                                                        <a href="{{ route('users.jobs.show',['job'=>$job]) }}" target="_blank">
                                                            <div class="d-flex flex-column gap-2">
                                                                <div>
                                                                    <span class="badge rounded-pill text-bg-primary">#JB-{{ $job->id }}</span>
                                                                </div>
                                                                <h6 class="">{{ $job->title ?? 'NA'}}</h6>
                                                                <div class="d-flex flex-wrap p-0">
                                                                    @if(isset($categories))
                                                                        <div class="me-1">
                                                                            @foreach($categories as $category)
                                                                                <span class="badge soft-secondary align-middle "><i class="bi bi-tags text-muted me-1"></i>{{ $category->name }}</span>
                                                                            @endforeach
                                                                        </div>
                                                                    @endif
                                                                    @if(isset($job->location))
                                                                        <div class="me-1">
                                                                            <span class="badge soft-secondary align-middle"><i class="bi bi-geo-alt text-muted me-1"></i>{{ $job->location }}</span>
                                                                        </div>
                                                                    @endif
                                                                    @if(isset($job->cost) && $job->cost > 0)
                                                                        <div class="me-1">
                                                                            <span class="badge soft-secondary align-middle"><i class="bi bi-currency-rupee text-muted me-1"></i>{{ $job->cost }}</span>
                                                                        </div>
                                                                    @endif
                                                                    @if(isset($job->duration_type) && isset($job->duration_value))
                                                                        <div class="ms-1">
                                                                            <span class="badge soft-secondary align-middle"><i class="bi bi-clock-history me-1"></i>{{ $job->duration_value }} / {{ ucfirst($job->duration_type) }}</span>
                                                                        </div>
                                                                    @endif
                                                                    @if(isset($job->description))
{{--                                                                        <div class="ms-1">--}}
{{--                                                                            <span class="badge soft-warning align-middle"  style="cursor: pointer"  data-bs-toggle="collapse" data-bs-target="#collapseExample_{{ $job->id }}"><i class="bi bi-info-circle me-1"></i>More Details</span>--}}
{{--                                                                        </div>--}}
                                                                    @endif
                                                                </div>
                                                                <div class="d-flex flex-column">
                                                                    <h6 class="mt-2 small"><span class="text-secondary">Provider - </span> {{ isset($job->assignedTo) ? $job->assignedTo->serviceproviderprofile->company_name : 'Not Assigned' }}</h6>
                                                                    <div x-data="{ maxStars:5,rating:{{ isset($job->rating) ? $job->rating : 0 }} }">
                                                                        <template x-for="star in maxStars" :key="star">
                                                                            <i class="bi star"
                                                                               :class="{
                                                                                'bi-star-fill': star <= Math.floor(rating),
                                                                                'bi-star-half': star > Math.floor(rating) && star <= Math.ceil(rating) && rating % 1 !== 0,
                                                                                'bi-star': star > Math.ceil(rating)
                                                                              }"
                                                                            </i>
                                                                        </template>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="d-flex flex-column">
                                                            <div>
                                                                <h6 class="progress-title">{{ $job->status->value }}</h6>
                                                                @include('partials.job-posts._job-progress-bar')
                                                                @if($job->status->value == 'completed')
                                                                    <a href="{{ route('users.jobs.show',['job'=>$job]) }}" class="btn btn-sm btn-outline-primary w-100"><i class="bi bi-star-fill me-1"></i> Rate and Review Job</a>
                                                                @elseif(isset($job->assigned_to))
                                                                    <a href="{{ route('users.jobs.show',['job'=>$job]) }}" class="btn btn-sm btn-outline-primary w-100"><i class="bi bi-chat-fill me-1"></i> Chat with Provider</a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @if(isset($job->description))
                                                        <div class="collapse" id="collapseExample_{{ $job->id }}">
                                                            <div class="card card-body border-0 mt-1 shadow-sm bg-light">
                                                                <small class="text-muted">{{ $job->description }}.</small>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section><!-- /Profile Section -->

@endsection

@push('js')
    <script type="module">
        $(function () {

        });
    </script>
@endpush
