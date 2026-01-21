<!-- Featured Service Providers Section -->
<section id="team" class="team section">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <h2>Vendor</h2>
        <div><span>Featured</span> <span class="description-title">Providers</span></div>
    </div><!-- End Section Title -->

    <div class="container">

        <div class="row gy-5">
            @php
                $serviceProviders = \App\Models\User::has('serviceproviderprofile')->with('serviceproviderprofile')->where('role','service-provider')->where('status','verified')->get();
            @endphp
            @if(isset($serviceProviders))
                @foreach($serviceProviders as $serviceProvider)
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="card shadow">
                            <div class="pic">
                                <img  loading="lazy" src="{{ isset($serviceProvider->serviceproviderprofile->cover_image) ? url($serviceProvider->serviceproviderprofile->cover_image) : asset('frontend-images/bg-img.jpg')  }}" class="img-fluid object-fit-cover" alt="" style="border-top-left-radius: 7px;border-top-right-radius: 7px;height:250px;">
                            </div>
                            <div class="card-body">
                                <div class="member-info">
                                    <a href="{{ route('category.index') }}"><h4>{{ $serviceProvider->serviceproviderprofile ? $serviceProvider->serviceproviderprofile->company_name : $serviceProvider->name }}</h4></a>
                                    <div class="d-flex justify-content-start gap-2 mb-2">
                                        <div>
                                            <span class="badge bg-success" style="font-style: normal">4.3 <i class="bi bi-star-fill"></i></span>
                                        </div>
                                        <div><i class="bi bi-patch-check-fill text-primary"></i> Verified</div>
                                    </div>
                                    <div class="mb-2"><i class="bi bi-geo-alt pe-2"></i>{{ $serviceProvider->serviceproviderprofile->city }}, {{ $serviceProvider->serviceproviderprofile->state }}</div>
                                    @php
                                        $providerCategories = isset($serviceProvider->serviceproviderprofile->categories) ? json_decode($serviceProvider->serviceproviderprofile->categories) : null;
                                    @endphp
                                    @if($providerCategories)
                                        <div class="d-flex justify-content-start gap-2 mb-2 mt-3">
                                            @foreach($providerCategories as $category)
                                                @php
                                                    $categoryName = \App\Models\Category::find($category);
                                                @endphp
                                                @if(isset($categoryName))
                                                    <span class="badge soft-secondary" style="font-style: normal">{{ $categoryName->name }}</span>
                                                @endif
                                            @endforeach

                                        </div>
                                    @endif
                                    <div class="d-flex justify-content-between gap-2 mt-3">
                                        <button type="button" class="btn btn-primary border-0 rounded-2 w-50"><i class="bi bi-telephone me-1"></i> {{ $serviceProvider->serviceproviderprofile->contact_number ?? 'NA' }}</button>
                                        <button type="button" class="btn btn-warning border-0 rounded-2 w-50 text-white"><i class="bi bi-briefcase me-1"></i> Invite For Job</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</section>
