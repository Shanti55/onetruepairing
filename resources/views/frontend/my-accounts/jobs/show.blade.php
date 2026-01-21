@extends('frontend.layouts.app')

@section('title', 'My Jobs | CtrlF')

@section('content')

    <section id="job-show" class="job-show section light-background" style="min-height: 30vh!important;padding: 120px 0 20px 0!important;">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-12 justify-content-between align-items-center">

                    <div class="card border-0 shadow rounded-0">
                        <!--Personal Information-->
                        <div class="card-header bg-white px-4">
                            <small><a class="text-secondary" href="{{ route('frontend.home') }}">Home</a> <i class="bi bi-chevron-right"></i> <a class="text-secondary" href="{{ route('users.profile.index') }}">My Account</a> <i class="bi bi-chevron-right"></i>  <a class="text-secondary" href="{{ route('users.jobs.index') }}">My Jobs</a> <i class="bi bi-chevron-right"></i> #JB-{{ $job->id }}</small>
                        </div>
                        <div class="card-body px-4">
                            @include('partials.job-posts._job-card')
                            @include('frontend.my-accounts.jobs._partials._rate_review_modal')
                        </div>
                    </div>

                    <!--Time Line-->
{{--                    <div class="card border-0 shadow rounded-0 mt-3">--}}
{{--                        <div class="card-body px-4">--}}
{{--                            <div class="gy-2 my-3">--}}
{{--                                <!--Timeline-->--}}
{{--                                <div class="row">--}}
{{--                                    <div class="col-lg-12">--}}
{{--                                        <div class="timeline-steps aos-init aos-animate" data-aos="fade-up">--}}
{{--                                            <div class="timeline-step">--}}
{{--                                                <div class="timeline-content" data-toggle="popover" data-trigger="hover" data-placement="top" title="" data-content="And here's some amazing content. It's very engaging. Right?" data-original-title="2003">--}}
{{--                                                    <div class="inner-circle"></div>--}}
{{--                                                    <p class="h6 mt-3 mb-1">{{ $job->created_at->format('d/m/Y') }}</p>--}}
{{--                                                    <p class="h6 text-muted mb-0 mb-lg-0">Job Posted</p>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                            <div class="timeline-step">--}}
{{--                                                <div class="timeline-content" data-toggle="popover" data-trigger="hover" data-placement="top" title="" data-content="And here's some amazing content. It's very engaging. Right?" data-original-title="2004">--}}
{{--                                                    <div class="inner-circle"></div>--}}
{{--                                                    <p class="h6 mt-3 mb-1">17/10/2024</p>--}}
{{--                                                    <p class="h6 text-muted mb-0 mb-lg-0">Verified</p>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                            <div class="timeline-step">--}}
{{--                                                <div class="timeline-content" data-toggle="popover" data-trigger="hover" data-placement="top" title="" data-content="And here's some amazing content. It's very engaging. Right?" data-original-title="2005">--}}
{{--                                                    <div class="inner-circle"></div>--}}
{{--                                                    <p class="h6 mt-3 mb-1">18/10/2024</p>--}}
{{--                                                    <p class="h6 text-muted mb-0 mb-lg-0">Accepted</p>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                            <div class="timeline-step">--}}
{{--                                                <div class="timeline-content" data-toggle="popover" data-trigger="hover" data-placement="top" title="" data-content="And here's some amazing content. It's very engaging. Right?" data-original-title="2010">--}}
{{--                                                    <div class="inner-circle"></div>--}}
{{--                                                    <p class="h6 mt-3 mb-1">19/10/2024</p>--}}
{{--                                                    <p class="h6 text-muted mb-0 mb-lg-0">In Progress</p>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                            <div class="timeline-step mb-0">--}}
{{--                                                <div class="timeline-content" data-toggle="popover" data-trigger="hover" data-placement="top" title="" data-content="And here's some amazing content. It's very engaging. Right?" data-original-title="2020">--}}
{{--                                                    <div class="inner-circle"></div>--}}
{{--                                                    <p class="h6 mt-3 mb-1">20/10/2023</p>--}}
{{--                                                    <p class="h6 text-muted mb-0 mb-lg-0">Job Completed</p>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}

{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}

                    <!--Chat-->
                    <div id="chat-section" class="card border-0 shadow rounded-0 mt-3">
                        <div class="card-body px-4">
                            <div class="gy-2 my-3">
                                <!--Chat Box-->
                                <div class="row">
                                    <div class="col-lg-12">
                                        @include('frontend.partials._chat-box')
                                    </div>
                                </div>
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
