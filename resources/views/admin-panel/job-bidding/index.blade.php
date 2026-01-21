@extends('admin-panel.layouts.app')
@section('content')
<div class="card">
    <div class="card-header"><h4>Manage Job Bids</h4></div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Job ID</th>
                    <th>Job Title</th>
                    <th>Total Bids</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jobs as $job)
                <tr>
                    <td>{{ $job->id }}</td>
                    <td>{{ $job->title }}</td>
                    <td><span class="badge bg-info">{{ $job->bids_count }} Bids</span></td>
                    <td>
                        @if($job->assigned_to)
                            <span class="badge bg-success">Assigned</span>
                        @else
                            <span class="badge bg-warning">Open for Bidding</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.manage-bids.show', $job->id) }}" class="btn btn-sm btn-primary">View Bids</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">No bids found for any job.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection