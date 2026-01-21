
    <nav x-data="navigation()" class=" py-3 border-top navbar-expand fixed-bottom d-block d-lg-none  bottom-bar bg-white"
         data-turbolinks-permanent>

        <ul class="navbar-nav d-flex align-items-center justify-content-around mx-auto" style="flex: 1">
            <div class="col text-center m-0">
                <a class="btn btn-app bottom-bar-btn shadow-none {{ request()->routeIs('frontend.home') ? 'active' : '' }}  m-0"
                   data-turbolinks="true" href="{{route('frontend.home')}}">
                    <i class="{{ request()->routeIs('frontend.home')  ? 'bi bi-house-fill' : 'bi bi-house' }}"></i><br>
                    Home
                </a>
            </div>

            <div class="col text-center m-0 ">
                <a class="btn btn-app bottom-bar-btn shadow-none {{ str_contains(url()->current(), '/browse/listings') ? 'active' : '' }}  m-0"
                   data-turbolinks="true" href="{{route('frontend.browse-listings.index')}}">
                    <i class="{{ str_contains(url()->current(), '/browse/listings') ? 'bi bi-chat-square-text-fill' : 'bi bi-chat-square-text' }}"></i><br>
                    Listing
                </a>
            </div>

            <div class="col text-center m-0">
                <a class="btn btn-app bottom-bar-btn shadow-none {{ str_contains(url()->current(), '/login') ? 'active' : '' }}  m-0"
                   data-turbolinks="true" href="{{route('frontend.job-posts.createOrUpdate')}}">
                    <i class="{{ str_contains(url()->current(), '/login') ? 'bi bi-check-square-fill' : 'bi bi-check-square' }}"></i><br>
                    Post a Job
                </a>
            </div>

            <div class="col text-center m-0">
                <a class="btn btn-app bottom-bar-btn shadow-none {{ str_contains(url()->current(), '/jobs') ? 'active' : '' }}  m-0"
                   data-turbolinks="true" href="{{route('frontend.jobs.index')}}">
                    <i class="{{ str_contains(url()->current(), '/jobs') ? 'bi bi-briefcase-fill' : 'bi bi-briefcase' }}"></i><br>
                    Jobs
                </a>
            </div>
        </ul>

    </nav>

