@extends('admin-panel.layouts.app')

@section('content')

    <div class="px-3">
        <div class="d-flex align-items-center justify-content-between">
            <h5 class="fw-semibold">Manage Subscription Plans</h5>

            @if(hasPermissionFor('subscription_plan_create'))
            {{-- ✅ data-bs-toggle hata diya --}}
            <a href="#" id="add-subscription-plan-btn" class="btn btn-primary shadow-sm">
                <i class="fas fa-add me-1"></i> Add Plan
            </a>
            @endif
        </div>

        <div class="card mt-3 border-0 pb-2 shadow-sm">
            <div class="table-responsive">
                <table id="subscription-plans-table" class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Plan Code</th>
                        <th>Monthly Price(Rs.)</th>
                        <th>Yearly Price(Rs.)</th>
                        <th>Features</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>

        @include('admin-panel.subscription-plans._form')

    </div>

@endsection

@push('js')
<script type="module">
$(function () {

    var table = $('#subscription-plans-table').DataTable({
        processing: true,
        serverSide: true,
        columnDefs: [{ width: '30%', targets: 5 }],
        ajax: "{{ route('subscription-plans.index') }}",
        columns: [
            {data: 'DT_RowIndex',   name: 'DT_RowIndex'},
            {data: 'name',          name: 'name'},
            {data: 'plan_id',       name: 'plan_id'},
            {data: 'price',         name: 'price'},
            {data: 'yearly_price',  name: 'yearly_price'},
            {data: 'features',      name: 'features'},
            {data: 'status',        name: 'status',  orderable: false, searchable: false},
            {data: 'action',        name: 'action',  orderable: false, searchable: false},
        ],
    });

    // ✅ Bootstrap 5 native modal — jQuery .modal() nahi kaam karta
    const subscriptionModal = new bootstrap.Modal(
        document.getElementById('subscriptionPlanModal')
    );

    // ── Add Plan ──────────────────────────────────────────────────────────
    $('#add-subscription-plan-btn').on('click', function (e) {
        e.preventDefault();
        $('#id').val('');
        $('#subscriptionPlanForm').trigger("reset");
        $('#modelHeading').html("Create New Subscription Plan");
        subscriptionModal.show();
    });

    // ── Save / Update ─────────────────────────────────────────────────────
    $('#subscriptionPlanForm').on('submit', function (e) {
        e.preventDefault();
        var data = new FormData($('#subscriptionPlanForm')[0]);
        $.easyAjax({
            url: "{{ route('subscription-plans.storeOrUpdate') }}",
            container: '#subscriptionPlanForm',
            type: "POST",
            disableButton: true,
            blockUI: true,
            data: data,
            onComplete: () => {
                subscriptionModal.hide();
                $('#modelHeading').html("Create New Subscription Plan");
                $('#subscriptionPlanForm').trigger("reset");
                table.draw(false);
            }
        });
    });

    // ── Edit ──────────────────────────────────────────────────────────────
    $('body').on('click', '.editSubscriptionPlan', function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        axios.get(route('subscription-plans.edit', { plan: id })).then((response) => {
            $('#modelHeading').html("Edit Subscription Plan");
            subscriptionModal.show();

            var form = $('#subscriptionPlanForm').trigger("reset");
            $.each(response.data, function (key, value) {
                if (key !== 'features') {
                    var inputField = form.find('[name="' + key + '"]');
                    if (inputField.length) {
                        inputField.val(value);
                        $(inputField).trigger('change');
                    }
                } else {
                    const features = JSON.parse(value);
                    $.each(features, function (key, value) {
                        var inputField = form.find('[id="' + value + '"]');
                        if (inputField.length) {
                            inputField.prop('checked', true);
                            inputField.trigger('change');
                        }
                    });
                }
            });
        });
    });

    // ── Delete ────────────────────────────────────────────────────────────
    $('body').on('click', '.deleteSubscriptionPlan', function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        $.easyDelete({
            url: route('subscription-plans.delete', { plan: id }),
            confirmationMessage: 'Do you really want to delete this subscription plan?',
            onComplete: () => {
                table.draw(false);
            }
        });
    });

});
</script>
@endpush