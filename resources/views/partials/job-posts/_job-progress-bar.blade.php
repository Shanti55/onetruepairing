@php

$jobProgress = $job->progress()->orderBy('date', 'desc')->first();

if(isset($jobProgress)){
    $jobProgress = floor($jobProgress->progress_value);
}else{
    $jobProgress = 0;
}

@endphp

<div class="progress blue">
    <div class="progress-bar" style="width:{{$jobProgress}}%; background:#0d6efd;">
        <div class="progress-value">{{$jobProgress}}%</div>
    </div>
</div>
