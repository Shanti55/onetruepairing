@if(isset($job->assigned_to))
    <a href="{{ route('service-providers.my-jobs.show',['job'=>$job->id,'serviceprovider'=>$job->assigned_to]) }}" data-original-title="Show"
       class="btn soft-success btn-sm " title="Show"><i class="bi bi-eye-fill"></i></a>
@else
    <a href="javascript:void(0)" data-original-title="Not Assigned"
       class="btn soft-primary btn-sm" title="Not Assigned"><i class="bi bi-eye-slash-fill"></i></a>
@endif
<a href="javascript:void(0)" data-toggle="tooltip" data-id="{{ $job->id }}" data-original-title="Edit"
   class="edit btn btn-sm soft-warning  {{ $job->status->value == 'open' ? 'editJobPost' : 'disabled'  }}" title="edit"><i class="bi bi-pencil-fill"></i></a>
<a href="javascript:void(0)" data-toggle="tooltip" data-id="{{ $job->id }}" data-original-title="Delete"
   class="btn btn-sm soft-danger  {{ $job->status->value == 'open' ? 'deleteJobPost' : 'disabled'  }}" title="Delete"><i class="bi bi-trash-fill"></i></a>
