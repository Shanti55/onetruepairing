<div class="modal fade" id="subscribeModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fw-bold" id="modelHeading"></h6>
            </div>
            <form id="subscribeForm" class="form-horizontal">
                <input type="hidden" name="user_id" value="{{ $provider ? $provider->id : null}}">
                <div class="modal-body">
                    @if(auth()->check())
                        <div>
                            <div class="form-group mb-3">
                                <label for="name" class="form-label">Choose Plan</label>
                                <select class="form-select" name="subscription_plan_id" id="subscription-plan">
                                    <option value="">Choose Plan</option>
                                    @foreach(\App\Models\SubscriptionPlan::all() as $subscriptionPlan)
                                        <option value="{{ $subscriptionPlan->id }}">{{ $subscriptionPlan->name }} [ Rs.{{ $subscriptionPlan->price }} - Monthly | Rs.{{ $subscriptionPlan->yearly_price }} - Yearly ]</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="name" class="form-label">Billing Cycle</label>
                                <select class="form-select" name="billing_cycle" id="billing-subscription">
                                    <option value="monthly">Monthly</option>
                                    <option value="yearly">Yearly</option>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="startDate" class="form-label">Start Date</label>
                                <input type="date" class="form-control" id="startDate" name="start_date">
                            </div>
                            <div class="form-group mb-3">
                                <label for="endDate" class="form-label">End Date</label>
                                <input type="date" class="form-control" id="endDate" name="end_date">
                            </div>
                            <div class="form-group mb-3">
                            <label for="status" class="form-label">Status</label>
                             <div class="d-flex gap-3">
                                 <div class="form-check">
                                     <input class="form-check-input" type="radio" name="status" id="onTrial" value="on_trial">
                                     <label class="form-check-label" for="onTrial">On Trial</label>
                                 </div>
                                 <div class="form-check">
                                     <input class="form-check-input" type="radio" name="status" id="active" value="active" checked>
                                     <label class="form-check-label" for="active">Active</label>
                                 </div>
                             </div>
                            </div>
                        </div>
                    @endif

                </div>
                @if(auth()->check())
                <div class="modal-footer bg-light d-flex justify-content-end py-1">
                    <button type="submit" class="btn btn-primary shadow-sm" id="save">Save
                    </button>
                </div>
                @endif
            </form>
        </div>
    </div>
</div>
