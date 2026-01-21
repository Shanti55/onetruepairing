@extends('admin-panel.layouts.app')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Job Bids: {{ $job->title }}</h4>
                    <div class="page-title-right">
                        <a href="{{ route('job-posts.index') }}" class="btn btn-primary btn-sm">
                            <i class="ri-arrow-left-line"></i> Back to Jobs
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">List of Vendors who placed a bid</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered dt-responsive nowrap table-striped align-middle">
                                <thead>
                                    <tr>
                                        <th>Vendor Name</th>
                                        <th>Bid Amount</th>
                                        <th>Quotation PDF</th>
                                        <th>Message</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($bids as $bid)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1">{{ $bid->vendor->name ?? 'N/A' }}</div>
                                            </div>
                                        </td>
                                        <td><span class="text-success fw-bold">₹{{ number_format($bid->bid_amount) }}</span></td>
                                        <td>
                                            @if($bid->quotation)
                                                <a href="{{ asset('storage/' . $bid->quotation) }}" target="_blank" class="btn btn-sm btn-soft-danger">
                                                    <i class="ri-file-pdf-fill"></i> View Quote
                                                </a>
                                            @else
                                                <span class="text-muted">No PDF</span>
                                            @endif
                                        </td>
                                        <td>{{ Str::limit($bid->message, 50) }}</td>
                                        <td>{{ $bid->created_at->format('d M, Y') }}</td>
                                        <td>
                                            @if($job->vendor_id == $bid->vendor_id)
                                                <span class="badge bg-success">Selected Winner</span>
                                            @else
                                                <span class="badge bg-warning">Pending</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if(!$job->vendor_id)
                                                <form action="{{ route('job-posts.selectWinner') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="job_id" value="{{ $job->id }}">
                                                    <input type="hidden" name="vendor_id" value="{{ $bid->vendor_id }}">
                                                    <button type="submit" class="btn btn-sm btn-primary" onclick="return confirm('Do you want to hire this vendor?')">
                                                        Hire Now
                                                    </button>
                                                </form>
                                            @elseif($job->vendor_id == $bid->vendor_id)
                                                <button class="btn btn-sm btn-success" disabled>Hired</button>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Abhi tak kisi vendor ne bid nahi ki hai.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection