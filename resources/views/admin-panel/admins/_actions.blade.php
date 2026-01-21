<div class="d-flex gap-2">
    @if(hasPermissionFor('admins_edit'))
        <a href="javascript:void(0)" data-toggle="tooltip" data-id="{{ $admin->id }}" data-original-title="Edit"
       class="edit btn soft-warning btn-sm editAdmin" title="Edit"><i class="bi bi-pencil-fill"></i></a>
    @endif
    @if(hasPermissionFor('admins_delete'))
    <a href="javascript:void(0)" data-toggle="tooltip" data-id="{{ $admin->id }}" data-original-title="Delete"
       class="btn soft-danger btn-sm deleteAdmin" title="Delete"><i class="bi bi-trash-fill"></i></a>
    @endif
</div>


