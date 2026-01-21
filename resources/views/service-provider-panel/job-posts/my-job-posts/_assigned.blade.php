@php
    $assignedTo = isset($job->assignedTo) ? ucfirst($job->assignedTo->name) : 'Not Assigned';
@endphp
<span class="badge soft-light" aria-expanded="false">
        {{ $assignedTo }}
</span>

