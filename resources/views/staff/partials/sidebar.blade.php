<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">

<div id="appShell" style="display:block">
    <div class="sidebar d-flex flex-column justify-content-between p-3 h-100 border-end border-secondary border-opacity-10" id="sidebar">

        <!-- TOP PART -->
        <div>
            <!-- System Logo & Name -->
            <div class="d-flex align-items-center gap-3 mb-4 px-2 pt-2">
                <div class="bg-danger text-white rounded-3 d-flex align-items-center justify-content-center shadow-sm flex-shrink-0 sidebar-brand-box">
                    <i class="fa-solid fa-cash-register"></i>
                </div>
                <div style="line-height:1.2;">
                    <span class="sidebar-brand-title">Ohaiyo Japan</span>
                    <span class="sidebar-brand-sub">Staff Terminal</span>
                </div>
            </div>

            <!-- OVERVIEW -->
            <div class="sidebar-label">OVERVIEW</div>
            <ul class="nav flex-column gap-1 mb-3">
                <li class="nav-item">
                    <a class="{{ request()->routeIs('staff.dashboard') ? 'sidebar-link-active' : 'sidebar-link' }}"
                        href="{{ route('staff.dashboard') }}">
                        <i class="fa-solid fa-chart-pie sidebar-icon {{ request()->routeIs('staff.dashboard') ? 'text-danger' : 'text-muted' }}"></i>
                        Dashboard
                    </a>
                </li>
            </ul>

            <!-- SALES & POS -->
            <div class="sidebar-label">SALES & POS</div>
            <ul class="nav flex-column gap-1 mb-3">
                <li class="nav-item">
                    <a class="{{ request()->routeIs('staff.sales.pos') ? 'sidebar-link-active' : 'sidebar-link' }}"
                        href="{{ route('staff.sales.pos') }}">
                        <i class="fa-solid fa-cash-register sidebar-icon {{ request()->routeIs('staff.sales.pos') ? 'text-danger' : 'text-muted' }}"></i>
                        POS Terminal
                    </a>
                </li>
                <!-- Idinagdag na Sales History Link dito -->
                <li class="nav-item">
                    <a class="{{ request()->routeIs('staff.sales.history') ? 'sidebar-link-active' : 'sidebar-link' }}"
                        href="{{ route('staff.sales.history') }}">
                        <i class="fa-solid fa-clock-rotate-left sidebar-icon {{ request()->routeIs('staff.sales.history') ? 'text-danger' : 'text-muted' }}"></i>
                        Sales History
                    </a>
                </li>
            </ul>

            <!-- PRODUCTS -->
            <div class="sidebar-label">CATALOG</div>
            <ul class="nav flex-column gap-1 mb-3">
                <li class="nav-item">
                    <a class="{{ request()->routeIs('staff.products.index') ? 'sidebar-link-active' : 'sidebar-link' }}"
                        href="{{ route('staff.products.index') }}">
                        <i class="fa-solid fa-box sidebar-icon {{ request()->routeIs('staff.products.index') ? 'text-danger' : 'text-muted' }}"></i>
                        Product List
                    </a>
                </li>
            </ul>

            <!-- INVENTORY -->
            <div class="sidebar-label">INVENTORY</div>
            <ul class="nav flex-column gap-1 mb-3">
                <li class="nav-item">
                    <a class="{{ request()->routeIs('staff.inventory.index') ? 'sidebar-link-active' : 'sidebar-link' }}"
                        href="{{ route('staff.inventory.index') }}">
                        <i class="fa-solid fa-warehouse sidebar-icon {{ request()->routeIs('staff.inventory.index') ? 'text-danger' : 'text-muted' }}"></i>
                        Current Inventory
                    </a>
                </li>
                <li class="nav-item">
                    <a class="{{ request()->routeIs('staff.inventory.low-stock') ? 'sidebar-link-active' : 'sidebar-link' }}"
                        href="{{ route('staff.inventory.low-stock') }}">
                        <i class="fa-solid fa-triangle-exclamation sidebar-icon {{ request()->routeIs('staff.inventory.low-stock') ? 'text-danger' : 'text-muted' }}"></i>
                        Low Stock Alerts
                    </a>
                </li>
            </ul>

            <!-- ACCOUNT -->
            <div class="sidebar-label">ACCOUNT</div>
            <ul class="nav flex-column gap-1">
                <li class="nav-item">
                    <a class="{{ request()->routeIs('staff.profile.*') ? 'sidebar-link-active' : 'sidebar-link' }}"
                        href="{{ route('staff.profile.index') }}">
                        <i class="fa-solid fa-user-circle sidebar-icon {{ request()->routeIs('staff.profile.*') ? 'text-danger' : 'text-muted' }}"></i>
                        User Profile
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