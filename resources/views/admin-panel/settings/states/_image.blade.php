<div class="d-flex">

    <div class="img-responsive img-thumbnail mb-3" style="display: {{ isset($state->image) ? 'block' : 'none' }}">
        @if(isset($state->image))
            <img src="{{ url($state->image) }}" class="object-fit-cover" height="80" width="80">
        @endif
    </div>
</div>
