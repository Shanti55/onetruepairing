@php
    $profile = $provider->serviceproviderprofile;
    $status = $provider->status->value;
    $color = $provider->status->color();
@endphp
<div>
    <p class="m-0 p-0"><a class="fw-semibold" href="{{ route('serviceproviders.show',['serviceprovider'=>$provider->id]) }}">{{ $profile ? $profile->company_name : 'NA'}}</a></p>
    <p class="m-0 p-0 text-muted small">{{ $provider->name }}</p>
    <p class="m-0 p-0 text-muted small">{{ $provider->email ?? 'NA' }}</p>
    <p class="m-0 p-0 text-muted small">{{ $profile ? $profile->contact_number : 'NA' }}</p>
    <span class="badge {{ $color }}" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        {{ ucfirst($status) }}
    </span>
</div>


