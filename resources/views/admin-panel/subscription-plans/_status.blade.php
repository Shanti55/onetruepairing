@php
$status = $plan->status;
$color = $status == 'active' ? 'soft-success' : 'soft-light';
@endphp
<span class="badge {{ $color }}">{{ $status }}</span>
