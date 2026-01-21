@extends('admin-panel.layouts.app')
@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h5>Bids for: {{ $job->title }}</h5>
            <a href="{{ route('admin.manage-bids.index') }}" class="btn btn-secondary btn-sm">Back</a>
        </div>
        <div class="card-body">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Vendor Name</th>
                        <th>Bid Amount</th>
                        <th>Message</th>
                        <th>Quotation</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($job->bids as $bid)
                    <tr>
                        <td>{{ $bid->vendor->name ?? 'N/A' }}</td>
                      <td><b class="text-success">₹{{ number_format($bid->amount, 2) }}</b></td>
                        <td>{{ $bid->message }}</td>
                        <td>
                            @if($bid->quotation)
                                <a href="{{ asset('storage/'.$bid->quotation) }}" target="_blank" class="btn btn-sm btn-info">View PDF</a>
                            @else
                                No Document
                            @endif
                        </td>
                        <td>
                            @if($job->assigned_to == $bid->vendor_id)
                                <span class="badge bg-success">Hired</span>
                            @else
                                <form action="{{ route('admin.manage-bids.hire') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="job_id" value="{{ $job->id }}">
                                    <input type="hidden" name="vendor_id" value="{{ $bid->vendor_id }}">
                                    <button type="submit" class="btn btn-primary btn-sm" onclick="return confirm('Hire this vendor?')">Hire Now</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection