<!-- The Modal -->
<div class="modal fade" id="myFilter">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Filters</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form class="form-horizontal">
            <!-- Modal body -->
            <div class="modal-body">

                    <div class="row">
                        <div class="col-lg-12 mb-3">
                            <div class="form-group">
                                <label class="form-label"><h6 class="fw-semibold">Enter Pincode/City/State</h6></label>
                                <div class="search">
                                    <i class="bi bi-geo-alt text-secondary"></i>
                                    <input type="text" class="form-control rounded-0 rounded-4 search-radius" placeholder="Enter Pincode/City/State" id="filterSearch" name="location" autocomplete="off" value="{{ request()->has('location') ? request('location') : null }}" x-model="filters.location">
                                </div>
                                <div class="card mt-2 p-3 lh-1 rounded-2 position-absolute shadow" id="filterSuggestions" style="display: none;"></div>
                            </div>
                        </div>

                        <div class="col-lg-12 mb-3">
                            <div class="form-group">
                                <label class="form-label"><h6 class="fw-semibold">Sort By</h6></label>
                                <select class="form-control" id="sort_by" name="sort_by" placeholder="Sort By" @click="filterSortBy($event.detail)" x-model="filters.sort_by">
                                    <option value="">Sort By</option>
                                    <option value="rating_desc">Rating (High to Low)</option>
                                    <option value="rating_asc">Rating (Low to High)</option>
                                    <option value="name_asc">Name (A to Z)</option>
                                    <option value="name_desc">Name (Z to A)</option>
                                </select>
                            </div>
                        </div>

                        <label class="form-label"><h6 class="fw-semibold">Choose Categories</h6></label>
                        <div class="col-lg-12 mb-3" style="height:200px!important;overflow-x: hidden;overflow-y: scroll">
                            <div class="form-group">

                                @foreach(\App\Models\Category::whereNull('parent_id')->get() as $category)
                                    @php
                                       $selectedIds = \request('categories', []);
                                       $subCat = \App\Models\Category::where('parent_id', $category->id)->get();
                                    @endphp
                                    <div x-data="{ openMenu: false }" class="mb-3">
                                        <div class="d-flex align-items-center gap-2" style="cursor: pointer;">
                                            @if(count($subCat) > 0)
                                                <a class="d-flex align-items-center gap-2" href="javascript:void(0)" @click.prevent="openMenu = !openMenu">
                                                    <span x-show="!openMenu" class="ms-auto text-muted">&#9660;</span>
                                                    <span x-show="openMenu" class="ms-auto text-muted">&#9650;</span>
                                                </a>
                                            @else
                                                <a class="d-flex align-items-center gap-2" href="javascript:void(0)" @click.prevent="openMenu = !openMenu">
                                                    <span x-show="!openMenu" class="ms-auto text-white">&#9660;</span>
                                                    <span x-show="openMenu" class="ms-auto text-white">&#9650;</span>
                                                </a>
                                            @endif
                                                <input class="form-check-input"
                                                       type="checkbox"
                                                       @click="filterSubCategory({{ $category->id }})"
                                                       :checked="filters.subCategory.includes({{ $category->id }})">
                                                <a class="d-flex align-items-center gap-2" href="javascript:void(0)" @click.prevent="openMenu = !openMenu">
                                                <h6 class="text-secondary mb-0">{{ $category->name }}</h6>
                                            </a>
                                        </div>
                                        <div x-cloak x-show="openMenu" class="ps-4 border-start border-secondary mt-2">
                                            @foreach($subCat as $cat)
                                                <div class="d-flex align-items-center gap-2 mb-1">
                                                    <input class="form-check-input" type="checkbox"
                                                           @click="filterSubCategory({{ $category->id }})"
                                                           :checked="filters.subCategory.includes({{ $category->id }})">
                                                    <h6 class="text-secondary mb-0">{{ $cat->name }}</h6>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>

                        <div class="col-lg-12">
                            <label class="form-label"><h6 class="fw-semibold">Ratings</h6></label>

                            <div class="d-flex justify-content-start gap-2">
                                <button class="btn btn-outline-primary" @click.prevent="filters.rating = '5'" :class="{ 'active': filters.rating === '5' }">5 Star</button>
                                <button class="btn btn-outline-primary" @click.prevent="filters.rating = '4'" :class="{ 'active': filters.rating === '4' }">4 Star +</button>
                                <button class="btn btn-outline-primary" @click.prevent="filters.rating = '3'" :class="{ 'active': filters.rating === '3' }">3 Star +</button>
                            </div>

                        </div>

                    </div>

            </div>

            <!-- Modal footer -->
            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-lg btn-danger rounded-4" @click.prevent="resetFilters"><h6 class="text-white m-0">Reset Filters</h6></button>
                <button type="button" class="btn btn-lg btn-primary rounded-4" data-bs-dismiss="modal"><h6 class="text-white m-0">Apply Filters</h6></button>
            </div>
            </form>

        </div>
    </div>
</div>

@push('js')
        <script type="module">
            $(function () {
                const input = document.getElementById('filterSearch');
                const suggestions = document.getElementById('filterSuggestions');
                $('#filterSearch').on('input', async function (e) {
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
                                    document.dispatchEvent(new CustomEvent('locationUpdated', { detail: input.value }));
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
