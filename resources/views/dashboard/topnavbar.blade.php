<div style="position: fixed; top: 0; left: 250px; right: 0; height: 70px; background-color: #1e293b; border-bottom: 1px solid rgba(255, 255, 255, 0.08); z-index: 9999; display: flex; align-items: center; justify-content: space-between; padding: 0 20px;">
    
    <!-- Left: Search Bar -->
    <div style="display: flex; align-items: center; background-color: #334155; border-radius: 20px; padding: 5px 15px; width: 250px;">
        <i class="fa-solid fa-magnifying-glass" style="color: #94a3b8; font-size: 13px; margin-right: 8px;"></i>
        <input type="text" placeholder="Search..." style="background: transparent; border: none; color: #ffffff; outline: none; width: 100%; font-size: 13px;">
    </div>

    <!-- Right: All Branches, Icons, Profile Dropdown -->
    <div style="display: flex; align-items: center; gap: 12px;">
        
        <!-- Branch Chip -->
        <div style="background-color: rgba(255,255,255,0.06); padding: 5px 12px; border-radius: 20px; color: #fff; font-size: 12px; white-space: nowrap;">
            <i class="fa-solid fa-store" style="color: #ef4444; margin-right: 4px;"></i> All Branches
        </div>

        <!-- Notification -->
        <button style="background: transparent; border: none; color: #fff; cursor: pointer; padding: 5px;">
            <i class="fa-solid fa-bell" style="font-size: 15px;"></i>
        </button>

        <!-- Messages -->
        <button style="background: transparent; border: none; color: #fff; cursor: pointer; padding: 5px;">
            <i class="fa-solid fa-comment-sms" style="font-size: 15px;"></i>
        </button>

        <!-- Profile Dropdown (Bootstrap dropdown toggle) -->
        <div class="dropdown border-start border-secondary border-opacity-25 ps-3 ms-2">
            <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="gap: 8px;">
                <div style="width: 34px; height: 34px; background-color: #ef4444; border-radius: 50%; color: #fff; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 12px;">
                    AD
                </div>
                <div style="display: flex; flex-direction: column; text-align: left;">
                    <span style="color: #fff; font-size: 12px; font-weight: 600; line-height: 1.2;">Admin User</span>
                    <span style="color: #94a3b8; font-size: 10px;">Administrator</span>
                </div>
            </a>

            <!-- Dropdown Menu -->
            <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end shadow border-secondary border-opacity-25 mt-2" aria-labelledby="profileDropdown" style="background-color: #1e293b; font-size: 13px;">
                <li>
                    <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="{{ route('owner.dashboard') }}/* o ilagay ang profile route mo dito */">
                        <i class="fa-solid fa-user text-muted" style="width: 16px;"></i> Profile
                    </a>
                </li>
                <li><hr class="dropdown-divider border-secondary opacity-25"></li>
                <li>
                    <a class="dropdown-item d-flex align-items-center gap-2 py-2 text-danger" href="#" onclick="event.preventDefault(); logout();">
                        <i class="fa-solid fa-arrow-right-from-bracket" style="width: 16px;"></i> Logout
                    </a>
                </li>
            </ul>
        </div>

    </div>
</div>