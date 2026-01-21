@props(['profile','size','weight','icon'])
<div class="col-lg-{{ $size }}">
    <div class="form-group mb-3">
        <label for="pin_code" class="form-label fw-{{ $weight }} required">Pin Code <span class="fw-normal">[ 6-Digit Required ]</span></label>
        <div class="input-group mb-3">
            @if($icon == 1)
                <span class="input-group-text"><i class="bi bi-geo-alt text-secondary"></i></span>
            @endif
            <input type="number" min="100000" class="form-control" id="pin_code" name="pin_code"
                   placeholder="Enter Pin Code"
                   value="{{ $profile ? $profile->pin_code : null }}" required>
            <div class="invalid-feedback">Invalid feedback</div>
        </div>
    </div>
</div>

<div class="col-lg-{{ $size }}">
    <div class="form-group mb-3">
        <label for="city" class="form-label fw-{{ $weight }} required" >Area</label>
        <div class="input-group mb-3">
            @if($icon == 1)
                <span class="input-group-text"><i class="bi bi-geo-alt text-secondary"></i></span>
            @endif
            <select class="form-control" id="area" name="area" required>
                <option value="{{ $profile ? $profile->area : null }}">{{ $profile ? $profile->area : 'Select Area' }}</option>
            </select>
        </div>
    </div>
</div>

<div class="col-lg-{{ $size }}">
    <div class="form-group mb-3">
        <label for="city" class="form-label fw-{{ $weight }}">City</label>
        <div class="input-group mb-3">
            @if($icon == 1)
                <span class="input-group-text"><i class="bi bi-geo-alt text-secondary"></i></span>
            @endif
            <input type="text" class="form-control" id="city" name="city"
                   placeholder="Enter City"
                   value="{{ $profile ? $profile->city : null }}" readonly>
            <div class="invalid-feedback">Invalid feedback</div>
        </div>
    </div>
</div>
<div class="col-lg-{{ $size }}">
    <div class="form-group mb-3">
        <label for="region" class="form-label fw-{{ $weight }}">Region</label>
        <div class="input-group mb-3">
            @if($icon == 1)
                <span class="input-group-text"><i class="bi bi-geo-alt text-secondary"></i></span>
            @endif
            <input type="text" class="form-control" id="region" name="region"
                   placeholder="Enter Region"
                   value="{{ $profile ? $profile->region : null }}" readonly>
            <div class="invalid-feedback">Invalid feedback</div>
        </div>
    </div>
</div>

<div class="col-lg-{{ $size }}">
    <div class="form-group mb-3">
        <label for="state" class="form-label fw-{{ $weight }}">State</label>
        <div class="input-group mb-3">
            @if($icon == 1)
                <span class="input-group-text"><i class="bi bi-geo-alt text-secondary"></i></span>
            @endif
            <input type="text" class="form-control" id="state" name="state"
                   placeholder="Enter State"
                   value="{{ $profile ? $profile->state : null }}" readonly>
            <div class="invalid-feedback">Invalid feedback</div>
        </div>
    </div>
</div>

@push('js')
    <script type="module">
        $(function () {

            // Function to fetch city and state from pincode
            async function getCityAndState(pincode) {
                try {
                    if (!pincode || pincode.length < 6) return;

                    // Fetch data from the API
                    const response = await fetch(`/get-pincode/${pincode}`);
                    const data = await response.json();
                    //
                    // const response = await fetch(`https://api.postalpincode.in/pincode/${pincode}`);
                    // const data = await response.json();

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

