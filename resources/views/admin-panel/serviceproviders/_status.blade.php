@php
$status = $serviceprovider->status->value;
$color = $serviceprovider->status->color();
@endphp
<div class="dropdown">
    <span class="badge {{ $color }} dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        {{ ucfirst($status) }}
    </span>
    <ul class="dropdown-menu shadow-sm border-0">
        @foreach(\App\Enums\UserStatus::cases() as $userStatus)
            <li><button class="dropdown-item updateStatus" type="button" data-status="{{ $userStatus->value }}" id="{{ $serviceprovider->id }}"><small><i class="bi bi-circle-fill {{ $userStatus->textColor() }} me-1"></i></small><small>{{ ucfirst($userStatus->value) }}</small></button></li>
        @endforeach
    </ul>
</div>
