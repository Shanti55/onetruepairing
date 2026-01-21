@extends('admin-panel.layouts.app')

@section('content')

    <div class="px-3">
        <div class="d-flex align-items-center justify-content-between">
            <h5 class="fw-semibold">Manage Subscription Plans</h5>

            @if(hasPermissionFor('subscription_plan_create'))
            <a href="#" data-bs-toggle="#subscriptionPlanModal" id="add-subscription-plan-btn" class="btn btn-primary shadow-sm">
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
                    <tbody>
                    </tbody>
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
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'name', name: 'name'},
                    {data: 'plan_id', name: 'plan_id'},
                    {data: 'price', name: 'price'},
                    {data: 'yearly_price', name: 'yearly_price'},
                    {data: 'features', name: 'features'},
                    {data: 'status', name: 'status', orderable: false, searchable: false},
                    {data: 'action', name: 'action', orderable: false, searchable: false},


                ],
            });

            $('#add-subscription-plan-btn').click(function () {
                $('#id').val('');
                $('#subscriptionPlanForm').trigger("reset");
                $('#modelHeading').html("Create New Subscription Plan");
                $('#subscriptionPlanModal').modal('show');
            });

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
                        $('#subscriptionPlanModal').modal('hide');
                        $('#modelHeading').html("Create New Subscription Plan");
                        $('#subscriptionPlanForm').trigger("reset");
                        table.draw(false);
                    }
                })

            });

            $('body').on('click', '.editSubscriptionPlan', function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                axios.get(route('subscription-plans.edit', {plan: id})).then((response) => {
                    $('#modelHeading').html("Edit Subscription Plan");
                    $('#subscriptionPlanModal').modal('show');

                    var form = $('#subscriptionPlanForm').trigger("reset"); // Adjust the form ID as needed

                    $.each(response.data, function (key, value) {
                       if(key !== 'features'){
                           var inputField = form.find('[name="' + key + '"]'); // Scope to form
                           if (inputField.length) {
                               inputField.val(value);
                               $(inputField).trigger('change')
                           }
                       }else{
                           const features = JSON.parse(value);
                           $.each(features, function (key, value) {
                               var inputField = form.find('[id="' + value + '"]'); // Scope to form
                               if (inputField.length) {
                                   console.log(inputField);
                                   // Set the 'checked' property using jQuery .prop() method
                                   inputField.prop('checked', true);
                                   // Trigger the 'change' event
                                   inputField.trigger('change');
                               }
                           });

                       }

                    });

                });
            });

            $('body').on('click', '.deleteSubscriptionPlan', function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                $.easyDelete({
                    url: route('subscription-plans.delete', {plan: id}),
                    confirmationMessage: 'Do you really want to delete this subscription plan ?',
                    onComplete: () => {
                        table.draw(false);
                    }
                })
            });

        });
    </script>
@endpush
