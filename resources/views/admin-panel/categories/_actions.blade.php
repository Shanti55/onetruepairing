<div class="d-flex gap-2">
    @if(hasPermissionFor('categories_edit'))
    <a href="javascript:void(0)" data-toggle="tooltip" data-id="{{ $category->id }}" data-original-title="Edit"
       class="edit btn soft-warning btn-sm editCategory" title="Edit"><i class="bi bi-pencil-fill"></i></a>
    @endif

    @if(hasPermissionFor('categories_delete'))
    <a href="javascript:void(0)" data-toggle="tooltip" data-id="{{ $category->id }}" data-original-title="Delete"
       class="btn soft-danger btn-sm deleteCategory" title="Delete"><i class="bi bi-trash-fill"></i></a>
    @endif
</div>
