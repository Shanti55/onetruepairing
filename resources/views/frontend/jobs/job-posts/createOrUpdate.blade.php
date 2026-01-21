@extends('frontend.layouts.app')

@section('title', 'Job Posts | Ctrl F')

@section('content')
    <div class="container-fluid p-0 m-0">
        <main class="main">


            <!-- Bread Crumb -->

            <!-- Details Section -->
            <section id="details" class="details section bg-light">

                <!-- Section Title -->
                <div class="container section-title" data-aos="fade-up">
                    <div class="d-flex flex-sm-row flex-column justify-content-between align-items-center mb-5">
                        <div>
                            <h2>Details</h2>
                            <div><span>Post Your</span> <span class="description-title">Job</span></div>
                        </div>
                        @if(auth()->check() && auth()->user()->isUser())
                        <div>
                            <a href="{{ route('users.jobs.index') }}" class="btn text-decoration-none border-0">
                                <h5 class="text-common-blue fw-bold"><i class="bi bi-arrow-right-circle"></i> View My Job</h5>
                            </a>
                        </div>
                        @endif
                </div><!-- End Section Title -->
                <div class="container px-0 ">
                    <div class="row gy-4 align-items-center justify-content-center features-item">

                        <div class="card border-0 shadow w-100">
                            <form id="jobPostForm" class="form-horizontal">
                                    <div class="card-body py-3 py-md-5 p-0 p-md-3">
                                        <input type="hidden" name="id" id="id">
                                        <div class="form-group mb-3">
                                            <div class="col-sm-12 px-0 px-md-3">
                                                <label for="title" class="form-label"><h6 class="fw-bold mb-0 required">Job Title</h6></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="title" name="title"
                                                           placeholder="Enter Title" required>
                                                    <button type="button" class="btn btn-outline-secondary mic-btn" data-target="title">
                                                         <i class="bi bi-mic-fill"></i>
                                                    </button>
                                                </div>
                                                <div class="invalid-feedback">Invalid feedback</div>
                                            </div>
                                        </div>

                                        <div class="form-group mb-3">
                                            <div class="col-sm-12 px-0 px-md-3">
                                                <label for="location" class="form-label"><h6 class="fw-bold mb-0 required">Location</h6></label>

                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="location" name="location"
                                                           placeholder="Enter Location"
                                                           value="" required>
                                                    <button type="button" class="btn btn-outline-secondary mic-btn" data-target="location"> <i class="bi bi-mic-fill"></i></button>
                                                </div>

                                                <div class="invalid-feedback">Invalid feedback</div>
                                            </div>
                                        </div>

                                        <div class="row ">
                                            <div class="col-lg-4 px-0 px-md-3">
                                                <div class="form-group mb-3">
                                                    <label for="pin_code" class="form-label"><h6 class="fw-bold mb-0 required">Pin Code <small class="fw-normal">[ 6-Digit Required ]</small></h6></label>
                                                    <div class="input-group mb-3">

                                                        <input type="number" min="100000" class="form-control" id="pin_code" name="pin_code"
                                                               placeholder="Enter Pin Code"
                                                               value="" required>
                                                        <button type="button" class="btn btn-outline-secondary mic-btn" data-target="pin_code"> <i class="bi bi-mic-fill"></i></button>


                                                        <div class="invalid-feedback">Invalid feedback</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 px-0 px-md-3">
                                                <div class="form-group mb-3">
                                                    <label for="area" class="form-label"><h6 class="fw-bold mb-0 required">Area <small class="fw-normal"></small></h6></label>
                                                    <div class="input-group mb-3">
                                                        <select class="form-control" id="area" name="area" required>
                                                            <option value="">Select Area</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 px-0 px-md-3">
                                                <div class="form-group mb-3">
                                                    <label for="city" class="form-label"><h6 class="fw-bold mb-0 required">City <small class="fw-normal">[ auto fetch on pincode ]</small></h6></label>
                                                    <div class="input-group mb-3">
                                                        <input type="text" class="form-control" id="city" name="city"
                                                               placeholder="City"
                                                               value="" readonly>
                                                        <div class="invalid-feedback">Invalid feedback</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 px-0 px-md-3">
                                                <div class="form-group mb-3">
                                                    <label for="region" class="form-label"><h6 class="fw-bold mb-0 required">Region <small class="fw-normal"></small></h6></label>
                                                    <div class="input-group mb-3">
                                                        <input type="text" class="form-control" id="region" name="region"
                                                               placeholder="Region"
                                                               value="" readonly>
                                                        <div class="invalid-feedback">Invalid feedback</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 px-0 px-md-3">
                                                <div class="form-group mb-3">
                                                    <label for="state" class="form-label"><h6 class="fw-bold mb-0 required">State <small class="fw-normal">[ auto fetch on pincode ]</small></h6></label>
                                                    <div class="input-group mb-3">
                                                        <input type="text" class="form-control" id="state" name="state"
                                                               placeholder="State"
                                                               value="" readonly>
                                                        <div class="invalid-feedback">Invalid feedback</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group mb-3">
                                            <div class="col-lg-12 px-0 px-md-3">
                                                <label for="categories" class="form-label"><h6 class="fw-bold mb-0 required">Job Category</h6></label>
                                                <select class="form-control form-select" id="categories" name="categories[]"
                                                        placeholder="Choose Category" multiple required>
                                                    <option value="">--Choose Category--</option>
                                                    @foreach($categories as $category)
                                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">Invalid feedback</div>
                                            </div>
                                        </div>

                                        <div class="form-group mb-3">
                                            <div class="col-sm-12 px-0 px-md-3">
                                                <label for="cost" class="form-label fw-bold"><h6 class="fw-bold mb-0">Approx Budget(Rs.)</h6></label>

                                                <input type="number" step="any" min="0" class="form-control" id="cost" name="cost"
                                                       placeholder="Enter Cost Eg : 50000"
                                                       value="0">
                                                <button type="button" class="btn btn-outline-secondary mic-btn" data-target="cost"> <i class="bi bi-mic-fill"></i></button>



                                                <div class="invalid-feedback">Invalid feedback</div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col-sm-6 mb-3 px-0 px-md-3">
                                                <label for="duration_type" class="form-label"><h6 class="fw-bold mb-0">Duration Type</h6></label>
                                                <div class="">
                                                    <select class="form-control form-select" id="duration_type" name="duration_type"
                                                            placeholder="Choose Duration Type">
                                                        <option value="hours">Hours</option>
                                                        <option value="days">Days</option>
                                                        <option value="months">Months</option>
                                                    </select>
                                                    <div class="invalid-feedback">Invalid feedback</div>
                                                </div>
                                            </div>

                                            <div class="form-group col-sm-6 mb-3 px-0 px-md-3">
                                                <label for="duration_value" class="form-label"><h6 class="fw-bold mb-0">Duration Value</h6></label>
                                                <div class="input-group">
                                                    <input type="number" step="any" class="form-control" id="duration_value" name="duration_value"
                                                           placeholder="Enter Duration Eg : 5"
                                                           value="">
                                                    <button type="button" class="btn btn-outline-secondary mic-btn" data-target="duration_value"> <i class="bi bi-mic-fill"></i></button>



                                                    <div class="invalid-feedback">Invalid feedback</div>
                                                </div>
                                            </div>
                                        </div>

                                            <div class="form-group mb-3 fw-bold">
                                            <div class="col-sm-12 px-0 px-md-3">
                                                <label for="description" class="form-label"><h6 class="fw-bold mb-0">Description</h6></label>
                                                <div class="input-group mb-3">
                                                <textarea class="form-control" id="description" rows="3" name="description"></textarea>
                                                <button type="button" class="btn btn-outline-secondary mic-btn" data-target="description"> <i class="bi bi-mic-fill"></i></button>
                                                <div class="invalid-feedback">Invalid feedback</div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="card-footer bg-white d-flex justify-content-end py-3 border-0">
                                        <button type="submit" class="cu-btn border-0 mb-2" id="save">Save
                                        </button>
                                    </div>
                                </form>
                        </div>

                    </div>
                </div>
                </div>
            </section>

        </main>
    </div>
