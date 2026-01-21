<div class="dropdown">
    <a class="dropdown-toggle" type="button" id="statusDropdown" data-bs-toggle="dropdown" aria-expanded="false">
        @if($blog->is_active == 1)
            <span class="badge bg-success" id="statusBadge">Active</span>
        @else
            <span class="badge bg-danger" id="statusBadge">In Active</span>
        @endif
    </a>
    <ul class="dropdown-menu" aria-labelledby="statusDropdown">
        @if($blog->is_active == 1)
            <li><a class="dropdown-item updateStatus" href="#" data-id="{{$blog->id}}"
                   data-status="0">    <span class="badge bg-danger">In Active</span></a></li>
        @else
            <li><a class="dropdown-item updateStatus" href="#" data-id="{{$blog->id}}"
                   data-status="1">  <span class="badge bg-success">Active</span></a></li>

        @endif
    </ul>
</div>
