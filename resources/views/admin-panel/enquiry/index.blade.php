@extends('admin-panel.layouts.app')

@section('content')

    <div class="px-3">
        <div class="d-flex align-items-center justify-content-between">
            <h5 class="fw-semibold">Enquiry</h5>
        </div>

        <div class="card mt-3 border-0 pb-2 shadow-sm">
            <div class="table-responsive">
                <table id="enquiry-table" class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Mobile No</th>
                        <th>Email</th>
                        <th>Message</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@push('js')
    <script type="module">
        $(function () {
            var table = $('#enquiry-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('enquiry.index') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'full_name', name: 'full_name'},
                    {data: 'mobile_no', name: 'mobile_no'},
                    {data: 'email', name: 'email'},
                    {data: 'message', name: 'message'},
                ],
            });
        });
    </script>
@endpush
