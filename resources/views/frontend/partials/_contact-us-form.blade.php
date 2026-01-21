<form  id="enquiryForm-1" class="php-email-form  p-3" data-aos="fade-up" data-aos-delay="200">
    <div class="text-center">
        <h3 class="text-primary"><b>LET'S TALK</b></h3>
        <span class="text-muted">Have a query or want to meet up for coffee.<br>
                                Contact us directly or fill out the form and<br>
                                we will get back to you.
                            </span>
    </div>
    <div class="gy-2 mt-3">
        <div class="mb-3">
            <lable><b>Full Name</b></lable>
            <span class="text-danger">*</span>
            <input type="text" name="full_name" class="form-control rounded-4 mt-2" placeholder="Full Name" required="">
        </div>

        <div class="mb-3">
            <lable><b>Mobile No</b></lable>
            <span class="text-danger">*</span>
            <input type="number" name="mobile_no" class="form-control rounded-4 mt-2" placeholder="Mobile No" required="">
        </div>

        <div class="mb-3">
            <lable><b>Email Id</b></lable>
            <span class="text-danger">*</span>
            <input type="email" name="email" class="form-control rounded-4 mt-2" placeholder="Email Id" required="">
        </div>

        <div class="mb-3">
            <lable><b>Message</b></lable>
            <span class="text-danger">*</span>
            <textarea type="text" name="message" class="form-control rounded-4 mt-2" placeholder="Message" required=""></textarea>
        </div>

        <div class="col-md-12 text-center">
            <div class="loading">Loading</div>
            <div class="error-message"></div>
            <div class="sent-message">Your message has been sent. Thank you!</div>

            <button type="submit" class="cu-btn rounded-4 border-0"><b>Submit</b></button>
        </div>
    </div>
</form>

@push('js')
    <script type="module">
        $(function () {
            $('#enquiryForm-1').on('submit', function (e) {
                e.preventDefault();
                var data = new FormData($('#enquiryForm-1')[0]);
                $.easyAjax({
                    url: "{{ route('frontend.enquiries.store') }}",
                    container: '#enquiryForm-1',
                    type: "POST",
                    disableButton: true,
                    blockUI: true,
                    data: data,
                    onComplete: () => {
                        $('#enquiryForm-1').trigger("reset");
                    }
                })
                Swal.fire({
                    title: '<strong style="color: blue;">Thank You</strong>',
                    html: '<div style="font-size: 1.2rem;">Your Request Has Been Submitted</div>',
                    showConfirmButton: false,
                    showCloseButton: true,
                });
            });
        });
    </script>
@endpush
