<aside id="sidebar" class="collapse collapse-horizontal border-end d-md-block" >
    <!-- Content For Sidebar -->
    <div class="h-100">
        <div class="sidebar-logo ms-2">
            <a href="{{ route('admins.dashboard') }}" class="pe-md-0">
                <div class="d-flex flex-wrap gap-2 align-items-center">
                    <img src="https://ui-avatars.com/api/?background=0D8ABC&color=FFF&name={{urlencode(auth()->user()->name)}}" class="avatar img-fluid rounded" alt="">
                    <span>{{ auth()->user()->name }}</span>
                </div>
            </a>
        </div>
        <ul class="sidebar-nav">
            <li class="sidebar-item">
                <a href="{{ route('admins.dashboard') }}" class="sidebar-link text-dark bg-light border-0 fw-semibold {{ request()->routeIs('home') ? 'active' : '' }}"
                   wire:navigate>
                    <i class="bi bi-arrow-left-circle pe-2"></i>
                    Back To Dashboard
                </a>
            </li>
            <li class="sidebar-item">
                <a href="{{ route('settings.index') }}" wire:navigate
                   class="sidebar-link">
                    <i class="bi bi-house pe-2"></i>
                    General Settings
                </a>
            </li>



            <li class="sidebar-item">
                <a href="#" class="sidebar-link collapsed" data-bs-target="#pages"
                   aria-expanded="false"><i class="bi bi-receipt pe-2"></i>
                    Pages
                </a>
            <li class="sidebar-item">
                <a href="{{ route('settings.index',['page'=>'login-register']) }}" wire:navigate
                   class="sidebar-link">
                    <i class="bi bi-door-open pe-2"></i>
                    Login/Signup
                </a>
            </li>
            <li class="sidebar-item">
                <a href="{{ route('settings.index',['page'=>'home']) }}" wire:navigate
                   class="sidebar-link">
                    <i class="bi bi-house pe-2"></i>
                    Home
                </a>
            </li>
            <li class="sidebar-item">
                <a href="{{ route('settings.index',['page'=>'about-us']) }}"
                   class="sidebar-link">
                    <i class="bi bi-file-earmark-richtext pe-2"></i>
                    About Us
                </a>
            </li>
            <li class="sidebar-item">
                <a href="{{ route('settings.index',['page'=>'benefits-of-listings']) }}"
                   class="sidebar-link">
                    <i class="bi bi-bookmark-star pe-2"></i>
                    Benefits Of Listings
                </a>
            </li>
            <li class="sidebar-item">
                <a href="{{ route('business-values.index') }}"  wire:navigate
                   class="sidebar-link">
                    <i class="bi bi-graph-up-arrow pe-2"></i>
                    Business Values
                </a>
            </li>
            <li class="sidebar-item">
                <a href="{{ route('settings.index',['page'=>'contact-us']) }}" wire:navigate
                   class="sidebar-link">
                    <i class="bi bi-envelope-paper pe-2"></i>
                    Contact Us
                </a>
            </li>
            <li class="sidebar-item">
                <a href="{{ route('settings.index',['page'=>'terms-and-conditions']) }}"
                   class="sidebar-link">
                    <i class="bi bi-file-medical pe-2"></i>
                    Terms and Conditions
                </a>
            </li>
            <li class="sidebar-item">
                <a href="{{ route('settings.index',['page'=>'privacy-policy']) }}"
                   class="sidebar-link">
                    <i class="bi bi-file-medical pe-2"></i>
                    Privacy Policy
                </a>
            </li>
            <li class="sidebar-item">
                <a href="{{ route('settings.index',['page'=>'customer-agreements']) }}"
                   class="sidebar-link">
                    <i class="bi bi-file-medical pe-2"></i>
                    Customer Agreement
                </a>
            </li>
            <li class="sidebar-item">
                <a href="{{ route('settings.index',['page'=>'refund-policy']) }}"
                   class="sidebar-link">
                    <i class="bi bi-file-medical pe-2"></i>
                    Refund Policy
                </a>
            </li>
            <li class="sidebar-item">
                <a href="{{ route('settings.index',['page'=>'faqs']) }}"
                   class="sidebar-link">
                    <i class="bi bi-file-medical pe-2"></i>
                    FAQ
                </a>
            </li>
{{--            <li class="sidebar-item">--}}
{{--                <a href="{{ route('settings.index',['page'=>'manage-ads']) }}" wire:navigate--}}
{{--                   class="sidebar-link">--}}
{{--                    <i class="bi bi-bookmarks pe-2"></i>--}}
{{--                    Manage Ads--}}
{{--                </a>--}}
{{--            </li>--}}
            <li class="sidebar-item">
                <a href="{{ route('manage-ads.index') }}" wire:navigate
                   class="sidebar-link">
                    <i class="bi bi-bookmarks pe-2"></i>
                    Manage Ads
                </a>
            </li>
            <li class="sidebar-item">
                <a href="{{ route('states.index') }}" wire:navigate
                   class="sidebar-link">
                    <i class="bi bi-map pe-2"></i>
                    Manage States
                </a>
            </li>
        </ul>
    </div>
</aside>
