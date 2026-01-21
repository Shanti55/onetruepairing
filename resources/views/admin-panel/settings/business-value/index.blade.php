@extends('admin-panel.layouts.setting-app')

@section('content')

    <div class="px-3">
        <div class="d-flex align-items-center justify-content-between">
            <h5 class="fw-semibold">Manage Business Values</h5>

            <a href="#" data-bs-toggle="#businessValuesModal" id="add-business-values-btn"
               class="btn btn-primary shadow-sm">
                <i class="fas fa-add me-1"></i> Add
            </a>
        </div>

        <div class="card mt-3 border-0 pb-2 shadow-sm">
            <div class="table-responsive">
                <table id="business-values-table" class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>

        @include('admin-panel.settings.business-value._form')

    </div>

@endsection

@push('js')
    <script type="module">
        $(function () {
            var table = $('#business-values-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('business-values.index') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'title', name: 'title'},
                    {data: 'description', name: 'description'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
            });

            $('#add-business-values-btn').click(function () {
                console.log('here');
                $('#id').val('');
                $('#businessValuesForm').trigger("reset");
                $('#modelHeading').html("Create New");
                $('#businessValuesModal').modal('show');
            });

            $('#businessValuesForm').on('submit', function (e) {
                e.preventDefault();
                var data = new FormData($('#businessValuesForm')[0]);
                $.easyAjax({
                    url: "{{ route('business-values.storeOrUpdate') }}",
                    container: '#businessValuesForm',
                    type: "POST",
                    disableButton: true,
                    blockUI: true,
                    data: data,
                    file: true,
                    onComplete: () => {
                        $('#businessValuesModal').modal('hide');
                        $('#modelHeading').html("Create New Ads");
                        $('#businessValuesForm').trigger("reset");
                        $('#previewAd').html('');
                        table.draw(false);
                    }
                })

            });

            $('body').on('click', '.editValue', function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                axios.get(route('business-values.edit', {value: id})).then((response) => {
                    $('#modelHeading').html("Edit");
                    $('#businessValuesModal').modal('show');
                    var form = $('#businessValuesForm'); // Adjust the form ID as needed
                    $.each(response.data, function (key, value) {
                        var inputField = form.find('[name="' + key + '"]');
                        if (inputField.length) {
                            inputField.val(value);
                            $(inputField).trigger('change')
                        }
                    });

                });
            });

            $('body').on('click', '.deleteValue', function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                $.easyDelete({
                    url: route('business-values.delete', {value: id}),
                    confirmationMessage: 'Do you really want to delete this value?',
                    onComplete: () => {
                        table.draw(false);
                    }
                })
            });



    });
    </script>
@endpush
