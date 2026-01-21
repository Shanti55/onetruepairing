@if(auth()->user()->isAdmin())
<a href="javascript:void(0)" data-toggle="tooltip" data-id="{{ $jobProgress->id }}" data-original-title="Edit"
   class="edit btn soft-warning btn-sm editJobProgress" title="Edit"><i class="bi bi-pencil-fill"></i></a>
<a href="javascript:void(0)" data-toggle="tooltip" data-id="{{ $jobProgress->id }}" data-original-title="Delete"
   class="btn soft-danger btn-sm deleteJobProgress" title="Delete"><i class="bi bi-trash-fill"></i></a>
@endif
