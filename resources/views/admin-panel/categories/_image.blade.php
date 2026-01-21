<div class="d-flex">
    <div class="img-responsive img-thumbnail mb-3" style="display: {{ isset($category->image) ? 'block' : 'none' }}">
        @if(isset($category->image))
            <img src="{{ url($category->image) }}" class="object-fit-cover" height="80" width="80">
        @endif
    </div>
</div>
