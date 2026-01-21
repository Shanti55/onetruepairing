@php
$status = $job->status->value;
$color = $job->status->color();
@endphp

<span class="badge {{ $color }}" aria-expanded="false">
        {{ ucfirst($status) }}
</span>

