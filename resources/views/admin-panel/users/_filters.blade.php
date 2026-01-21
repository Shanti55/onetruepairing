<!-- Filters Section -->
<div class="collapse mt-3" id="filterSection">
    <div class="card card-body border-0 shadow-sm">
        <!-- Your filter options here -->
        <h5>Filters</h5>
        <form id="filterForm">
            <div class="d-flex flex-sm-row flex-column gap-2">
                <div class="mb-3 flex-fill">
                    <label for="nameFilter" class="form-label">Name</label>
                    <select class="form-select" id="nameFilter">
                        <option value="" selected>All...</option>
                        @foreach($usersList as $user)
                            <option value="{{ $user->name }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3 flex-fill">
                    <label for="contactNumberFilter" class="form-label">Contact Number</label>
                    <select class="form-select" id="contactNumberFilter">
                        <option value="" selected>All...</option>
                        @foreach($usersList as $user)
                            @if(isset($user->userprofile->contact_number))
                                <option value="{{ $user->userprofile->contact_number }}">{{ $user->userprofile->contact_number }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="mb-3 flex-fill">
                    <label for="locationFilter" class="form-label">Pincode/City/State</label>
                    <div class="search">
                        <input type="text" class="form-control" placeholder="Enter Pincode/City/State" id="locationFilter" name="location" autocomplete="off" value="{{ request()->has('locationFilter') ? request('locationFilter') : null }}">
                    </div>
                    <div class="card mt-2 p-3 lh-1 rounded-2 position-absolute shadow text-start" id="suggestions" style="display: none;z-index: 1;cursor: pointer"></div>
                </div>
            </div>
            <div class="mt-3">
                <button type="button" id="applyFilters" class="btn btn-primary">Apply Filters</button>
                <button type="button" id="resetFilters" class="btn btn-secondary">Reset Filters</button>
            </div>
        </form>
    </div>
</div>
@push('js')
    <script type="module">
        $(function () {
            const input = document.getElementById('locationFilter');
            const suggestions = document.getElementById('suggestions');
            $('#locationFilter').on('input', async function (e) {
                e.preventDefault();
                const query = input.value;
                if (query.length > 2) {
                    const response = await fetch(`https://api.mapbox.com/geocoding/v5/mapbox.places/${encodeURIComponent(query)}.json?country=IN&access_token={{ env('MAPBOX_TOKEN') }}`);
                    const data = await response.json();
                    suggestions.innerHTML = '';
                    suggestions.style.display = 'none';

                    if (data.features.length > 0) {
                        data.features.forEach(feature => {
                            const div = document.createElement('div');
                            div.textContent = feature.place_name;
                            div.classList.add('suggestion-item', 'lh-1', 'text-secondary', 'mb-3', 'cu-font-family', 'pointer');
                            div.addEventListener('click', function () {
                                input.value = feature.place_name;
                                suggestions.innerHTML = '';
                                suggestions.style.display = 'none';
                            });

                            suggestions.appendChild(div);
                        });
                        suggestions.style.display = 'block';
                    }
                } else {
                    suggestions.innerHTML = '';
                    suggestions.style.display = 'none';
                }
            });
        });
    </script>
@endpush
