<div style="position: fixed; top: 0; left: 250px; right: 0; height: 70px; background-color: #ffffff; border-bottom: 1px solid #e2e8f0; z-index: 9999; display: flex; align-items: center; justify-content: space-between; padding: 0 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.01);">
    
    <!-- Left: Sleek Search Bar -->
    <div style="display: flex; align-items: center; background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 7px 14px; width: 280px; transition: all 0.2s ease;">
        <i class="fa-solid fa-magnifying-glass" style="color: #94a3b8; font-size: 13px; margin-right: 10px;"></i>
        <input type="text" placeholder="Search products, records, staff..." style="background: transparent; border: none; color: #0f172a; outline: none; width: 100%; font-size: 13px;">
    </div>

    <!-- Right: Branch Selector, Utility Actions & Profile Dropdown -->
    <div style="display: flex; align-items: center; gap: 14px;">
        
        <!-- Interactive Branch Selector Dropdown -->
        <div class="dropdown">
            <button class="btn dropdown-toggle d-flex align-items-center gap-2" type="button" id="branchDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: #f8fafc; border: 1px solid #e2e8f0; padding: 6px 14px; border-radius: 10px; color: #0f172a; font-size: 13px; font-weight: 500;">
                <i class="fa-solid fa-store" style="color: #ef4444; font-size: 12px;"></i> 
                <span>All Branches</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm border border-light mt-2 py-2" aria-labelledby="branchDropdown" style="font-size: 13px; border-radius: 10px; min-width: 180px;">
                <li><h6 class="dropdown-header text-uppercase text-muted" style="font-size: 10px; letter-spacing: 0.5px;">Switch Branch</h6></li>
                <li><a class="dropdown-item py-2 fw-medium text-dark active bg-light" href="#"><i class="fa-solid fa-globe me-2 text-secondary"></i> All Branches</a></li>
                <li><a class="dropdown-item py-2 text-dark" href="#"><i class="fa-solid fa-location-dot me-2 text-danger"></i> Naga Branch</a></li>
                <li><a class="dropdown-item py-2 text-dark" href="#"><i class="fa-solid fa-location-dot me-2 text-danger"></i> Legazpi Branch</a></li>
                <li><a class="dropdown-item py-2 text-dark" href="#"><i class="fa-solid fa-location-dot me-2 text-danger"></i> Sorsogon Branch</a></li>
            </ul>
        </div>

        <!-- Vertical Divider -->
        <div style="height: 24px; width: 1px; background-color: #e2e8f0;"></div>

        <!-- Quick Action Icons (Notifications & Messages) -->
        <div style="display: flex; align-items: center; gap: 8px;">
            <button class="btn btn-light border-0 position-relative p-2" title="Notifications" style="background-color: #f8fafc; border-radius: 8px; color: #475569; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;">
                <i class="fa-solid fa-bell" style="font-size: 13px;"></i>
                <span class="position-absolute top-25 start-75 translate-middle p-1 bg-danger border border-light rounded-circle" style="width: 7px; height: 7px;"></span>
            </button>

            <button class="btn btn-light border-0 p-2" title="Messages" style="background-color: #f8fafc; border-radius: 8px; color: #475569; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;">
                <i class="fa-solid fa-comment-sms" style="font-size: 13px;"></i>
            </button>
        </div>

        <!-- Profile Dropdown -->
        <div class="dropdown ps-1">
            <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle hide-arrow" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="gap: 10px;">
                <div style="width: 38px; height: 38px; background: linear-gradient(135deg, #ef4444, #dc2626); border-radius: 50%; color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 12px; box-shadow: 0 2px 4px rgba(239, 68, 68, 0.2);">
                    AD
                </div>
                <div style="display: flex; flex-direction: column; text-align: left;">
                    <span style="color: #0f172a; font-size: 13px; font-weight: 600; line-height: 1.2;">Admin User</span>
                    <span style="color: #64748b; font-size: 11px;">Administrator</span>
                </div>
                <i class="fa-solid fa-chevron-down text-muted ms-1" style="font-size: 10px;"></i>
            </a>

            <!-- Dropdown Menu -->
            <ul class="dropdown-menu dropdown-menu-end shadow-sm border border-light mt-2 py-2" aria-labelledby="profileDropdown" style="background-color: #ffffff; font-size: 13px; border-radius: 10px; min-width: 160px;">
                <li>
                    <a class="dropdown-item d-flex align-items-center gap-2 py-2 text-dark" href="{{ route('owner.dashboard') }}">
                        <i class="fa-solid fa-user text-muted" style="width: 16px;"></i> Profile
                    </a>
                </li>
                <li><hr class="dropdown-divider border-light my-1"></li>
                <li>
                    <a class="dropdown-item d-flex align-items-center gap-2 py-2 text-danger" href="#" onclick="event.preventDefault(); logout();">
                        <i class="fa-solid fa-arrow-right-from-bracket" style="width: 16px;"></i> Logout
                    </a>
                </li>
            </ul>
        </div>

    </div>
</div>