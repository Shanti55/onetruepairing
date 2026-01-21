@if(hasPermissionFor('roles_permissions_edit'))
    <a href="javascript:void(0)" data-toggle="tooltip" data-id="{{ $roles->id }}" data-original-title="Edit"
   class="btn soft-warning btn-sm editRolesPermissions" title="Edit"><i class="bi bi-pencil-fill"></i></a>
@endif
@if(hasPermissionFor('roles_permissions_delete'))
    <a href="javascript:void(0)" data-toggle="tooltip" data-id="{{ $roles->id }}" data-original-title="Delete"
   class="btn soft-danger btn-sm deleteRolesPermissions" title="Delete"><i class="bi bi-trash-fill"></i></a>
@endif
