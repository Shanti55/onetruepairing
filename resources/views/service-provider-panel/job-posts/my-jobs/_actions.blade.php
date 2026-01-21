@if(isset($job->assigned_to))
<a href="{{ route('service-providers.my-jobs.show',['job'=>$job->id,'serviceprovider'=>$job->assigned_to]) }}" data-original-title="Show"
   class="btn soft-success btn-sm " title="Show"><i class="bi bi-eye-fill"></i></a>
@else
<a href="javascript:void(0)" data-original-title="Not Assigned"
   class="btn soft-primary btn-sm" title="Not Assigned"><i class="bi bi-eye-slash-fill"></i></a>
@endif


