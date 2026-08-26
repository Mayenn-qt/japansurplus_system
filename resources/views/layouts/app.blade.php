<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Ohaiyo Japan ERP')</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/topnavbar.css') }}">

    <style>
        body {
            background-color: #f8fafc;
            color: #0f172a;
            font-family: 'Poppins', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            overflow-x: hidden;
        }

        /* --- DESKTOP VIEW --- */
        @media (min-width: 992px) {
            .sidebar {
                position: fixed;
                top: 0;
                left: 0;
                bottom: 0;
                width: 250px;
                z-index: 1030;
                background-color: #ffffff;
            }
            .app-topbar {
                left: 250px !important;
                width: calc(100% - 250px) !important;
            }
            .main-content-wrapper {
                margin-left: 250px;
                margin-top: 70px;
                padding: 24px;
            }
        }

        /* --- MOBILE & TABLET VIEW --- */
        @media (max-width: 991.98px) {
            .sidebar {
                position: fixed;
                top: 0;
                left: -280px;
                bottom: 0;
                width: 250px;
                background-color: #ffffff;
                transition: left 0.3s ease-in-out;
                z-index: 1050;
            }

            .sidebar.show {
                left: 0 !important;
            }

            .app-topbar {
                left: 0 !important;
                width: 100% !important;
            }
            
            .main-content-wrapper {
                margin-left: 0 !important;
                margin-top: 70px;
                padding: 16px;
            }

            .sidebar-backdrop {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100vw;
                height: 100vh;
                background-color: rgba(0, 0, 0, 0.4);
                z-index: 1040;
            }
            .sidebar-backdrop.show {
                display: block;
            }
        }
    </style>
</head>
<body>

    <!-- Global Sidebar at Topnavbar para hindi na paulit-ulit sa views -->
    @auth
        @if(auth()->user()->role === 'staff' || Request::is('staff*'))
            @include('staff.partials.sidebar')
            @include('staff.partials.navbar')
        @else
            @include('dashboard.sidebar')
            @include('dashboard.topnavbar')
        @endif
    @endauth

    <div class="main-content-wrapper">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <div class="sidebar-backdrop"></div>

    <script>
        document.addEventListener("click", function (event) {
            const toggleBtn = event.target.closest("#sidebarToggle");
            const sidebar = document.getElementById("sidebar");
            const backdrop = document.querySelector(".sidebar-backdrop");

            if (toggleBtn) {
                event.preventDefault();
                if (sidebar) sidebar.classList.toggle("show");
                if (backdrop) backdrop.classList.toggle("show");
            }

            if (backdrop && event.target === backdrop) {
                if (sidebar) sidebar.classList.remove("show");
                if (backdrop) backdrop.classList.remove("show");
            }
        });
    </script>

    @yield('scripts')
</body>
</html>