
   @foreach($features as $feature)
        <li><i class="bi bi-check"></i> <span>{{ ucwords(str_replace('_',' ',$feature)) }}</span></li>
    @endforeach
