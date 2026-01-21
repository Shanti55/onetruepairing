@php
    $status = $payment->status->value;
    $color = $payment->status->color();
@endphp
<div class="dropdown">
    <span class="badge {{ $color }} dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        {{ ucfirst($status) }}
    </span>
    <ul class="dropdown-menu shadow-sm border-0">
        @foreach(\App\Enums\PaymentStatus::cases() as $paymentStatus)
            <li><button class="dropdown-item updateStatus" type="button" data-payment_status="{{ $paymentStatus->value }}" id="{{ $payment->id }}"><small>{{ ucwords($paymentStatus->value) }}</small></button></li>
        @endforeach
    </ul>
</div>


{{--    <span class="badge {{ $color }}" aria-expanded="false">--}}
{{--        {{ ucwords(str_replace('_',' ',$status)) }}--}}
{{--    </span>--}}
