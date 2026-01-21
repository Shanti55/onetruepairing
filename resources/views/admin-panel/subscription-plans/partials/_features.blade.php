@php
    $features = isset($plan->features) ? json_decode($plan->features) : [];
@endphp

<div>
    @if(isset($features))
        <div class="d-flex flex-wrap gap-1">
            @foreach($features as $feature)
                <span class="badge soft-light"><i class="bi bi-check-circle-fill text-success"></i> {{ ucfirst(str_replace('_', ' ', $feature)) }}</span>
            @endforeach
        </div>
    @else
        <span class="badge soft-light"><i class="bi bi-x-circle-fill text-danger"></i> No Features</span>
    @endif
</div>
