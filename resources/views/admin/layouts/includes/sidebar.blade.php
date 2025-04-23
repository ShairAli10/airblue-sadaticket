<div class="vertical-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <a href="{{ route('admin.dashboard') }}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ asset('assets/images/'.config('constants.sadaticket-webp')) }}" alt="" height="35">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('assets/images/'.config('constants.sadaticket-webp')) }}" alt="" height="35">
            </span>
        </a>

        <a href="{{ route('admin.dashboard') }}" class="logo logo-light">
            <span class="logo-lg">
                <img src="{{ asset('assets/images/'.config('constants.sadaticket-webp')) }}" alt="" height="35">
            </span>
            <span class="logo-sm">
                <img src="{{ asset('assets/images/'.config('constants.sadaticket-webp')) }}" alt="" height="35">
            </span>
        </a>
    </div>

    <button type="button" class="btn btn-sm px-3 header-item vertical-menu-btn topnav-hamburger" id="collapse-sidebar-sm">
        <div class="hamburger-icon">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </button>

    <div data-simplebar class="sidebar-menu-scroll">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" data-key="t-menu">Menu</li>

                <li class="{{ Request::is('admin/dashboard') ? 'mm-active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="icon nav-icon" data-eva="grid-outline"></i>
                        <span class="menu-item" data-key="t-dashboards">Dashboards</span>
                    </a>
                </li>
                
                @if(auth('admin')->user()->can('Availability-Search'))
                    <li class="{{ Request::is('admin/flight/search') ? 'mm-active' : '' }}">
                        <a href="{{ route('admin.flight.search') }}">
                            <i class="fas fa-paper-plane"></i>
                            <span class="menu-item" data-key="t-dashboards">Search Flight</span>
                        </a>
                    </li>
                @endif
                <li class="{{ Request::is('admin/bookings') ? 'mm-active' : '' }}">
                    <a href="{{ url('admin/bookings') }}">
                        <i class="icon nav-icon" data-eva="bookmark"></i>
                        <span class="menu-item" data-key="t-contacts">Bookings</span>
                    </a>
                </li>
                @if(auth('admin')->user()->can('List-Users'))
                    <li class="{{ Request::is('admin/users') ? 'mm-active' : '' }}">
                        <a href="{{ url('admin/users') }}">
                            <i class="icon nav-icon" data-eva="person-done-outline"></i>
                            <span class="menu-item" data-key="t-contacts">Admin Users</span>
                        </a>
                    </li>
                @endif
                
                @if(auth('admin')->user()->can('List-Agents'))
                    <li class="{{ Request::is('admin/agents','admin/pricing-engine/*') ? 'mm-active' : '' }}">
                        <a href="javascript: void(0);" class="has-arrow">
                            <i class="icon nav-icon" data-eva="people-outline"></i>
                            <span class="menu-item" data-key="t-contacts">Travel Agents</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li>
                                <a href="{{ url('admin/agents') }}" data-key="t-inbox">Travel Agents List</a>
                            </li>
                            @if(auth('admin')->user()->can('List-Agent-Pricing'))
                                <li>
                                    <a href="{{ route('admin.pricingEngine.list') }}" data-key="t-read-email">Pricing Engine</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                @if(auth('admin')->user()->can('List-Customers'))
                    <li class="{{ Request::is('admin/customer','admin/customer/pricing-engine/*') ? 'mm-active' : '' }}">
                        <a href="javascript: void(0);" class="has-arrow">
                            <i class="fas fa-users"></i>
                            <span class="menu-item" data-key="t-contacts">Customers</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li>
                                <a href="{{ url('admin/customer') }}" data-key="t-inbox">Customers List</a>
                            </li>
                            @if(auth('admin')->user()->can('List-Customer-Pricing'))
                                <li>
                                    <a href="{{ url('admin/customer/pricing-engine/list') }}" data-key="t-read-email">Pricing Engine</a>
                                </li> 
                            @endif
                        </ul>
                    </li>
                @endif

                @if(auth('admin')->user()->can('List-Of-Roles'))
                    <li class="{{ Request::is('admin/roles') ? 'mm-active' : '' }}">
                        <a href="{{ url('admin/roles') }}">
                            <i class="fas fa-user-lock"></i>
                            <span class="menu-item" data-key="t-contacts">Roles & Permisstions</span>
                        </a>
                    </li>
                @endif

                @if(auth('admin')->user()->type == "admin")
                    <li class="{{ Request::is('admin/setting') ? 'mm-active' : '' }}">
                        <a href="{{ url('admin/setting') }}">
                            <i class="fas fa-cog"></i>
                            <span class="menu-item" data-key="t-contacts">Setting</span>
                        </a>
                    </li> 
                @endif
              
                @if(auth('admin')->user()->type == "admin")
                    <li class="{{ Request::is('admin/tours', 'admin/why-choose-us', 'admin/destination') ? 'mm-active' : '' }}">
                        <a href="javascript: void(0);" class="has-arrow">
                            <i class="fas fa-snowflake"></i>
                            <span class="menu-item" data-key="t-contacts">Frontend</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li>
                                <a href="{{ url('admin/tours') }}" data-key="t-inbox"><i class="fas fa-snowflake"></i> Popular Tours</a>
                            </li>
                            <li>
                                <a href="{{ url('admin/why-choose-us') }}" data-key="t-read-email"><i class="fas fa-thumbs-up"></i> Why Choose Us</a>
                            </li> 
                            <li>
                                <a href="{{ url('admin/destination') }}" data-key="t-read-email"><i class="fas fa-hotel"></i> Top Destination</a>
                            </li> 
                        </ul>
                    </li>
                @endif

            </ul>
        </div>
        <!-- Sidebar -->

        {{-- <div class="p-3 px-4 sidebar-footer">
            <p class="mb-1 main-title"><script>document.write(new Date().getFullYear())</script> &copy; Borex.</p>
            <p class="mb-0">Design & Develop by Royal Tech</p>
        </div> --}}
    </div>
</div>