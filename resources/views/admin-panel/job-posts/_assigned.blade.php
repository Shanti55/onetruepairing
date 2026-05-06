@php
    $assignedTo = isset($job->assignedTo) ? ucfirst($job->assignedTo->name) : 'Not Assigned';
@endphp

<div class="dropdown">
    <span class="badge {{ isset($job->assignedTo) ? 'bg-success' : 'soft-light' }} dropdown-toggle" 
          type="button" data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;">
        {{ $assignedTo }}
    </span>
    
    <ul class="dropdown-menu shadow-sm border-0" style="max-width: 250px; max-height: 250px; overflow-y: auto;">
        <li class="px-3 py-2">
            <input type="text" class="form-control form-control-sm search-input" 
                   placeholder="Search vendor..." onkeyup="filterProviders(this)">
        </li>
        <li><hr class="dropdown-divider"></li>
        
        @foreach($serviceProviders as $provider)
            <li class="provider-item">
                <button class="dropdown-item py-2" type="button" 
                        onclick="confirmAndAssignWinner({{ $job->id }}, {{ $provider->id }}, '{{ addslashes($provider->name) }}')">
                    <div class="d-flex flex-column">
                        <span class="fw-bold">{{ ucfirst($provider->name) }}</span>
                        <small class="text-muted">{{ $provider->serviceproviderprofile->company_name ?? 'Individual' }}</small>
                    </div>
                </button>
            </li>
        @endforeach
    </ul>
</div>

<script>
    // Search Filter Logic
    function filterProviders(input) {
        const filter = input.value.toLowerCase();
        const items = input.closest('.dropdown-menu').querySelectorAll('.provider-item');

        items.forEach(item => {
            const text = item.textContent.toLowerCase();
            item.style.display = text.includes(filter) ? '' : 'none';
        });
    }

    // Winner Assignment + Refund Trigger Logic
    function confirmAndAssignWinner(jobId, vendorId, vendorName) {
        Swal.fire({
            title: 'Confirm Winner?',
            text: `Aap ${vendorName} ko select kar rahe hain. Isse baaki sabhi vendors ka 1% registration fee refund process (4-5 days) shuru ho jayega!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Assign & Refund Others',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.easyAjax({
                    url: "{{ route('job-posts.assignWinner') }}", // Aapke Controller ka naya method
                    type: "POST",
                    data: {
                        job_id: jobId,
                        vendor_id: vendorId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        if (response.status == 'success') {
                            // DataTable reload karein
                            if(typeof LaravelDataTables !== "undefined") {
                                LaravelDataTables["job-posts-table"].draw();
                            } else {
                                location.reload();
                            }
                        }
                    }
                });
            }
        });
    }
</script>