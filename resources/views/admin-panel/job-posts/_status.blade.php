@php
$status = $job->status->value;
$color = $job->status->color();
@endphp
<div class="dropdown">
    <span class="badge {{ $color }} dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        {{ ucfirst($status) }}
    </span>
    <ul class="dropdown-menu shadow-sm border-0">
        @foreach(\App\Enums\JobStatus::cases() as $jobStatus)
            <li><button class="dropdown-item updateStatus" type="button" data-job_status="{{ $jobStatus->value }}" id="{{ $job->id }}"><small><i class="bi bi-circle-fill {{ $jobStatus->textColor() }} me-1"></i></small><small>{{ ucfirst($jobStatus->value) }}</small></button></li>
        @endforeach
    </ul>
</div>
