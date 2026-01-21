@extends('service-provider-panel.layouts.app')

@section('content')

    {{--Overview Section--}}
    <div id="overview" class="px-3 tab-pane active">
        <br>
        <div class="row">

            <div class="col-lg-8">
                <div class="card border-0 shadow">
                    <div class="card-header border-0">
                        <h5 class="fw-semibold"><i class="bi bi-briefcase-fill"></i> Job Information</h5>
                    </div>
                    <div class="card-body">
                        @include('partials.job-posts._job-info')
                    </div>
                </div>

                <div class="card mt-3 border-0 shadow">
                    <div class="card-body">
                        <!-- char-area -->
                        @livewire('chat-component',['job'=>$job,'user_id'=>auth()->user()->id == $job->postedBy->id ? $job->assignedTo->id : $job->postedBy->id])
                        <!-- char-area -->
                    </div>
                </div>


            </div>

            <!--Job Progress-->

                <div class="col-lg-4">
                <div class="card border-0 shadow">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between">
                            <h5 class="text-dark"><i class="bi bi-sliders"></i> Progress</h5>
                            @if(auth()->user()->id != $job->posted_by)
                            <a href="#" data-bs-toggle="#progressModal" id="add-progress-btn"
                               class="btn btn-sm btn-primary shadow-sm" title="Add Progress">
                                <i class="bi bi-plus"></i>
                            </a>
                            @endif
                        </div>
                    </div>
                    <div class="card mt-3 border-0 pb-2">
                        <div class="table-responsive">
                            <table id="progress-table" class="table">
                                <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Completion(%)</th>
                                    @if(auth()->user()->isAdmin())
                                    <th>Action</th>
                                    @endif
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('service-provider-panel.job-posts.my-jobs.partials._progress-form')
    </div>

@endsection
@push('js')
    <script type="module">
        $(function () {

            var table = $('#progress-table').DataTable({
                paging: false,
                processing: true,
                serverSide: true,
                order: [[0, 'asc']],
                ajax: {
                    url : "{{ route('job-progress.index') }}",
                    data: function (d) {
                        d.job_id = {{ $job->id }};
                    }
                },
                columns: [
                    {data: 'date', name: 'date'},
                    {data: 'progress_value', name: 'progress_value'},
                    @if(auth()->user()->id != $job->posted_by)
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                    @endif
                ],
            });

            $('#add-progress-btn').click(function () {
                $('#id').val('');
                $('#progressForm').trigger("reset");
                $('#modelHeading').html("Add Progress");
                $('#progressModal').modal('show');
            });

            $('#progressForm').on('submit', function (e) {
                e.preventDefault();
                var data = new FormData($('#progressForm')[0]);
                $.easyAjax({
                    url: "{{ route('job-progress.storeOrUpdate') }}",
                    container: '#progressForm',
                    type: "POST",
                    disableButton: true,
                    blockUI: true,
                    data: data,
                    file: true,
                    onComplete: () => {
                        $('#progressModal').modal('hide');
                        $('#modelHeading').html("Add Progress");
                        $('#progressForm').trigger("reset");
                        table.draw(false);
                        window.location.reload();
                    }
                })

            });

            $('body').on('click', '.editJobProgress', function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                axios.get(route('job-progress.edit', {jobProgress: id})).then((response) => {
                    $('#modelHeading').html("Edit/Update Job Progress");
                    $('#progressModal').modal('show');

                    var form = $('#progressForm'); // Adjust the form ID as needed

                    $.each(response.data, function (key, value) {
                        console.log(key);
                        var inputField = form.find('[name="' + key + '"]'); // Scope to form
                        if (inputField.length) {
                            inputField.val(value);
                            $(inputField).trigger('change')
                        }
                    });

                });
            });

            $('body').on('click', '.deleteJobProgress', function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                $.easyDelete({
                    url: route('job-progress.delete', {jobProgress: id}),
                    confirmationMessage: 'Do you really want to delete this progress?',
                    onComplete: () => {
                        table.draw(false);
                    }
                })
            });

        });
    </script>
@endpush
