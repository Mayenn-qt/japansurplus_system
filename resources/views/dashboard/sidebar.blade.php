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

            <!-- OPERATIONS -->
            <div class="sidebar-label">OPERATIONS</div>

            <ul class="nav flex-column gap-1 mb-3">

                <li class="nav-item">
                    <a class="{{ request()->routeIs('owner.product') ? 'sidebar-link-active' : 'sidebar-link' }}"
                        href="{{ route('owner.product') }}">
                        <i class="fa-solid fa-boxes-stacked sidebar-icon text-muted"></i>
                        Products
                    </a>
                </li>

                <li class="nav-item">
                    <a class="{{ request()->routeIs('owner.stock') ? 'sidebar-link-active' : 'sidebar-link' }}"
                        href="{{ route('owner.stock') }}">
                        <i class="fa-solid fa-warehouse sidebar-icon text-muted"></i>
                        Stock Management
                    </a>
                </li>

                <li class="nav-item">
                    <a class="{{ request()->routeIs('owner.salesrecording') ? 'sidebar-link-active' : 'sidebar-link' }}"
                        href="{{ route('owner.salesrecording') }}">
                        <i class="fa-solid fa-layer-group sidebar-icon text-muted"></i>
                        Sales Recording
                    </a>
                </li>

            </ul>

            <!-- INSIGHTS -->
            <div class="sidebar-label">INSIGHTS</div>

            <ul class="nav flex-column gap-1 mb-3">

                <li class="nav-item">
                    <a class="sidebar-link" href="#">
                        <i class="fa-solid fa-chart-line sidebar-icon text-muted"></i>
                        Reports
                    </a>
                </li>

                <li class="nav-item">
                    <a class="sidebar-link" href="#">
                        <i class="fa-solid fa-shop sidebar-icon text-muted"></i>
                        Branches
                    </a>
                </li>

                <li class="nav-item">
                    <a class="sidebar-link" href="#">
                        <i class="fa-solid fa-comment-sms sidebar-icon text-muted"></i>
                        SMS Notifications
                    </a>
                </li>

                <li class="nav-item">
                    <a class="sidebar-link" href="#">
                        <i class="fa-solid fa-users-gear sidebar-icon text-muted"></i>
                        User Management
                    </a>
                </li>

            </ul>

            <!-- ADMINISTRATION -->
            <div class="sidebar-label">ADMINISTRATION</div>

            <ul class="nav flex-column gap-1 mb-3">

                <li class="nav-item">
                    <a class="sidebar-link" href="#">
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

        <!-- BOTTOM PART -->
        <div class="pt-3 border-top border-secondary border-opacity-25">

            <form action="#" method="POST" class="m-0">
                @csrf

                <button type="submit" class="sidebar-logout-btn shadow-sm">
                    <i class="fa-solid fa-right-from-bracket sidebar-icon"></i>
                    Logout
                </button>

            </form>

        </div>

    </div>

</div>