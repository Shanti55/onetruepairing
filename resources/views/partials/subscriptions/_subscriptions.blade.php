<div class="card border-0  mt-3 pb-2 shadow-sm">
    <div class="card-header bg-white border-0 pt-3 d-flex justify-content-between " style="border-radius: 0px;">
        <h4><i class="bi bi-bag"></i> Subscriptions</h4>
        @if(auth()->user()->isAdmin())
        <a href="javascript:void(0)" data-bs-toggle="#subscribeModal" id="add-plan-btn" class="btn btn-primary shadow-sm">
            <i class="fas fa-add me-1"></i> Choose Plan
        </a>
        @endif
    </div>

    @php
        $subscriptions = \App\Models\UserSubscription::where('user_id',$provider->id)->with('plan')->latest()->get();
    @endphp
    <div class="card-body table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>Plan</th>
                <th>Billing Cycle</th>
                <th>Start On</th>
                <th>Expire On</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>
            @if(count($subscriptions) > 0)
                @foreach($subscriptions as $index=>$subscription)
                    <tr>
                        <td>{{ $index+1 }}</td>
                        <td>{{ $subscription->plan->name }}<br>
                            <div class="">
                                <span class="badge soft-warning align-middle"  style="cursor: pointer"  data-bs-toggle="collapse" data-bs-target="#collapseExample_{{ $subscription->id }}"><i class="bi bi-info-circle me-1"></i>Show Features</span>
                            </div>
                            @if(isset($subscription->features))
                                <div class="collapse" id="collapseExample_{{ $subscription->id }}">
                                    <div class="card card-body border-0 mt-1 shadow-sm">
                                        <div>
                                            @php
                                                $features = json_decode($subscription->features);
                                            @endphp
                                            @if(isset($features))
                                                <div class="d-flex flex-wrap gap-1">
                                                    @foreach($features as $feature)
                                                        <span class="badge soft-light"><i class="bi bi-check-circle-fill text-success"></i> {{ ucfirst(str_replace('_', ' ', $feature)) }}</span>
                                                    @endforeach
                                                </div>
                                            @else
                                                <span class="badge soft-light"><i class="bi bi-x-circle-fill text-danger"></i> No Features</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </td>
                        <td>{{ ucfirst($subscription->billing_cycle) }}</td>
                        <td>{{ $subscription->start_date }}</td>
                        <td>{{ $subscription->end_date }}</td>
                        <td>
                            @if(\Carbon\Carbon::parse($subscription->end_date)->lt(\Carbon\Carbon::today()))
                                <span class="badge bg-danger ms-1">Expired</span>
                            @else
                                <span class="badge {{ $subscription->status->color() }}" aria-expanded="false">
                                {{ ucwords(str_replace('_',' ',$subscription->status->value)) }}
                             </span>
                            @endif

                        </td>
                    </tr>

                @endforeach
            @else
                <tr>
                    <td colspan="100%">No Subscription Found</td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
    @include('partials.subscriptions.partials._subscribe-modal')
</div>
@push('js')
    <script type="module">
        $(function () {

            $('#add-plan-btn').click(function () {
                $('#id').val('');
                $('#subscribeForm').trigger("reset");
                $('#modelHeading').html("Choose New Plan");
                $('#subscribeModal').modal('show');
            });

            $('#subscribeForm').on('submit', function (e) {
                e.preventDefault();

                var data = new FormData($('#subscribeForm')[0]);

                $.easyAjax({
                    url: "{{ route('subscriptions.purchase') }}",
                    container: '#subscribeForm',
                    type: "POST",
                    disableButton: true,
                    blockUI: true,
                    data: data,
                    onComplete: () => {
                        $('#subscribeModal').modal('hide');
                        $('#modelHeading').html("Choose New Plan");
                        $('#subscribeForm').trigger("reset");
                        window.location.reload();
                    }
                })

            });

            $('body').on('click', '.editAdmin', function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                axios.get(route('admins.edit', {admin: id})).then((response) => {
                    $('#modelHeading').html("Edit Admin");
                    $('#adminModal').modal('show');

                    var form = $('#adminForm'); // Adjust the form ID as needed

                    $.each(response.data, function (key, value) {
                        var inputField = form.find('[name="' + key + '"]'); // Scope to form

                        if (inputField.length) {
                            inputField.val(value);
                            $(inputField).trigger('change')
                        }
                    });

                });
            });

            $('body').on('click', '.deleteAdmin', function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                $.easyDelete({
                    url: route('admins.delete', {admin: id}),
                    confirmationMessage: 'Do you really want to delete this admin?',
                    onComplete: () => {
                        table.draw(false);
                    }
                })
            });

        });
    </script>
@endpush
