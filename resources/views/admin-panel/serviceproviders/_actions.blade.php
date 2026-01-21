<a href="{{ route('serviceproviders.show',['serviceprovider'=>$serviceprovider->id]) }}" data-original-title="Show"
   class="btn soft-success btn-sm " title="Show"><i class="bi bi-eye-fill"></i></a>

@if(hasPermissionFor('service_providers_edit'))
<a href="{{ route('serviceproviders.update',['serviceprovider'=>$serviceprovider->id]) }}" data-original-title="Show"
   class="btn soft-warning btn-sm" title="Update"><i class="bi bi-pencil-fill"></i></a>
@endif
{{--<a href="javascript:void(0)" data-toggle="tooltip" data-id="{{ $serviceprovider->id }}" data-original-title="Edit"--}}
{{--   class="edit btn soft-warning btn-sm editServiceProvider" title="Edit"><i class="bi bi-pencil-fill"></i></a>--}}
@if(hasPermissionFor('service_providers_delete'))
<a href="javascript:void(0)" data-toggle="tooltip" data-id="{{ $serviceprovider->id }}" data-original-title="Delete"
   class="btn soft-danger btn-sm deleteServiceProvider" title="Delete"><i class="bi bi-trash-fill"></i></a>
@endif
