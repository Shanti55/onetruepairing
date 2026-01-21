<div class="d-flex flex-column">
    @if(isset($payment->userSubscription))
    <small class="fw-semibold text-dark">Plan - {{ $payment->userSubscription->plan->name }}</small>
    <small>Billing Cycle - {{ ucfirst($payment->userSubscription->billing_cycle) }}</small>
    <small>Validity - {{ $payment->userSubscription->start_date }} to {{ $payment->userSubscription->end_date }}</small>
    @endif
</div>
