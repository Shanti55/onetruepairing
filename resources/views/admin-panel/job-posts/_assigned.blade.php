@php
    $assignedTo = isset($job->assignedTo) ? ucfirst($job->assignedTo->name) : 'Not Assigned';
@endphp
<div class="dropdown">
    <span class="badge soft-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        {{ $assignedTo }}
    </span>
    <ul class="dropdown-menu shadow-sm border-0" style="max-height: 150px; overflow-y: auto;">
        <li class="px-3">
            <input type="text" class="form-control search-input" placeholder="Search..." onkeyup="filterProviders(this)">
        </li>
        @foreach($serviceProviders as $provider)
            <li class="provider-item">
                <button class="dropdown-item updateAssignedTo" type="button" data-job_assigned_to="{{ $provider->id }}" id="{{ $job->id }}">
                    <small>{{ ucfirst($provider->serviceproviderprofile->company_name ?? $provider->name) }}</small>
                </button>
            </li>
        @endforeach
    </ul>
</div>

<script>
    function filterProviders(input) {
        const filter = input.value.toLowerCase();
        const items = document.querySelectorAll('.provider-item');

        items.forEach(item => {
            const text = item.textContent.toLowerCase();
            item.style.display = text.includes(filter) ? '' : 'none';
        });
    }
</script>
