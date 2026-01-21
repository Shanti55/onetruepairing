@php
    $status = $subscription->status->value;
    $color = $subscription->status->color();
@endphp
{{--<div class="dropdown">--}}
{{--    <span class="badge {{ $color }} dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">--}}
{{--        {{ ucfirst($status) }}--}}
{{--    </span>--}}
{{--    <ul class="dropdown-menu shadow-sm border-0">--}}
{{--        @foreach(\App\Enums\UserSubscriptionStatus::cases() as $subscriptionStatus)--}}
{{--            <li><button class="dropdown-item updateStatus" type="button" data-job_status="{{ $subscriptionStatus->value }}" id="{{ $subscription->id }}"><small>{{ ucfirst($subscriptionStatus->value) }}</small></button></li>--}}
{{--        @endforeach--}}
{{--    </ul>--}}
{{--</div>--}}


    <span class="badge {{ $color }}" aria-expanded="false">
        {{ ucwords(str_replace('_',' ',$status)) }}
    </span>
