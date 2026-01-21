<div class="d-flex gap-2">
    @if(hasPermissionFor('subscription_plan_edit'))
    <a href="javascript:void(0)" data-toggle="tooltip" data-id="{{ $plan->id }}" data-original-title="Edit"
       class="btn soft-warning btn-sm editSubscriptionPlan" title="Edit"><i class="bi bi-pencil-fill"></i></a>
    @endif
    @if(hasPermissionFor('subscription_plan_delete'))
    <a href="javascript:void(0)" data-toggle="tooltip" data-id="{{ $plan->id }}" data-original-title="Delete"
       class="btn soft-danger btn-sm deleteSubscriptionPlan" title="Delete"><i class="bi bi-trash-fill"></i></a>
    @endif
</div>
