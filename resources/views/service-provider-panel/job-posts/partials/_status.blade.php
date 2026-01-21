@php
$status = $job->status->value;
$color = $job->status->color();
@endphp
@if($status === 'assigned' || $status === 'not started' || $status === 'on hold' || $status === 'in progress')
<div class="dropdown">
    <span class="badge {{ $color }} dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        {{ ucfirst($status) }}
    </span>
    <ul class="dropdown-menu shadow-sm border-0">
        <li><button class="dropdown-item updateStatus" type="button" data-job_status="not started" id="{{ $job->id }}"><small>Not Started</small></button></li>
        <li><button class="dropdown-item updateStatus" type="button" data-job_status="in progress" id="{{ $job->id }}"><small>In Progress</small></button></li>
        <li><button class="dropdown-item updateStatus" type="button" data-job_status="on hold" id="{{ $job->id }}"><small>On Hold</small></button></li>
        <li><button class="dropdown-item updateStatus" type="button" data-job_status="completed" id="{{ $job->id }}"><small>Completed</small></button></li>
    </ul>
</div>
@else
    <span class="badge {{ $color }}" type="button">
        {{ ucfirst($status) }}
    </span>
@endif
