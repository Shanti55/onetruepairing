<div class="d-flex gap-2">
    <a href="javascript:void(0)" 
       onclick="openAuctionModal({{ $job->id }})" 
       class="btn btn-sm soft-info" 
       title="Live Now / Extend Auction">
        <i class="bi bi-broadcast fs-5 text-info"></i>
    </a>

    @if(isset($job->assigned_to))
        <a href="{{ route('job-posts.show',['job'=>$job->id,'serviceprovider'=>$job->assigned_to]) }}" 
           class="btn soft-success btn-sm" title="Show">
            <i class="bi bi-eye-fill"></i>
        </a>
    @else
        <a href="javascript:void(0)" class="btn soft-primary btn-sm" title="Not Assigned">
            <i class="bi bi-eye-slash-fill"></i>
        </a>
    @endif

    @if(hasPermissionFor('jobs_edit'))
        <a href="javascript:void(0)" data-id="{{ $job->id }}" 
           class="edit btn btn-sm soft-warning editJobPost" title="Edit">
            <i class="bi bi-pencil-fill"></i>
        </a>
    @endif

    @if(hasPermissionFor('jobs_delete'))
        <a href="javascript:void(0)" data-id="{{ $job->id }}" 
           class="btn btn-sm soft-danger deleteJobPost" title="Delete">
            <i class="bi bi-trash-fill"></i>
        </a>
    @endif
</div>