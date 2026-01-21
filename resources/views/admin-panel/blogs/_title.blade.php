@if(hasPermissionFor('blogs_edit'))
    <div class="d-flex flex-column">
       <h6><a href="{{ route('blogs.edit',['blog'=>$blog]) }}">{{ \Illuminate\Support\Str::words(strip_tags($blog->title), 8, '...') }}</a> </h6>
       <small>Posted By : {{ $blog->postedBy->name ?? 'NA' }}</small>
       <small class="text-muted">Created : {{ $blog->created_at->format('d/m/Y H:i a') }}</small>
    </div>
@else
    <div class="d-flex flex-column">
        <h6>{{ \Illuminate\Support\Str::words(strip_tags($blog->title), 8, '...') }}</h6>
        <small>Posted By : {{ $blog->postedBy->name ?? 'NA' }}</small>
        <small class="text-muted">Created : {{ $blog->created_at->format('d/m/Y H:i a') }}</small>
    </div>
@endif
