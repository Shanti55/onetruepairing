@if(hasPermissionFor('services_edit'))
    <a href="javascript:void(0)" data-toggle="tooltip" data-id="{{ $service->id }}" data-original-title="Edit"
   class="edit btn soft-warning btn-sm editService" title="Edit"><i class="bi bi-pencil-fill"></i></a>
@endif
@if(hasPermissionFor('services_delete'))
    <a href="javascript:void(0)" data-toggle="tooltip" data-id="{{ $service->id }}" data-original-title="Delete"
   class="btn soft-danger btn-sm deleteService" title="Delete"><i class="bi bi-trash-fill"></i></a>
@endif
