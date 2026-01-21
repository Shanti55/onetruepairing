<div class="card border-0 pb-2 shadow-sm">
    <div class="card-header bg-white border-0 pt-3 " style="border-radius: 0px;">
        <h4><i class="bi bi-list-ul"></i> Payment History</h4>
    </div>

    <div class="card-body table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Description</th>
                    <th>Amount(Rs.)</th>
                    <th>Attachment</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            @php
                $payments = \App\Models\Payment::where('user_id',$provider->id)->with('userSubscription')->latest()->get();
            @endphp
            @if(count($payments))
                @foreach($payments as $index=>$payment)
                    <tr>
                        <td>{{ $index+1 }}</td>
                        <td>{{ $payment->payment_date }}</td>
                        <td>
                            <div class="d-flex flex-column">
                                @if(isset($payment->userSubscription))
                                    <small class="fw-semibold text-dark">Plan - {{ $payment->userSubscription->plan->name }}</small>
                                    <small>Billing Cycle - {{ ucfirst($payment->userSubscription->billing_cycle) }}</small>
                                    <small>Validity - {{ $payment->userSubscription->start_date }} to {{ $payment->userSubscription->end_date }}</small>
                                @endif
                            </div>
                        </td>
                        <td>{{ $payment->amount }}</td>
                        <td>
                            <div>
                                @if(isset($payment->attachment))
                                    @php
                                        $fileType = checkFileType($payment->attachment);
                                    @endphp
                                    @if(isset($fileType) && $fileType=='image')
                                        <a href="javascript:void(0)" data-toggle="tooltip" data-attachment="{{ $payment->attachment }}" data-original-title="Attachment"
                                           class="badge soft-light btn-sm viewAttachment" title="Attachment"><i class="bi bi-link-45deg"></i> View Attachment</a>
                                    @elseif(isset($fileType) && $fileType=='pdf')
                                        <a href="{{ $payment->attachment }}" target="_blank" class="badge soft-light btn-sm" title="Attachment"><i class="bi bi-link-45deg"></i> View Attachment</a>
                                    @endif
                                @endif
                            </div>
                        </td>
                        <td>
                            <span class="badge {{  $payment->status->color() }}" aria-expanded="false">
                                {{ ucfirst($payment->status->value) }}
                            </span>
                        </td>
                    </tr>
                @endforeach

            @else
                <tr>
                    <td colspan="100%"><h6>No Payments Record Found</h6></td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
</div>