@endsection

@push('js')
    <script type="module">
        $(function () {

            // Speech recognition setup
            const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;

            if (!SpeechRecognition) {
                console.warn('Speech Recognition not supported');
                return;
            }

            const recognition = new SpeechRecognition();
            recognition.continuous = false;
            recognition.interimResults = false;
            recognition.lang = 'en-IN';

            let currentInput = null;

            document.querySelectorAll('.mic-btn').forEach(button => {
                button.addEventListener('click', () => {
                    const inputId = button.getAttribute('data-target');
                    currentInput = document.getElementById(inputId);
                    recognition.start();
                });
            });

            let lastTranscript = "";
            recognition.onresult = function (event) {
                const transcript = event.results[0][0].transcript;
                if (transcript !== lastTranscript) {
                    if (currentInput) {
                        typeText(currentInput, transcript);
                    }
                    lastTranscript = transcript;
                }
            };



            function typeText(inputElement, text, index = 0) {
                if (index < text.length) {
                    inputElement.value += text.charAt(index);
                    setTimeout(() => typeText(inputElement, text, index + 1), 50);
                }
            }

            recognition.onerror = function (event) {
                console.error('Speech recognition error', event);
            };


            $('#jobPostForm').on('submit', function (e) {
                e.preventDefault();

                var data = new FormData($('#jobPostForm')[0]);

                $.easyAjax({
                    url: "{{ route('frontend.job-posts.storeOrUpdate') }}",
                    container: '#jobPostForm',
                    type: "POST",
                    disableButton: true,
                    blockUI: true,
                    data: data,
                    onComplete: () => {
                        $('#jobPostForm').trigger("reset");
                    }
                })

            });

            // Function to fetch city and state from pincode
            async function getCityAndState(pincode) {
                try {
                    if (!pincode || pincode.length < 6) return;

                    // Fetch data from the API
                    const response = await fetch(`/get-pincode/${pincode}`);
                    const data = await response.json();

                    if (data[0].Status === "Success") {
                        const postOffices = data[0].PostOffice;

                        // Get the select dropdown and clear previous options
                        let areaSelect = document.getElementById('area');
                        areaSelect.innerHTML = '<option value="">Select Area</option>';

                        // Populate select options with post office names
                        postOffices.forEach(postOffice => {
                            let option = document.createElement("option");
                            option.value = postOffice.Name;
                            option.textContent = postOffice.Name;
                            areaSelect.appendChild(option);
                        });

                        // Auto-fill city, region, and state based on the first entry
                        if (postOffices.length > 0) {
                            document.getElementById('city').value = postOffices[0].Division;
                            document.getElementById('region').value = postOffices[0].Region;
                            document.getElementById('state').value = postOffices[0].State;
                        }
                    } else {
                        clearFields();
                    }
                } catch (error) {
                    console.error('Error fetching data:', error);
                    clearFields();
                }
            }

            // Function to clear fields on error or invalid pincode
            function clearFields() {
                document.getElementById('area').innerHTML = '<option value="">Invalid Pincode</option>';
                document.getElementById('city').value = "Invalid Pincode";
                document.getElementById('region').value = "Invalid Pincode";
                document.getElementById('state').value = "Invalid Pincode";
            }

            // Event listener for pincode input field
            document.getElementById('pin_code').addEventListener('keyup', function () {
                getCityAndState(this.value);
            });

            // Event listener for area selection to update city, region, and state
            document.getElementById('area').addEventListener('change', function () {
                const selectedArea = this.value;
                if (selectedArea) {
                    fetch(`https://api.postalpincode.in/pincode/${document.getElementById('pin_code').value}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data[0].Status === "Success") {
                                const selectedPostOffice = data[0].PostOffice.find(po => po.Name === selectedArea);
                                if (selectedPostOffice) {
                                    document.getElementById('city').value = selectedPostOffice.Division;
                                    document.getElementById('region').value = selectedPostOffice.Region;
                                    document.getElementById('state').value = selectedPostOffice.State;
                                }
                            }
                        });
                }
            });
        });
    </script>
@endpush
