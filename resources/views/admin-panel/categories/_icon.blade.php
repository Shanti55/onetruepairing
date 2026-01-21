<div class="d-flex">
    <div class="img-responsive img-thumbnail mb-3" style="display: {{ isset($category->icon) ? 'block' : 'none' }}">
        @if(isset($category->icon))
            <img src="{{ url($category->icon) }}" class="object-fit-cover" height="40" width="40">
        @endif
    </div>
</div>
