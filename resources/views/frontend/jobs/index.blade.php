@extends('frontend.layouts.app')

@section('title', 'Jobs | CtrlF')

@section('content')
    <div x-data="jobListings">
        <div class="container-fluid p-0 m-0">
            <main class="main">


                <!-- Bread Crumb -->

                <!-- Details Section -->
                <section id="details" class="details section bg-light">

                    <!-- Section Title -->
                    <div class="container section-title" data-aos="fade-up">
                        <div class="d-flex flex-sm-row flex-column justify-content-between align-items-center">
                            <div>
                                <h2>Browse</h2>
                                <div><span></span> <span class="description-title">Jobs</span></div>
                            </div>
                            @if(auth()->check() && auth()->user()->isUser())
                            <div>
                                <a href="{{ route('users.jobs.index') }}" class="btn text-decoration-none border-0">
                                    <h5 class="text-common-blue fw-bold"><i class="bi bi-arrow-right-circle"></i> View My Job</h5>
                                </a>
                            </div>
                            @endif
                        </div>
                    </div><!-- End Section Title -->
                    <div class="container">
                        <div class="row gy-4">
                            <div class="col-lg-4">
                                <div class="card border-0 shadow">
                                    <div class="card-body p-3 p-md-5">
                                        <div class="d-flex justify-content-end">
                                            <button class="btn btn-sm btn-light" @click.prevent="window.location.reload()"><i class="bi bi-trash me-1"></i>Clear Filters</button>
                                            {{--                                            <button class="btn btn-sm btn-primary"><i class="bi bi-funnel me-1"></i>Apply Filters</button>--}}
                                        </div>
                                        <hr>
                                        <div class="form-group mb-3">
                                            <label for="search" class="form-label"><h6 class="fw-bold mb-0">Find a Job</h6></label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bi bi-search text-secondary"></i></span>
                                                <input type="text" class="form-control" id="search" name="search"
                                                       placeholder="Search Keywords"
                                                       value="" x-model="filters.search">
                                                <div class="invalid-feedback">Invalid feedback</div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="form-group mb-3">
                                            <label for="search_by_location" class="form-label"><h6 class="fw-bold mb-0">Location</h6></label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bi bi-geo-alt text-secondary"></i></span>
                                                <input type="text" class="form-control" id="search_by_location" name="search_by_location"
                                                       placeholder="Enter Location"
                                                       value="" x-model="filters.search_by_location">
                                                <div class="invalid-feedback">Invalid feedback</div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="form-group mb-3" style="height: 200px!important;overflow-x: hidden;overflow-y: scroll">
                                            <label for="search_by_location" class="form-label"><h6 class="fw-bold mb-0">Filter By Category</h6></label>
                                            @foreach(\App\Models\Category::all() as $category)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                           x-on:click="filters.categories.includes({{ $category->id }})
                                                            ? filters.categories = filters.categories.filter(id => id !== {{ $category->id }})
                                                            : filters.categories.push({{ $category->id }})">
                                                    <label class="form-check-label" for="category-{{ $category->id }}">
                                                        <h6 class="text-secondary">{{ $category->name }}</h6>
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                        <hr>
                                        <div class="d-flex justify-content-end">
                                            <button class="btn btn-sm btn-light"><i class="bi bi-trash me-1"></i>Clear Filters</button>
{{--                                            <button class="btn btn-sm btn-primary"><i class="bi bi-funnel me-1"></i>Apply Filters</button>--}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <!--Skeleton-->
                                <template x-if="loading">
                                    <template x-for="i in 4">
                                        <div class="card border-end-0 border-top-0 border-bottom-0 shadow is-loading mb-3">
                                            <div class="card-body p-4 d-flex flex-column">
                                                <div>
                                                    <h4 class="w-50"></h4>
                                                    <h6 class="w-25"></h6>
                                                    <div class="d-flex flex-row m-0 p-0">
                                                        <h6 class="w-25 me-1"></h6>
                                                        <h6 class="w-25 me-1"></h6>
                                                        <h6 class="w-25 me-1"></h6>
                                                    </div>
                                            </div>
                                        </div>
                                        </div>
                                    </template>
                                </template>
                                <template x-if="!loading && jobs.length > 0">
                                    <template x-for="(job, index) in jobs" :key="job.id">
                                        <div class="card border-end-0 border-top-0 border-bottom-0 border-accent border-start border-4 shadow mb-3"
                                         :id="'job_'+job.id" x-intersect="if(index+1 == jobs.length) fetchMore()">
                                            <div class="card-body p-4 d-flex flex-column">
                                                <div>
                                                    <h4 class="fw-bold mb-2" x-text="job.title"></h4>
                                                    <template x-if="job.posted_by && job.posted_by.serviceproviderprofile">
                                                        <h6 class="mb-2 p-0 text-secondary" x-text="job.posted_by.serviceproviderprofile.company_name"></h6>
                                                    </template>
{{--                                                    <h6 class="mb-2 p-0 text-secondary" x-text="job.posted_by.name"></h6>--}}
                                                    <div class="d-flex flex-wrap m-0 p-0">
                                                            <template x-if="job.categories.length > 0">
                                                                <div class="me-1">
                                                                    <template x-for="(category) in job.categories" :key="category.id">
                                                                        <span class="badge soft-secondary align-middle"><i class="bi bi-tags text-muted me-1"></i><span x-text="category.name"></span></span>
                                                                    </template>
                                                                </div>
                                                            </template>

                                                            <template x-if="job.location">
                                                                <div class="me-1">
                                                                    <span class="badge soft-secondary align-middle"><i class="bi bi-geo-alt text-muted me-1"></i><span x-text="job.location"></span></span>
                                                                </div>
                                                            </template>
                                                            <template x-if="job.cost">
                                                                <div class="me-1">
                                                                    <span class="badge soft-secondary align-middle"><i class="bi bi-currency-rupee text-muted me-1"></i><span x-text="job.cost"></span></span>
                                                                </div>
                                                            </template>
                                                            <template x-if="job.duration_type">
                                                                <div class="ms-1">
                                                                    <span class="badge soft-secondary align-middle"><i class="bi bi-clock-history me-1"></i><span x-text="job.duration_value"></span> / <span x-text="job.duration_type"></span></span>
                                                                </div>
                                                            </template>
                                                            <template x-if="job.description">
                                                                <div class="ms-1">
                                                                    <span class="badge soft-warning align-middle"  style="cursor: pointer"  data-bs-toggle="collapse" :data-bs-target="'#collapseExample_'+job.id"><i class="bi bi-info-circle me-1"></i>More Details</span>
                                                                </div>
                                                            </template>
                                                    </div>
                                                    <template x-if="job.description">
                                                        <div class="collapse" :id="'collapseExample_'+job.id">
                                                            <div class="card card-body border-0 mt-1 shadow-sm bg-light">
                                                                <small class="text-muted" x-text="job.description"></small>
                                                            </div>
                                                        </div>
                                                    </template>
                                                </div>
                                                @guest()
                                                    <div>
                                                        <hr>
                                                        <a href="{{ route('login') }}" class="btn btn-sm btn-primary me-2" title="Get This Job"><i class="bi bi-check-circle"></i> Get This Job</a>
                                                    </div>
                                                @endguest
                                                @if(auth()->check() && auth()->user()->isServiceProvider() && auth()->user()->activeSubscriptionPlan)
                                                    <template x-if="job.status == 'assigned'">
                                                        <div>
                                                            <hr>
                                                            <div class="alert alert-warning p-2 mb-0">
                                                                <i class="bi bi-exclamation-triangle me-2"></i>
                                                                This job is already assigned. To be able to accept this job ,
                                                                please contact our calling team <a href="tel:9971300993">9971300993</a> or whatsapp us at 9811666437”
                                                            </div>
                                                        </div>
                                                    </template>
                                                    <template x-if="job.status == 'verified' && job.posted_by != @js(auth()->id())">
                                                    <div>
                                                        <hr>
                                                        <a href="javascript:void(0)" class="btn btn-sm btn-primary me-2" title="Accept" @click.prevent="jobAction(job.id,'accept')"><i class="bi bi-check-circle"></i> Accept</a>
                                                        <a href="javascript:void(0)" class="btn btn-sm btn-warning text-white" title="Decline" @click.prevent="jobAction(job.id,'decline')"><i class="bi bi-x-circle"></i> Decline</a>
                                                    </div>
                                                    </template>
                                                @endif
                                            </div>
                                        </div>
                                    </template>
                                </template>
                                <template x-if="!loading && jobs.length === 0">
                                    <div class="d-flex flex-column justify-content-center align-items-center">
                                        <img src="{{ asset('frontend-images/empty-box.png') }}" width="25%"  loading="lazy">
                                        <h1 class="mt-3">Sorry !! No Jobs found</h1>
                                    </div>
                                </template>
                                <template x-if="loading1">
                                    <template x-for="i in 2">
                                        <div class="card border-end-0 border-top-0 border-bottom-0 shadow is-loading mb-3">
                                            <div class="card-body p-4 d-flex flex-column">
                                                <div>
                                                    <h4 class="w-50"></h4>
                                                    <h6 class="w-25"></h6>
                                                    <div class="d-flex flex-row m-0 p-0">
                                                        <h6 class="w-25 me-1"></h6>
                                                        <h6 class="w-25 me-1"></h6>
                                                        <h6 class="w-25 me-1"></h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </template>


                            </div>

                        </div>
                    </div>
                </section>

            </main>
        </div>
    </div>

@endsection

@push('js')
        <script>
            jobListings = () => {
            return {
                skip: 0,
                jobs: [],
                filters: {categories: []},
                loading: false,
                loading1: false,
                async init() {
                    await this.fetchData();
                    this.$watch('filters', async (value) => {
                        this.listings = [];
                        this.skip = 0;
                        await this.fetchData();
                    });
                },
                async fetchData() {
                    this.loading = true;
                    let response = await axios.get(route('frontend.jobs.get-data', {
                        filters: this.filters,
                        skip: 0,
                    }));
                    this.jobs = response.data.jobs;
                    this.loading = false;
                },
                async fetchMore() {
                    this.loading1 = true;
                    this.skip += 8;
                    let response = await axios.get(route('frontend.jobs.get-data', {
                        skip: this.skip,
                        filters: this.filters,
                    }));
                    this.jobs.push(...response.data.jobs);
                    this.loading1 = false;
                },

                async jobAction(id,acceptance) {
                    $.easyAjax({
                        url: "{{ route('job-posts.acceptance') }}",
                        type: "POST",
                        disableButton: true,
                        blockUI: true,
                        data: {
                            id: id,
                            _token: '{{ csrf_token() }}',
                            acceptance: acceptance
                        },
                        onComplete: () => {
                            this.fetchData();
                        }
                    })
                },

            }

        }
        <!--End Alpine-->
    </script>
@endpush
