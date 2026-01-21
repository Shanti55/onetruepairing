<div class="d-flex gap-2">
    @if(isset($job->assigned_to))
        <a href="{{ route('job-posts.show',['job'=>$job->id,'serviceprovider'=>$job->assigned_to]) }}" data-original-title="Show"
       class="btn soft-success btn-sm " title="Show"><i class="bi bi-eye-fill"></i></a>
    @else
    <a href="javascript:void(0)" data-original-title="Not Assigned"
       class="btn soft-primary btn-sm" title="Not Assigned"><i class="bi bi-eye-slash-fill"></i></a>
    @endif

    @if(hasPermissionFor('jobs_edit'))
    <a href="javascript:void(0)" data-toggle="tooltip" data-id="{{ $job->id }}" data-original-title="Edit"
       class="edit btn btn-sm soft-warning editJobPost" title="edit"><i class="bi bi-pencil-fill"></i></a>
    @endif

    @if(hasPermissionFor('jobs_delete'))
    <a href="javascript:void(0)" data-toggle="tooltip" data-id="{{ $job->id }}" data-original-title="Delete"
       class="btn btn-sm soft-danger deleteJobPost" title="Delete"><i class="bi bi-trash-fill"></i></a>
    @endif

    
</div>
