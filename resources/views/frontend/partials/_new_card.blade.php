<div class="card-container shadow-sm">
    <div class="cardd">
        @if(isset($serviceProvider->serviceproviderprofile->cover_image))
        <img src="{{ url($serviceProvider->serviceproviderprofile->cover_image) }}" class="card-img" alt="Background Image">
        <div class="card-overlay">
                <div class="d-flex flex-column">
                    <span class="top-text mb-2">{{ $serviceProvider->serviceproviderprofile ? $serviceProvider->serviceproviderprofile->company_name : $serviceProvider->name }}</span>
                    <span class="mb-2"><i class="bi bi-patch-check-fill text-primary"></i> Verified</span>
                    <span class="mb-2"><i class="bi bi-geo-alt pe-2"></i>{{ $serviceProvider->serviceproviderprofile->city }}, {{ $serviceProvider->serviceproviderprofile->state }}</span>
                </div>
                @php
                    $providerCategories = isset($serviceProvider->serviceproviderprofile->categories) ? json_decode($serviceProvider->serviceproviderprofile->categories) : null;
                @endphp
                @if($providerCategories)
                    <div class="">
                        @foreach(array_slice($providerCategories, 0, 4) as $category)
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
                <a href="{{ route('frontend.service-providers.show',['provider'=>$serviceProvider->id]) }}" class="btn btn-sm w-100 btn-primary w-100">View Details</a>
            </div>
        @else
            <div class="card-no-bg shadow-sm">
                <div class="d-flex flex-column">
                    <h1 class="top-text mb-2">{{ $serviceProvider->serviceproviderprofile ? $serviceProvider->serviceproviderprofile->company_name : $serviceProvider->name }}</h1>
                    <span class="mb-2"><i class="bi bi-patch-check-fill text-primary"></i> Verified</span>
                    <span class="mb-2"><i class="bi bi-geo-alt pe-2"></i>{{ $serviceProvider->serviceproviderprofile->city }}, {{ $serviceProvider->serviceproviderprofile->state }}</span>
                </div>
                @php
                    $providerCategories = isset($serviceProvider->serviceproviderprofile->categories) ? json_decode($serviceProvider->serviceproviderprofile->categories) : null;
                @endphp
                @if($providerCategories)
                    <div class="">
                        @foreach(array_slice($providerCategories, 0, 4) as $category)
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
                <a href="{{ route('frontend.service-providers.show',['provider'=>$serviceProvider->id]) }}" class="btn btn-sm w-100 btn-primary w-100">View Details</a>
            </div>

        @endif

    </div>
</div>
