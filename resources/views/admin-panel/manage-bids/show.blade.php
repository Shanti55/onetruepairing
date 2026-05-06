@extends('admin-panel.layouts.app')

@section('content')
<div class="px-3">

    <div class="d-flex align-items-center justify-content-between mb-4">
        <h5 class="fw-semibold mb-0">Bids for: {{ $job->title }}</h5>
        <a href="{{ route('admin.manage-bids.index') }}" class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Back
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background:#f8f9fc;">
                        <tr>
                            <th class="px-4 py-3">Vendor Name</th>
                            <th class="py-3">Bid Amount</th>
                            <th class="py-3">Message</th>
                            <th class="py-3">Quotation</th>
                            <th class="py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bids as $bid)
                        <tr>
                            <td class="px-4">
                                <div class="fw-semibold">{{ $bid->vendor->name ?? '—' }}</div>
                                <small class="text-muted">{{ $bid->vendor->email ?? '' }}</small>
                            </td>
                            <td>
                                <span class="fw-bold text-success">
                                    ₹{{ number_format($bid->amount, 2) }}
                                </span>
                                @if($loop->first)
                                    <span class="badge bg-success ms-1" style="font-size:10px;">Lowest</span>
                                @endif
                            </td>
                            <td class="text-muted">{{ $bid->message ?? '—' }}</td>
                            <td>
                                @if($bid->attachment)
                                    <a href="{{ asset('uploads/bids/' . $bid->attachment) }}"
                                       target="_blank"
                                       class="btn btn-sm btn-danger py-0 px-2">
                                        <i class="bi bi-file-pdf me-1"></i>View PDF
                                    </a>
                                @else
                                    <span class="text-muted small">No Document</span>
                                @endif
                            </td>
                            <td>
                                @if($job->assigned_to == $bid->vendor_id)
                                    <span class="badge bg-success px-3 py-2">
                                        <i class="bi bi-check-circle me-1"></i>Hired
                                    </span>
                                @else
                                    <button class="btn btn-sm btn-primary hire-btn"
                                            data-job-id="{{ $job->id }}"
                                            data-vendor-id="{{ $bid->vendor_id }}"
                                            data-vendor-name="{{ $bid->vendor->name ?? '' }}">
                                        Hire Now
                                    </button>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                No bids found for this job.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection

@push('js')
<script type="module">
$(function () {
    $('body').on('click', '.hire-btn', function () {
        const jobId      = $(this).data('job-id');
        const vendorId   = $(this).data('vendor-id');
        const vendorName = $(this).data('vendor-name');

        if (!confirm(`Are you sure you want to hire "${vendorName}" for this job?`)) return;

        const $btn = $(this);
        $btn.prop('disabled', true).text('Processing...');

        $.ajax({
            url  : "{{ route('admin.manage-bids.hire') }}",
            type : 'POST',
            data : {
                _token    : "{{ csrf_token() }}",
                job_id    : jobId,
                vendor_id : vendorId,
            },
            success: function (res) {
                // Button ko Hired badge se replace karo
                $btn.replaceWith(`
                    <span class="badge bg-success px-3 py-2">
                        <i class="bi bi-check-circle me-1"></i>Hired
                    </span>
                `);
                alert(res.message ?? 'Vendor hired successfully!');
            },
            error: function (xhr) {
                $btn.prop('disabled', false).text('Hire Now');
                alert(xhr.responseJSON?.message ?? 'Something went wrong.');
            }
        });
    });
});
</script>
@endpush