<div>
    <div class="input-group w-50">
        <input type="text" id="referralCode{{ $admin->id }}" class="form-control text-center fw-bold border-0 bg-light" value="{{ $admin->referral_code }}" readonly>
        <button class="btn btn-light copy-btn" onclick="copyReferralCode({{ $admin->id }})"><i class="bi bi-copy"></i></button>
    </div>

    <div id="copySuccess{{ $admin->id }}" class="py-1 d-none" role="alert">
        Copied to clipboard!
    </div>
</div>

    <script>
        function copyReferralCode(adminId) {
                var copyText = document.getElementById("referralCode" + adminId);
                copyText.select();
                copyText.setSelectionRange(0, 99999);
                navigator.clipboard.writeText(copyText.value);

                let successMsg = document.getElementById("copySuccess" + adminId);
                successMsg.classList.remove("d-none");

                setTimeout(() => {
                    successMsg.classList.add("d-none");
                }, 2000);
            }
    </script>
