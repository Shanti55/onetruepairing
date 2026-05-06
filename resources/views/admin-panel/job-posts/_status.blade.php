@php
    // Model casting ki wajah se $job->status ab Enum object hai
    $currentStatus = $job->status; 
@endphp

<div class="dropdown">
    <span class="badge {{ $currentStatus->color() }} dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        {{ $currentStatus->label() }}
    </span>

    <ul class="dropdown-menu shadow-sm border-0">
        @foreach(\App\Enums\JobStatus::cases() as $jobStatus)
            <li>
                <button class="dropdown-item updateStatus" type="button" 
                        data-job_status="{{ $jobStatus->value }}" 
                        id="{{ $job->id }}">
                    <small>
                        <i class="bi bi-circle-fill {{ $jobStatus->textColor() }} me-1"></i>
                    </small>
                    <small>{{ $jobStatus->label() }}</small> </button>
            </li>
        @endforeach
    </ul>
</div>