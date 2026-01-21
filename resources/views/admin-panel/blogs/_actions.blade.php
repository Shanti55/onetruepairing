<div class="d-flex gap-2">
    @if(hasPermissionFor('blogs_edit'))
    <a href="{{ route('blogs.edit',['blog'=>$blog->id]) }}" class="edit btn soft-warning btn-sm" title="Edit"><i class="bi bi-pencil-fill"></i></a>
    @endif

    @if(hasPermissionFor('blogs_delete'))
    <a href="javascript:void(0)" data-toggle="tooltip" data-id="{{ $blog->id }}" data-original-title="Delete"
       class="btn soft-danger btn-sm deleteBlog" title="Delete"><i class="bi bi-trash-fill"></i></a>
    @endif
</div>
