<div>
    @if(isset($payment->attachment))
        @php
            $fileType = checkFileType($payment->attachment);
        @endphp
        @if(isset($fileType))
            <a href="{{ $payment->attachment }}" target="_blank" class="badge soft-light btn-sm" title="Attachment"><i class="bi bi-link-45deg"></i> View Attachment</a>
        @endif
    @endif
</div>
