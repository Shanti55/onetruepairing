@extends('frontend.layouts.app')

@section('title', 'Jobs | CtrlF')

@section('content')

    <section id="hero" class="hero section dark-background" style="position: sticky">
        <img src="{{ asset('frontend-images/bg-img.jpg') }}" alt="" class="hero-bg"  loading="lazy">
        <div class="container">
            <div class="text-center">
                <img src="{{ asset('images/show_files/job1.png') }}" alt=""  loading="lazy">
                <h2 class="mt-3">Required Contractor For My New Project</h2>
                <div class="d-flex justify-content-center align-items-center gap-3">
                    <p class="mb-0" style="font-size: 17px;"><i class="bi bi-clock"></i> Posted Date:
                        <span class="text-white">2 years ago</span>
                    </p>
                    <div style="border-left: 1px solid #fff; height: 25px;"></div>

                    <p class="mb-0" style="font-size: 17px;"><i class="bi bi-hourglass"></i> Expires In:
                        <span class="badge soft-success p-2 px-3 mx-2"  style="cursor: pointer"> June 20,2024</span>
                    </p>
                </div>


            </div>
        </div>
    </section>

    <div class="container">
        <div class="card rounded-5 contact" style="margin-top: -70px;">
            <div class="row" style="margin-right: inherit;margin-left: inherit;">
                <div class="col-md-4 border-end border-bottom p-3">
                    <div class="info-item d-flex aos-init aos-animate" data-aos="fade-up" data-aos-delay="200">
                        <i class="bi bi-geo-alt flex-shrink-0"></i>
                        <div>
                            <h3>Location:</h3>
                            <p>Mumbai</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 border-end border-bottom p-3">
                    <div class="info-item d-flex aos-init aos-animate" data-aos="fade-up" data-aos-delay="200">
                        <i class="bi bi-currency-dollar flex-shrink-0"></i>
                        <div>
                            <h3>Price:</h3>
                            <p>$2500</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 border-bottom p-3">
                    <div class="info-item d-flex aos-init aos-animate" data-aos="fade-up" data-aos-delay="200">
                        <i class="bi bi-briefcase flex-shrink-0"></i>
                        <div>
                            <h3>Job Type:</h3>
                            <p>Full Time</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" style="margin-right: inherit;margin-left: inherit;">
                <div class="col-md-4 border-end  p-3">
                    <div class="info-item d-flex aos-init aos-animate" data-aos="fade-up" data-aos-delay="200">
                        <i class="bi bi-tag flex-shrink-0"></i>
                        <div>
                            <h3>Categories:</h3>
                            <p>Beauty and Personal Care</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 border-end p-3">
                    <div class="info-item d-flex aos-init aos-animate" data-aos="fade-up" data-aos-delay="200">
                        <i class="bi bi-clock flex-shrink-0"></i>
                        <div>
                            <h3>Hours:</h3>
                            <p>2</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 p-3">
                    <div class="info-item d-flex aos-init aos-animate" data-aos="fade-up" data-aos-delay="200">
                        <i class="bi bi-person flex-shrink-0"></i>
                        <div>
                            <h3>Posted On:</h3>
                            <p>2 years ago</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-md-8 info-item">
                <h3 class=" mb-0"><b>Job Description:</b></h3>
                <p class="mt-3">Job Duties and Tasks for: “Landscaping and Groundskeeping Worker”

                    1) Care for established lawns by mulching, aerating, weeding, grubbing and removing thatch, and trimming and edging around flower beds, walks, and walls.

                    2) Mix and spray or spread fertilizers, herbicides, or insecticides onto grass, shrubs, and trees, using hand or automatic sprayers or spreaders.

                    3) Mow and edge lawns, using power mowers and edgers.

                    4) Plant seeds, bulbs, foliage, flowering plants, grass, ground covers, trees, and shrubs, and apply mulch for protection, using gardening tools.

                </p>
            </div>
            <div class="col-md-4 info-item">
                <h5 class="mb-0"><b>Location:</b></h5>
                <button id="showMoreBtn" class="cu-btn rounded-2 border-0 mt-3 w-100" style="font-size: 20px;"><b>Get Directions
                        <i class="bi bi-geo-alt flex-shrink-0"></i></b></button>
            </div>
        </div>
    </div>





@endsection
