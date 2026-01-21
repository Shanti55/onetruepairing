<div class="card-wrapper">
{{--    <div class="card-top">--}}
{{--        <img  loading="lazy" src="{{ isset($serviceProvider->serviceproviderprofile->cover_image) ? url($serviceProvider->serviceproviderprofile->cover_image) : asset('frontend-images/bg-img.jpg')  }}" class="image img-responsive">--}}
{{--    </div>--}}
    <div class="card-top">
        @if(isset($serviceProvider->serviceproviderprofile->cover_image))
            <img loading="lazy" src="{{ url($serviceProvider->serviceproviderprofile->cover_image) }}" class="image img-responsive">
        @else
            <div class="no-image-placeholder">
                <div class="px-2">
                        <span class="top-text mb-2">{{ $serviceProvider->serviceproviderprofile ? $serviceProvider->serviceproviderprofile->company_name : $serviceProvider->name }}</span><br>
                        <span class="mb-2"><i class="bi bi-patch-check-fill text-primary"></i> Verified</span>
                        <span class="mb-2"><i class="bi bi-geo-alt pe-2"></i>{{ $serviceProvider->serviceproviderprofile->city }}, {{ $serviceProvider->serviceproviderprofile->state }}</span>
                </div>
            </div>
        @endif
    </div>

    <div class="card-bottom">
        <div class="d-flex flex-column">
            <span class="top-text mb-2">{{ $serviceProvider->serviceproviderprofile ? $serviceProvider->serviceproviderprofile->company_name : $serviceProvider->name }}</span>
            <span class="mb-2"><i class="bi bi-patch-check-fill text-primary"></i> Verified</span>
            <span class="mb-2"><i class="bi bi-geo-alt pe-2"></i>{{ $serviceProvider->serviceproviderprofile->city }}, {{ $serviceProvider->serviceproviderprofile->state }}</span>
        </div>
        @php
            $providerCategories = isset($serviceProvider->serviceproviderprofile->categories) ? json_decode($serviceProvider->serviceproviderprofile->categories) : null;
        @endphp
        @if($providerCategories)
            <div class="d-flex justify-content-start gap-2 mb-2 overflow-hidden">
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
        <br>
        <a href="{{ route('frontend.service-providers.show',['provider'=>$serviceProvider->id]) }}" class="btn btn-sm w-100 btn-primary">View Details</a>
    </div>
</div>

