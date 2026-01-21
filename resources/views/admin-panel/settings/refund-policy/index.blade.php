@extends('admin-panel.layouts.setting-app')

@section('content')

    <div class="px-3">
        <div class="d-flex align-items-center justify-content-between">
            <h4 class="fw-semibold">Page <i class="bi bi-chevron-right"></i> Refund Policy</h4>
        </div>
    </div>

   @include('admin-panel.settings.refund-policy._form')

@endsection

@push('js')
    <script type="module">
        $(function () {

            //Store
            $('#refundPolicySettingForm').on('submit', function (e) {
                e.preventDefault();
                // Get the Quill editor instance
                var quill = new Quill('#editor');

                // Get the Quill editor content as HTML
                const content = quill.root.innerHTML;

                // Set the Quill content in a hidden input field
                document.getElementById('editor-content').value = content;
                var data = new FormData($('#refundPolicySettingForm')[0]);

                $.easyAjax({
                    url: "{{ route('settings.storeOrUpdate') }}",
                    container: '#refundPolicySettingForm',
                    type: "POST",
                    disableButton: true,
                    blockUI: true,
                    data: data,
                    file: true,
                    onComplete: () => {

                    }
                })

            });

        });
    </script>
@endpush
