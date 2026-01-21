@extends('admin-panel.layouts.app')

@section('content')

    <div class="px-3">
        <div class="d-flex flex-wrap align-items-center justify-content-between">
            <h5 class="fw-semibold">Job Accepted/Declined Report</h5>

            <div>
                <!-- Filter Button -->
                <button class="btn btn-light shadow-sm" type="button" data-bs-toggle="collapse" data-bs-target="#filterSection" aria-expanded="false" aria-controls="filterSection">
                    <i class="bi bi-funnel"></i>
                </button>

                <!-- Export Button -->
                <a href="{{ route('job-accepted-declined.export') }}" class="btn btn-light shadow-sm">
                    <i class="bi bi-box-arrow-up"></i> Export
                </a>
            </div>

        </div>

        @include('admin-panel.reports.job-accepted-declined.partials._filters')

        <div class="card mt-3 border-0 pb-2 shadow-sm">
            <div class="table-responsive">
                <table id="job-accepted-declined-table" class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Particular</th>
                        <th>Job Accepted</th>
                        <th>In Progress</th>
                        <th>Completed</th>
                        <th>Declined</th>
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

            var table = $('#job-accepted-declined-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('job-accepted-declined.index') }}', // Backend script to fetch data
                    type: 'GET',
                    data: function (d) {
                        d.company_name = $('#companyFilter').val();
                        d.name = $('#nameFilter').val();
                        d.contact_number = $('#contactNumberFilter').val();
                        d.location = $('#locationFilter').val();
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'name',name: 'name'},
                    {data: 'accepted',name: 'accepted'},
                    {data: 'in_progress',name: 'in_progress'},
                    {data: 'completed',name: 'completed'},
                    {data: 'declined',name: 'declined'},
                ],
            });

            // Apply Filters
            $('#applyFilters').on('click', function () {
                table.ajax.reload(); // Reload table data with new filters
            });

            // Reset Filters
            $('#resetFilters').on('click', function () {
                $('#filterForm')[0].reset(); // Reset the form inputs
                $('#companyFilter').val('').trigger('change');
                $('#nameFilter').val('').trigger('change');
                $('#contactNumberFilter').val('').trigger('change');
                table.ajax.reload(); // Reload table data without filters
            });

        });
    </script>
@endpush
