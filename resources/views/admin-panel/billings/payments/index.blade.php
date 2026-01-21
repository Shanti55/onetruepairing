@extends('admin-panel.layouts.app')

@section('content')

    <div class="px-3">
        <div class="d-flex align-items-center justify-content-between">
            <h5 class="fw-semibold">Payments</h5>
        </div>

        <div class="card mt-3 border-0 pb-2 shadow-sm">
            {{--            <h6 class="p-3 mb-0">Subscription Summary</h6>--}}
            {{--            <div class="d-flex justify-content-evenly">--}}
            {{--                @foreach(\App\Enums\UserSubscriptionStatus::cases() as $subscriptionStatus)--}}
            {{--                    <a href="#" class="btn btn-lg p-3 w-100 border-0 rounded-0 {{ $subscriptionStatus->color() }}">{{ 3 }} {{ ucwords(str_replace('_',' ',$subscriptionStatus->value)) }}</a>--}}
            {{--                @endforeach--}}
            {{--            </div>--}}
            <div class="table-responsive">
                <table id="payments-table" class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Amount(Rs.)</th>
                        <th>Attachment</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
        @include('admin-panel.billings._partials._attachment-modal')
    </div>

@endsection
@push('js')
    <script type="module">
        $(function () {
            var table = $('#payments-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('billing.payments.index') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'payment_date', name: 'payment_date'},
                    {data: 'user.name', name: 'user.name'},
                    {data: 'description', name: 'description'},
                    {data: 'amount',name: 'amount'},
                    {data: 'attachment',name: 'attachment'},
                    {data: 'status', name: 'status', orderable: false, searchable: false},
                ],
            });

            $('body').on('click', '.viewAttachment', function (e) {
                e.preventDefault();
                var value = $(this).data('attachment');
                const previewImage = document.getElementById('previewImage');
                previewImage.innerHTML = ''; // Clear previous previews
                const img = document.createElement('img');
                img.src = value; // Set the image source to the result from FileReader
                previewImage.appendChild(img); // Add the image to the preview div
                $('#attachmentModal').modal('show');
            });

            //Status Update
            $('body').on('click', '.updateStatus', function (e) {
                e.preventDefault();
                var id = $(this).attr('id');
                var status = $(this).data('payment_status');

                $.easyAjax({
                    url: "{{ route('payment.updateStatus') }}",
                    type: "POST",
                    disableButton: true,
                    blockUI: true,
                    data: {
                        id: id,
                        _token: '{{ csrf_token() }}',
                        status: status
                    },
                    onComplete: () => {
                        table.draw(false);
                    }
                })

            });



        });
    </script>
@endpush
