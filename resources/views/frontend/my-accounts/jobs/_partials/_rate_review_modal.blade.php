<!-- Modal -->
<div class="modal fade" id="rateReviewModal" tabindex="-1" aria-labelledby="rateReviewModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="ratingForm" class="form-horizontal">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rateReviewModalLabel">Rate & Review</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Star Rating -->
                <div class="mb-3">
                    <input type="hidden" name="job_id" value="{{ $job->id }}">
                    <input type="hidden" name="rating" id="rating">
                    <label class="form-label"><h6 class="fw-semibold">Your Rating:</h6></label>
                    <div id="starRating" class="d-flex justify-content-evenly">
                        <i class="bi bi-star-fill text-light" style="font-size: 56px; cursor: pointer;" data-value="1"></i>
                        <i class="bi bi-star-fill text-light" style="font-size: 56px; cursor: pointer;" data-value="2"></i>
                        <i class="bi bi-star-fill text-light" style="font-size: 56px; cursor: pointer;" data-value="3"></i>
                        <i class="bi bi-star-fill text-light" style="font-size: 56px; cursor: pointer;" data-value="4"></i>
                        <i class="bi bi-star-fill text-light" style="font-size: 56px; cursor: pointer;" data-value="5"></i>
                    </div>
                </div>

                <!-- Review Input -->
                <div class="mb-3">
                    <label for="reviewText" class="form-label "><h6 class="fw-semibold">Your Review:</h6></label>
                    <textarea class="form-control" id="reviewText" rows="4" placeholder="Write your review here..." name="review">{{ $job->review }}</textarea>
                </div>
            </div>
            <div class="modal-footer">
{{--                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>--}}
                <button type="submit" class="cu-btn border-0" id="submitReview">Submit</button>
            </div>
        </div>
        </form>
    </div>
</div>

@push('js')
    <script type="module">
        $(function () {
            let selectedRating = {{ isset($job->rating) ? $job->rating : 0 }};
            document.getElementById("rating").value = selectedRating;
            updateStarRating(selectedRating);
            // Handle star rating clicks
            document.querySelectorAll("#starRating i").forEach(star => {
                star.addEventListener("click", () => {
                    selectedRating = star.getAttribute("data-value");
                    document.getElementById("rating").value = selectedRating;
                    updateStarRating(selectedRating);
                });
            });

            // Update star appearance
            function updateStarRating(rating) {
                document.querySelectorAll("#starRating i").forEach(star => {
                    const value = star.getAttribute("data-value");
                    star.classList.toggle("text-warning", value <= rating); // Highlight selected stars
                    star.classList.toggle("text-light", value > rating); // Unhighlight unselected stars
                });
            }

            //Store Rating
            $('#ratingForm').on('submit', function (e) {
                e.preventDefault();
                var data = new FormData($('#ratingForm')[0]);
                $.easyAjax({
                    url: "{{ route('rate-review.storeOrUpdate') }}",
                    container: '#ratingForm',
                    type: "POST",
                    disableButton: true,
                    blockUI: true,
                    data: data,
                    onComplete: () => {
                        $('#rateReviewModal').modal('hide');
                        Swal.fire({
                            title: '<strong style="color: blue;">Thank You</strong>',
                            html: '<div style="font-size: 1.2rem;">Your Rating and Review has been Submitted</div>',
                            showConfirmButton: false,
                            showCloseButton: true,
                        });
                        setTimeout(() => {
                            window.location.reload();
                        }, 3000);
                    }
                })

            });

        });
    </script>


@endpush
