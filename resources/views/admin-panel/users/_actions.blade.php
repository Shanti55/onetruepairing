<div class="d-flex gap-2">
    <a href="{{ route('users.show',['user'=>$user->id]) }}" data-original-title="Show"
       class="btn soft-success btn-sm " title="Show"><i class="bi bi-eye-fill"></i></a>

    @if(hasPermissionFor('users_edit'))
    <a href="javascript:void(0)" data-toggle="tooltip" data-id="{{ $user->id }}" data-original-title="Edit"
       class="btn soft-warning btn-sm editUser" title="Edit"><i class="bi bi-pencil-fill"></i></a>
    @endif
    @if(hasPermissionFor('users_delete'))
    <a href="javascript:void(0)" data-toggle="tooltip" data-id="{{ $user->id }}" data-original-title="Delete"
       class="btn soft-danger btn-sm deleteUser" title="Delete"><i class="bi bi-trash-fill"></i></a>
    @endif
</div>

