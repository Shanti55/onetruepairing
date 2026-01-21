@php
    $subCategories = \App\Models\Category::where('parent_id',$category->id)->get();
@endphp

<div class="d-flex flex-column">
    <h6 class="mb-0">{{ $category->name }}</h6>
    @if(count($subCategories)>0)
        @foreach($subCategories as $subCategory)
            <p class="mb-0">
                <a href="javascript:void(0)" data-toggle="tooltip" data-id="{{ $subCategory->id }}" data-original-title="Edit"
              class="edit editCategory" title="Edit">- {{ $subCategory->name }}</a>
                |
                <a href="javascript:void(0)" data-toggle="tooltip" data-id="{{ $subCategory->id }}" data-original-title="Delete"
                   class="deleteCategory" title="Delete"><i class="bi bi-trash"></i></a>
            </p>
        @endforeach
    @endif
</div>
