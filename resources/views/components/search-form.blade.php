@props(['uniqueId'])
<div>
    <form action="{{ route('frontend.browse-listings.index') }}" method="GET" class="form-horizontal">
        <div class="row">
            <div class="col-lg-6 m-0 p-0 mb-2">
                <div class="search">
                    <i class="bi bi-geo-alt text-secondary"></i>
                    <input type="text" class="form-control rounded-0 rounded-start-5 search-radius" placeholder="Enter Pincode/City/State" id="search{{ $uniqueId }}" name="location" autocomplete="off" value="{{ request()->has('location') ? request('location') : null }}" style="padding-right: 0px!important;">
                    <!-- Clear Button (Initially Hidden) -->
                    <button class="btn border-0 p-0 button-clear position-absolute end-0 me-2"
                            type="button" id="clearSearch{{ $uniqueId }}" style="display: none;right: 0!important;">
                        <i class="bi bi-x text-secondary"></i>
                    </button>
                </div>
                <div class="card mt-2 p-3 lh-1 rounded-2 position-absolute shadow text-start" id="suggestions{{ $uniqueId }}" style="display: none;"></div>
            </div>
            <div class="col-lg-6 m-0 p-0">
                <div class="search">
                    <i class="bi bi-ui-checks-grid text-secondary"></i>
                    <input type="text" class="form-control rounded-0 rounded-end-5 border-start-0 search-radius" placeholder="Search for Category, Service Provider" id="searchCategory{{ $uniqueId }}" name="category" autocomplete="off" value="{{ request()->has('category') ? request('category') : null }}">
                    <button class="btn border-0 p-0 button-voice" type="button" id="start-record{{ $uniqueId }}"><i class="bi bi-mic text-secondary"></i></button>
                    <!-- Clear Button (Initially Hidden) -->
                    <button class="btn border-0 p-0 button-clear position-absolute end-0 me-2"
                            type="button" id="clearCategory{{ $uniqueId }}" style="display: none;">
                        <i class="bi bi-x text-secondary"></i>
                    </button>
                    <button class="btn border-0 p-0 button-search btn-primary rounded-5" type="submit" title="Search"><i class="bi bi-search text-white"></i></button>
                </div>
                <div class="card mt-2 p-3 lh-1 rounded-2 shadow" id="suggestionsCategory{{ $uniqueId }}" style="display: none;"></div>
                <h6 class="mt-2 text-start" id="result{{ $uniqueId }}"></h6>
            </div>
        </div>
    </form>

    @push('js')
        <script type="module">
            $(function () {
                const inputSearch = document.getElementById('search{{$uniqueId}}');
                const suggestions = document.getElementById('suggestions{{$uniqueId}}');

                // Buttons
                const clearSearch = $('#clearSearch{{ $uniqueId }}');

                $('#search{{$uniqueId}}').on('input', async function (e) {
                    e.preventDefault();
                    const query = inputSearch.value;
                    if (query.length > 2) {
                        const response = await fetch(`https://api.mapbox.com/geocoding/v5/mapbox.places/${encodeURIComponent(query)}.json?country=IN&access_token={{ env('MAPBOX_TOKEN') }}`);
                        const data = await response.json();
                        suggestions.innerHTML = '';
                        suggestions.style.display = 'none';
                        clearSearch.show();

                        if (data.features.length > 0) {
                            data.features.forEach(feature => {
                                const div = document.createElement('div');
                                div.textContent = feature.place_name;
                                div.classList.add('suggestion-item', 'lh-1', 'text-dark', 'mb-3',
                                    'cu-font-family', 'pointer', 'd-flex', 'align-items-center','fw-semibold','text-start');
                                div.addEventListener('click', function () {
                                    inputSearch.value = feature.place_name;
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
                        clearSearch.hide();
                    }
                });

                // Clear Search Input
                $(clearSearch).on('click', function () {
                    suggestions.innerHTML = '';
                    suggestions.style.display = 'none';
                    inputSearch.value = '';
                    clearSearch.hide();
                });


                const inputCategory = document.getElementById('searchCategory{{$uniqueId}}');
                const suggestionsCategory = document.getElementById('suggestionsCategory{{$uniqueId}}');
                const clearCategory = $('#clearCategory{{ $uniqueId }}');
                const micCategory = $('#start-record{{ $uniqueId }}');

                $('#searchCategory{{$uniqueId}}').on('input', async function (e) {
                    e.preventDefault();
                    const query = inputCategory.value;
                    if (query.length > 2) {
                        clearCategory.show();
                        micCategory.hide();
                        const response = await axios.get(route('categories.data', {category: query}));
                        suggestionsCategory.innerHTML = '';
                        suggestionsCategory.style.display = 'none';

                        if (response.data.results.length > 0) {
                            response.data.results.forEach(result => {
                                const div = document.createElement('div');
                                div.classList.add(
                                    'suggestion-item', 'lh-1', 'text-dark', 'mb-3',
                                    'cu-font-family', 'pointer', 'd-flex', 'align-items-center','text-start'
                                );

                                // Create an icon element
                                const icon = document.createElement('i');

                                if (result.type === 'Service Provider') {
                                    icon.classList.add('bi', 'bi-building', 'me-2'); // Bootstrap person icon
                                } else if (result.type === 'Category') {
                                    icon.classList.add('bi', 'bi-tag', 'me-2'); // Bootstrap tag icon for categories
                                }

                                icon.style.fontSize = '1rem'; // Adjust icon size

                                // Create a title element
                                const title = document.createElement('div');
                                title.textContent = result.name;
                                title.classList.add('fw-semibold'); // Optional: Make the title bold

                                // Create a subtitle element
                                const subtitle = document.createElement('div');
                                subtitle.textContent = result.type;
                                subtitle.classList.add('text-muted', 'small'); // Optional: Style the subtitle

                                // Wrap title and subtitle in a div
                                const textWrapper = document.createElement('div');
                                textWrapper.appendChild(title);
                                textWrapper.appendChild(subtitle);

                                // Append elements to the main div
                                div.appendChild(icon);
                                div.appendChild(textWrapper);

                                div.addEventListener('click', function () {
                                    inputCategory.value = result.name;
                                    suggestionsCategory.innerHTML = '';
                                    suggestionsCategory.style.display = 'none';
                                });

                                suggestionsCategory.appendChild(div);
                            });

                            suggestionsCategory.style.display = 'block';
                        }


                    } else {
                        suggestionsCategory.innerHTML = '';
                        suggestionsCategory.style.display = 'none';
                        micCategory.show();
                        clearCategory.hide();
                    }
                });


                // Clear Category Input
                clearCategory.on('click', function () {
                    suggestionsCategory.innerHTML = '';
                    suggestionsCategory.style.display = 'none';
                    inputCategory.value='';
                    micCategory.show();
                    clearCategory.hide();
                });

                //Voice Search
                document.getElementById('start-record{{ $uniqueId }}').addEventListener('click', () => {
                    const recognition = new (window.SpeechRecognition || window.webkitSpeechRecognition)();
                    recognition.lang = 'en-US'; // Set language
                    recognition.interimResults = false;
                    recognition.start();

                    recognition.onresult = (event) => {
                        const searchQuery = event.results[0][0].transcript;
                        document.getElementById('result{{ $uniqueId }}').innerText = `You said: "${searchQuery}"`;
                        inputCategory.value = searchQuery;
                    };

                    recognition.onerror = (event) => {
                        console.error('Speech recognition error:', event.error);
                    };
                });

            });
        </script>
    @endpush

</div>
