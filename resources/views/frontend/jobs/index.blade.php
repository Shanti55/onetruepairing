@extends('frontend.layouts.app')

@section('title', 'Browse Auctions | CtrlF')

@section('content')
<style>
    .job-card {
        transition: transform 0.2s, box-shadow 0.2s;
        border-radius: 16px !important;
        overflow: hidden;
    }
    .job-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.10) !important;
    }
    .auction-status-box {
        min-width: 240px;
        background: #f8faff;
        border-left: 1px solid #eef0f5;
    }
    .timer-display { font-family: 'Segoe UI Mono', monospace; letter-spacing: 1px; }
    .tab-btn {
        font-weight: 600;
        padding: 14px 20px;
        border-bottom: 3px solid transparent;
        transition: 0.2s;
        color: #6c757d;
        border-radius: 0;
        text-decoration: none !important;
    }
    .active-all      { border-bottom-color: #0d6efd !important; color: #0d6efd !important; }
    .active-live     { border-bottom-color: #dc3545 !important; color: #dc3545 !important; }
    .active-upcoming { border-bottom-color: #f59e0b !important; color: #b45309 !important; }
    .active-closed   { border-bottom-color: #6c757d !important; color: #374151 !important; }
    .live-dot { width: 9px; height: 9px; border-radius: 50%; background: #dc3545; display: inline-block; }
    @keyframes pulse-red {
        0%   { box-shadow: 0 0 0 0 rgba(220,53,69,0.7); }
        70%  { box-shadow: 0 0 0 8px rgba(220,53,69,0); }
        100% { box-shadow: 0 0 0 0 rgba(220,53,69,0); }
    }
    .animate-pulse-red { animation: pulse-red 1.8s infinite; }
    .badge-live {
        background: linear-gradient(135deg, #dc3545, #b02a37);
        border-radius: 20px;
        font-size: 11px;
        letter-spacing: 0.5px;
        animation: pulse-red 1.8s infinite;
    }
    .stat-pill { background: #f1f5ff; border-radius: 12px; padding: 6px 14px; font-size: 13px; }
    .filter-card { border-radius: 16px !important; position: sticky; top: 80px; }
    .category-scroll { max-height: 320px; overflow-y: auto; }
    .category-scroll::-webkit-scrollbar { width: 4px; }
    .category-scroll::-webkit-scrollbar-thumb { background: #dee2e6; border-radius: 4px; }
    .skeleton {
        background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
        background-size: 200% 100%;
        animation: shimmer 1.4s infinite;
        border-radius: 12px;
    }
    @keyframes shimmer {
        0%   { background-position: 200% 0; }
        100% { background-position: -200% 0; }
    }
    .detail-chip {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 12px;
        padding: 4px 12px;
        border-radius: 20px;
        font-weight: 500;
    }
    .expand-btn {
        font-size: 12px;
        color: #0d6efd;
        background: none;
        border: none;
        padding: 0;
        cursor: pointer;
        margin-top: 4px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: color 0.2s;
    }
    .expand-btn:hover { color: #0a58ca; }
    @media (max-width: 768px) {
        .auction-status-box { border-left: none; border-top: 1px solid #eef0f5; width: 100%; }
        .tab-btn { padding: 10px 12px; font-size: 13px; }
        .filter-card { position: static; }
    }
</style>

<div x-data="jobListings()" class="container my-5">
    <div class="row gy-4">

        {{-- Sidebar Filter --}}
        <div class="col-lg-3">
            <div class="card border-0 shadow-sm p-3 filter-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold mb-0">
                        <i class="bi bi-sliders me-2 text-primary"></i>Filters
                    </h6>
                    <button class="btn btn-sm text-danger p-0 fw-semibold"
                            @click="filters.search=''; filters.categories=[]; filters.status='all'">
                        Clear All
                    </button>
                </div>

                <div class="input-group mb-3">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="bi bi-search text-muted" style="font-size:13px;"></i>
                    </span>
                    <input type="text"
                           class="form-control border-start-0 ps-0"
                           placeholder="Search jobs..."
                           x-model.debounce.500ms="filters.search">
                </div>

                <template x-if="filters.categories.length > 0">
                    <div class="mb-2">
                        <span class="badge bg-primary rounded-pill"
                              x-text="filters.categories.length + ' selected'"></span>
                        <button class="btn btn-link btn-sm text-danger p-0 ms-1"
                                @click="filters.categories = []">Remove</button>
                    </div>
                </template>

                <label class="small fw-semibold text-muted mb-2 text-uppercase" style="font-size:11px;">
                    Categories
                </label>
                <div class="category-scroll pe-1">
                    <template x-for="cat in categories" :key="cat.id">
                        <div class="form-check small mb-2">
                            <input class="form-check-input" type="checkbox"
                                   :value="cat.id" x-model="filters.categories"
                                   :id="'cat-' + cat.id">
                            <label class="form-check-label" :for="'cat-' + cat.id"
                                   x-text="cat.name"></label>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        {{-- Main Content --}}
        <div class="col-lg-9">

            {{-- Summary bar --}}
            <div class="d-flex align-items-center gap-3 mb-3 flex-wrap">
                <span class="stat-pill text-muted">
                    <i class="bi bi-grid me-1"></i>
                    <span x-text="jobs.length"></span> auctions
                </span>
                <template x-if="filters.search">
                    <span class="stat-pill text-primary">
                        "<span x-text="filters.search"></span>"
                    </span>
                </template>
            </div>

            {{-- Tabs --}}
            <div class="card border-0 shadow-sm mb-4 overflow-hidden" style="border-radius:14px !important;">
                <div class="d-flex align-items-center px-2 overflow-auto text-nowrap">
                    <button @click="filters.status = 'all'"
                            :class="filters.status === 'all' ? 'active-all' : ''"
                            class="btn btn-link tab-btn">
                        <i class="bi bi-grid-3x3-gap me-1"></i>All
                    </button>
                    <button @click="filters.status = 'live'"
                            :class="filters.status === 'live' ? 'active-live' : ''"
                            class="btn btn-link tab-btn d-flex align-items-center gap-2">
                        <span class="live-dot animate-pulse-red"></span>Live Now
                    </button>
                    <button @click="filters.status = 'upcoming'"
                            :class="filters.status === 'upcoming' ? 'active-upcoming' : ''"
                            class="btn btn-link tab-btn">
                        <i class="bi bi-clock me-1"></i>Upcoming
                    </button>
                    <button @click="filters.status = 'closed'"
                            :class="filters.status === 'closed' ? 'active-closed' : ''"
                            class="btn btn-link tab-btn">
                        <i class="bi bi-archive me-1"></i>Closed
                    </button>
                </div>
            </div>

            {{-- Skeleton Loader --}}
            <template x-if="loading">
                <div>
                    <template x-for="i in 3" :key="i">
                        <div class="card border-0 shadow-sm mb-3 p-4" style="border-radius:16px;">
                            <div class="skeleton mb-3" style="height:22px;width:55%;"></div>
                            <div class="skeleton mb-2" style="height:14px;width:30%;"></div>
                            <div class="d-flex gap-2 mt-3">
                                <div class="skeleton" style="height:30px;width:90px;border-radius:20px;"></div>
                                <div class="skeleton" style="height:30px;width:90px;border-radius:20px;"></div>
                            </div>
                        </div>
                    </template>
                </div>
            </template>

            {{-- Job Cards --}}
            <template x-if="!loading">
                <div>
                    <template x-for="(job, index) in jobs" :key="job.id">
                        <div class="card job-card mb-3 shadow-sm border-0"
                             x-data="{ expanded: false }"
                             x-intersect="if(index + 1 == jobs.length) fetchMore()">
                            <div class="d-flex flex-md-row flex-column">

                                {{-- Left: Job Info --}}
                                <div class="card-body p-4 flex-grow-1">
                                    <div class="d-flex align-items-start justify-content-between gap-2 mb-1">
                                        <h5 class="fw-bold mb-0" x-text="job.title"></h5>
                                        <span class="badge bg-light text-primary border small text-nowrap fw-bold"
                                              x-text="'EL#' + String(job.id).padStart(5, '0')"></span>
                                    </div>

                                    <p class="text-primary small mb-2"
                                       x-text="job.posted_by?.serviceproviderprofile?.company_name || 'Individual'"></p>

                                    <div class="d-flex flex-wrap gap-2 mb-3">
                                        <span class="badge bg-light text-dark border py-2 px-3 rounded-pill">
                                            <i class="bi bi-geo-alt me-1 text-danger"></i>
                                            <span x-text="job.location"></span>
                                        </span>
                                        <span class="badge bg-light text-dark border py-2 px-3 rounded-pill">
                                            <i class="bi bi-currency-rupee text-success"></i>
                                            <span x-text="Number(job.cost).toLocaleString('en-IN')"></span>
                                        </span>
                                        <template x-if="job.duration_value">
                                            <span class="badge bg-light text-dark border py-2 px-3 rounded-pill">
                                                <i class="bi bi-clock me-1"></i>
                                                <span x-text="job.duration_value + ' ' + (job.duration_type || '')"></span>
                                            </span>
                                        </template>
                                    </div>

                                    {{-- Categories --}}
                                    <template x-if="job.categories && job.categories.length">
                                        <div class="d-flex flex-wrap gap-1 mb-2">
                                            <template x-for="cat in job.categories" :key="cat.id">
                                                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 py-1 px-2 rounded-pill"
                                                      style="font-size:11px;" x-text="cat.name"></span>
                                            </template>
                                        </div>
                                    </template>

                                    <template x-if="job.description">
                                        <div>
                                            <div class="border-top pt-3">
                                                <p class="small text-secondary mb-1"
                                                   style="line-height:1.65;"
                                                   :style="expanded ? '' : '-webkit-line-clamp:2;display:-webkit-box;-webkit-box-orient:vertical;overflow:hidden;'"
                                                   x-text="job.description"></p>
                                                <button class="expand-btn mt-1" @click="expanded = !expanded">
                                                    <span x-text="expanded ? 'Show less' : 'Read more'"></span>
                                                    <i :class="expanded ? 'bi-chevron-up' : 'bi-chevron-down'" class="bi"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </template>
                                </div>

                                {{-- Right: Auction Status Box --}}
                                <div class="auction-status-box p-4 text-center d-flex flex-column justify-content-center">

                                    <template x-if="job.auction_start && job.auction_end">
                                        <div x-data="{
                                            start: new Date(job.auction_start).getTime(),
                                            end:   new Date(job.auction_end).getTime()
                                        }">
                                            {{-- LIVE --}}
                                            <template x-if="now >= start && now <= end">
                                                <div>
                                                    <span class="badge badge-live text-white mb-2 px-3 py-1">● LIVE NOW</span>
                                                    <div class="small text-muted mb-1">Ends in</div>
                                                    <div class="fw-bold text-danger fs-6 timer-display mb-2"
                                                         x-text="formatTimer(job.auction_end)"></div>
                                                    <div class="small text-muted border-top pt-2 mb-3">
                                                        <i class="bi bi-calendar3 me-1"></i>
                                                        <span x-text="new Date(job.auction_end).toLocaleString([], {dateStyle:'short', timeStyle:'short'})"></span>
                                                    </div>
                                                    <a :href="'/job-registration/' + job.id"
                                                       class="btn btn-success btn-sm w-100 fw-bold py-2 rounded-3 shadow-sm">
                                                        <i class="bi bi-lightning-charge-fill me-1"></i>Place Bid
                                                    </a>
                                                </div>
                                            </template>

                                            {{-- UPCOMING --}}
                                            <template x-if="now < start">
                                                <div>
                                                    <span class="badge bg-warning text-dark mb-2 px-3 py-1 rounded-pill">
                                                        <i class="bi bi-clock me-1"></i>Upcoming
                                                    </span>
                                                    <div class="small text-muted mb-1">Starts in</div>
                                                    <div class="fw-bold text-dark fs-6 timer-display mb-2"
                                                         x-text="formatTimer(job.auction_start)"></div>
                                                    <div class="small text-muted border-top pt-2 mb-3 text-start">
                                                        <div>
                                                            <i class="bi bi-play-circle me-1 text-success"></i>
                                                            Start: <span class="fw-bold text-dark"
                                                                         x-text="new Date(job.auction_start).toLocaleString([], {dateStyle:'short', timeStyle:'short'})"></span>
                                                        </div>
                                                        <div class="mt-1">
                                                            <i class="bi bi-stop-circle me-1 text-danger"></i>
                                                            End: <span class="fw-bold text-dark"
                                                                       x-text="new Date(job.auction_end).toLocaleString([], {dateStyle:'short', timeStyle:'short'})"></span>
                                                        </div>
                                                    </div>
                                                    <a :href="'/job-registration/' + job.id"
                                                       class="btn btn-primary btn-sm w-100 fw-bold py-2 rounded-3 shadow-sm">
                                                        <i class="bi bi-pencil-square me-1"></i>Register Now
                                                    </a>
                                                </div>
                                            </template>

                                            {{-- CLOSED --}}
                                            <template x-if="now > end">
                                                <div>
                                                    <span class="badge bg-secondary text-white mb-2 px-3 py-1 rounded-pill">
                                                        <i class="bi bi-archive me-1"></i>Closed
                                                    </span>
                                                    <div class="small text-muted mt-1">Auction ended</div>
                                                    <div class="small fw-bold text-secondary mb-3"
                                                         x-text="new Date(job.auction_end).toLocaleDateString('en-IN', {day:'numeric', month:'short', year:'numeric'})">
                                                    </div>
                                                    <a :href="'/jobs/show?id=' + job.id"
                                                       class="btn btn-outline-secondary btn-sm w-100 py-2 rounded-3">
                                                        <i class="bi bi-eye me-1"></i>View Details
                                                    </a>
                                                </div>
                                            </template>
                                        </div>
                                    </template>

                                    {{-- No timing set --}}
                                    <template x-if="!job.auction_start || !job.auction_end">
                                        <div class="py-2">
                                            <i class="bi bi-calendar-event text-muted fs-3 d-block mb-2"></i>
                                            <div class="small text-secondary">Schedule pending</div>
                                            <a :href="'/jobs/show?id=' + job.id"
                                               class="btn btn-outline-secondary btn-sm w-100 mt-2 py-2 rounded-3">
                                                <i class="bi bi-eye me-1"></i>View Details
                                            </a>
                                        </div>
                                    </template>
                                </div>

                            </div>
                        </div>
                    </template>

                    {{-- Empty State --}}
                    <template x-if="jobs.length === 0">
                        <div class="text-center py-5 bg-white border rounded-4 shadow-sm">
                            <i class="bi bi-search fs-1 text-muted d-block mb-3"></i>
                            <h6 class="fw-bold text-dark">No auctions found</h6>
                            <p class="text-muted small mb-3">Try adjusting your filters or check back later.</p>
                            <button class="btn btn-outline-primary btn-sm px-4"
                                    @click="filters.search=''; filters.categories=[]; filters.status='all'">
                                Reset Filters
                            </button>
                        </div>
                    </template>
                </div>
            </template>

        </div>
    </div>
</div>

@push('js')
<script>
function jobListings() {
    return {
        jobs: [],
        categories: [],
        skip: 0,
        loading: false,
        now: new Date().getTime(),
        filters: {
            search: '',
            categories: [],
            status: 'all'
        },

        async init() {
            setInterval(() => { this.now = new Date().getTime(); }, 1000);
            await this.fetchData();
            this.$watch('filters', async () => {
                this.skip = 0;
                await this.fetchData();
            }, { deep: true });
        },

        formatTimer(target) {
            let diff = new Date(target).getTime() - this.now;
            if (diff <= 0) return "00d : 00h : 00m : 00s";
            let d = Math.floor(diff / 86400000);
            let h = Math.floor((diff % 86400000) / 3600000);
            let m = Math.floor((diff % 3600000)  / 60000);
            let s = Math.floor((diff % 60000)    / 1000);
            let pad = v => String(v).padStart(2, '0');
            return `${pad(d)}d : ${pad(h)}h : ${pad(m)}m : ${pad(s)}s`;
        },

        async fetchData() {
            this.loading = true;
            try {
                let res = await axios.get("{{ route('frontend.jobs.get-data') }}", {
                    params: {
                        tab    : this.filters.status,  // ✅ Tab backend ko pass karo
                        filters: JSON.stringify({
                            search    : this.filters.search,
                            categories: this.filters.categories,
                        }),
                        skip: 0
                    }
                });
                this.jobs       = res.data.jobs;
                this.categories = res.data.categories;
            } catch(e) { console.error(e); }
            this.loading = false;
        },

        async fetchMore() {
            this.skip += 8;
            try {
                let res = await axios.get("{{ route('frontend.jobs.get-data') }}", {
                    params: {
                        tab    : this.filters.status,  // ✅ Tab pass karo
                        filters: JSON.stringify({
                            search    : this.filters.search,
                            categories: this.filters.categories,
                        }),
                        skip: this.skip
                    }
                });
                this.jobs.push(...res.data.jobs);
            } catch(e) { console.error(e); }
        }
    }
}
</script>
@endpush