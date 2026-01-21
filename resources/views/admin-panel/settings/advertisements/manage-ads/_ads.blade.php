<div class="d-flex">
    <div class="img-responsive img-thumbnail mb-3" style="display: {{ isset($advertisement->ad_url) ? 'block' : 'none' }}">
        @if(isset($advertisement->ad_url))
            <a href="{{ $advertisement->ad_url }}" target="_blank">
                <img src="{{ url($advertisement->ad_url) }}" class="img-fluid img-responsive" width="150">
            </a>
        @endif
    </div>
</div>
