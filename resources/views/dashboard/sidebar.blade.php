<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">

<div id="appShell" style="display:block">

    <div class="sidebar d-flex flex-column justify-content-between p-3 h-100 border-end border-secondary border-opacity-10" id="sidebar">

        <!-- TOP PART -->
        <div>

            <!-- System Logo & Name -->
            <div class="d-flex align-items-center gap-3 mb-4 px-2 pt-2">
                <div class="bg-danger text-white rounded-3 d-flex align-items-center justify-content-center shadow-sm flex-shrink-0 sidebar-brand-box">
                    <i class="fa-solid fa-store"></i>
                </div>

                <div style="line-height:1.2;">
                    <span class="sidebar-brand-title">Ohaiyo Japan</span>
                    <span class="sidebar-brand-sub">Surplus ERP</span>
                </div>
            </div>

            <!-- OVERVIEW -->
            <div class="sidebar-label">OVERVIEW</div>

            <ul class="nav flex-column gap-1 mb-3">
                <li class="nav-item">
                    <a class="{{ request()->routeIs('owner.dashboard') ? 'sidebar-link-active' : 'sidebar-link' }}"
                        href="{{ route('owner.dashboard') }}">
                        <i class="fa-solid fa-chart-pie sidebar-icon {{ request()->routeIs('owner.dashboard') ? 'text-danger' : 'text-muted' }}"></i>
                        Dashboard
                    </a>
                </li>
            </ul>

            <!-- Management -->
            <div class="sidebar-label">MANAGEMENT</div>

            <ul class="nav flex-column gap-1 mb-3">

                <li class="nav-item">
                    <a class="{{ request()->routeIs('owner.product') ? 'sidebar-link-active' : 'sidebar-link' }}"
                        href="{{ route('owner.product') }}">
                        <i class="fa-solid fa-box sidebar-icon text-muted"></i>
                        Product 
                    </a>
                </li>

                <li class="nav-item">
                    <a class="{{ request()->routeIs('owner.stock') ? 'sidebar-link-active' : 'sidebar-link' }}"
                        href="{{ route('owner.stock') }}">
                        <i class="fa-solid fa-boxes-stacked sidebar-icon text-muted"></i>
                        Inventory
                    </a>
                </li>

                <li class="nav-item">
                    <a class="{{ request()->routeIs('owner.branch') ? 'sidebar-link-active' : 'sidebar-link' }}"
                        href="{{ route('owner.branch') }}">
                        <i class="fa-solid fa-shop sidebar-icon text-muted"></i>
                        Branch 
                    </a>
                </li>

                <li class="nav-item">
                    <a class="{{ request()->routeIs('owner.user') ? 'sidebar-link-active' : 'sidebar-link' }}"
                        href="{{ route('owner.user') }}">
                        <i class="fa-solid fa-users sidebar-icon text-muted"></i>
                        User 
                    </a>

                </li>
            </ul>

            <!-- Reports -->
            <div class="sidebar-label">REPORTS</div>

            <ul class="nav flex-column gap-1 mb-3">

                <li class="nav-item">
                    <a class="{{ request()->routeIs('owner.reports.sales') ? 'sidebar-link-active' : 'sidebar-link' }}" href="{{ route('owner.reports.sales') }}">
                        <i class="fa-solid fa-chart-line sidebar-icon text-muted"></i>
                        Sales Reports
                    </a>
                </li>

                <li class="nav-item">
                    <a class="{{ request()->routeIs('owner.reports.inventory') ? 'sidebar-link-active' : 'sidebar-link' }}" 
                    href="{{ route('owner.reports.inventory') }}">
                        <i class="fa-solid fa-boxes-stacked sidebar-icon text-muted"></i>
                        Inventory Reports
                    </a>
                </li>

                <li class="nav-item">
                    <a class="{{ request()->routeIs('owner.reports.branchreport') ? 'sidebar-link-active' : 'sidebar-link' }}" href="{{ route('owner.reports.branchreport') }}">
                        <i class="fa-solid fa-shop sidebar-icon text-muted"></i>
                        Branch Performance
                    </a>
                </li>

            </ul>

            <!-- Communication -->
            <div class="sidebar-label">COMMUNICATION</div>

            <ul class="nav flex-column gap-1 mb-3">

                <li class="nav-item">
                        <a class="{{ request()->routeIs('owner.sms') ? 'sidebar-link-active' : 'sidebar-link' }}" href="{{ route('owner.sms') }}">
                            <i class="fa-solid fa-comment-sms sidebar-icon text-muted"></i>
                        SMS Notifications
                    </a>
                </li>

            </ul>

            <!-- SYSTEM -->
            <div class="sidebar-label">SYSTEM</div>

            <ul class="nav flex-column gap-1 mb-3">

                <li class="nav-item">
                    <a class="{{ request()->routeIs('owner.settings') ? 'sidebar-link-active' : 'sidebar-link' }}" href="{{ route('owner.settings') }}">
                        <i class="fa-solid fa-gear sidebar-icon text-muted"></i>
                        Settings
                    </a>
                </li>

            </ul>

            <!-- ACCOUNT -->
            <div class="sidebar-label">ACCOUNT</div>

            <ul class="nav flex-column gap-1">

                <li class="nav-item">
                    <a class="sidebar-link" href="#">
                        <i class="fa-solid fa-user-circle sidebar-icon text-muted"></i>
                        Profile
                    </a>
                </li>

            </ul>

        </div>

        <!-- BOTTOM PART (LOGOUT) -->
        <div class="pt-3 border-top border-secondary border-opacity-25">
            <form action="{{ route('logout') }}" method="POST" class="m-0">
                @csrf
                <button type="submit" class="sidebar-logout-btn shadow-sm">
                    <i class="fa-solid fa-right-from-bracket sidebar-icon"></i>
                    Logout
                </button>
            </form>
        </div>

    </div>

</div>