@php
    $assignedTo = isset($job->assignedTo) ? ucfirst($job->assignedTo->name) : 'Not Assigned';
@endphp
<div class="dropdown">
    <span class="badge soft-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        {{ $assignedTo }}
    </span>
    <ul class="dropdown-menu shadow-sm border-0">
        @foreach($serviceProviders as $provider)
            <li><button class="dropdown-item updateAssignedTo" type="button" data-job_assigned_to="{{ $provider->id }}" id="{{ $job->id }}"><small>{{ ucfirst($provider->name) }}</small></button></li>
        @endforeach
    </ul>
</div>
