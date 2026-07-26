<div class="row g-3 mb-4">
    <!-- Bar Chart Section (Monthly Sales Trend - Ranked Bar Colors) -->
    <div class="col-lg-8">
        <div class="dashboard-card p-4 h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h5 class="fw-bold h6 mb-1 text-white">Monthly Sales Trend</h5>
                    <span class="text-white-50 small" style="font-size: 0.75rem;">Jan – Jul 2026</span>
                </div>
                <!-- Professional Toggle Buttons -->
                <div class="btn-group btn-group-sm bg-dark p-1 rounded border border-secondary border-opacity-25" role="group">
                    <button type="button" class="btn btn-primary btn-sm px-3 py-1 shadow-sm text-white fw-medium" style="font-size: 0.75rem; background-color: #2563eb; border: none;">Revenue</button>
                    <button type="button" class="btn btn-dark btn-sm px-3 py-1 text-white-50 border-0" style="font-size: 0.75rem;">Transactions</button>
                </div>
            </div>

            <!-- Bar Chart Visual Container (Scaled for 100 pesos uniform values with left-side labels) -->
            <div class="position-relative pt-3 ps-5 border-top border-secondary border-opacity-25" style="height: 230px;">
                <!-- Professional Grid Lines & Axis Values (Left-Aligned) -->
                <div class="position-absolute w-100 h-100 d-flex flex-column justify-content-between pointer-events-none text-white" style="top: 0; left: 0; font-size: 0.65rem; z-index: 1; padding-left: 0.5rem; padding-right: 1rem;">
                    <div class="border-bottom border-secondary border-opacity-25 w-100 d-flex justify-content-start pb-1 text-white-50"><span>₱100</span></div>
                    <div class="border-bottom border-secondary border-opacity-25 w-100 d-flex justify-content-start pb-1 text-white-50"><span>₱75</span></div>
                    <div class="border-bottom border-secondary border-opacity-25 w-100 d-flex justify-content-start pb-1 text-white-50"><span>₱50</span></div>
                    <div class="border-bottom border-secondary border-opacity-25 w-100 d-flex justify-content-start pb-1 text-white-50"><span>₱25</span></div>
                </div>

                <!-- Clean Bars Container (All set to 100% height for ₱100) -->
                <div class="d-flex justify-content-between align-items-end h-100 position-relative px-3 pb-1" style="z-index: 2;">
                    
                    <!-- Jan -->
                    <div class="d-flex flex-column align-items-center justify-content-end h-100 position-relative group" style="width: 12%;">
                        <button type="button" class="btn w-100 p-0 border-0 rounded-top shadow-sm transition-all" style="height: 100%; background-color: #ef4444 !important;" title="Jan: ₱100"></button>
                    </div>

                    <!-- Feb -->
                    <div class="d-flex flex-column align-items-center justify-content-end h-100 position-relative group" style="width: 12%;">
                        <button type="button" class="btn w-100 p-0 border-0 rounded-top shadow-sm transition-all" style="height: 100%; background-color: #f59e0b !important;" title="Feb: ₱100"></button>
                    </div>

                    <!-- Mar -->
                    <div class="d-flex flex-column align-items-center justify-content-end h-100 position-relative group" style="width: 12%;">
                        <button type="button" class="btn w-100 p-0 border-0 rounded-top shadow-sm transition-all" style="height: 100%; background-color: #f97316 !important;" title="Mar: ₱100"></button>
                    </div>

                    <!-- Apr -->
                    <div class="d-flex flex-column align-items-center justify-content-end h-100 position-relative group" style="width: 12%;">
                        <button type="button" class="btn w-100 p-0 border-0 rounded-top shadow-sm transition-all" style="height: 100%; background-color: #6366f1 !important;" title="Apr: ₱100"></button>
                    </div>

                    <!-- May -->
                    <div class="d-flex flex-column align-items-center justify-content-end h-100 position-relative group" style="width: 12%;">
                        <button type="button" class="btn w-100 p-0 border-0 rounded-top shadow-sm transition-all" style="height: 100%; background-color: #3b82f6 !important;" title="May: ₱100"></button>
                    </div>

                    <!-- Jun -->
                    <div class="d-flex flex-column align-items-center justify-content-end h-100 position-relative group" style="width: 12%;">
                        <button type="button" class="btn w-100 p-0 border-0 rounded-top shadow-sm transition-all" style="height: 100%; background-color: #2563eb !important;" title="Jun: ₱100"></button>
                    </div>

                </div>
            </div>

            <!-- Months labels in solid white -->
            <div class="d-flex justify-content-between px-3 text-white fw-medium mt-2 ps-5" style="font-size: 0.75rem;">
                <span>Jan</span><span>Feb</span><span>Mar</span><span>Apr</span><span>May</span><span>Jun</span>
            </div>
        </div>
    </div>

    <!-- Product Statistic Card -->
    <div class="col-lg-4">
        <div class="dashboard-card p-4 h-100 position-relative overflow-hidden">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h5 class="fw-bold h6 mb-0 text-white">Total Transactions</h5>
                <select class="form-select form-select-sm border-0 w-auto py-0 px-2 shadow-sm bg-dark text-white" style="font-size: 0.75rem;">
                    <option>Today</option>
                    <option>Monthly</option>
                </select>
            </div>
            <span class="text-white-50 small d-block mb-3" style="font-size: 0.75rem;">Track your product sales</span>

            <div class="d-flex justify-content-center align-items-center py-2">
                <div class="rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 140px; height: 140px; background: conic-gradient(#3b82f6 0% 33.3%, #f59e0b 33.3% 66.6%, #334155 66.6% 100%);">
                    <div class="rounded-circle d-flex align-items-center justify-content-center text-white shadow-inner" style="width: 70px; height: 70px; background-color: #1e293b;">
                        <span class="fw-bold small">₱300</span>
                    </div>
                </div>
            </div>

            <div class="mt-3 d-flex flex-column gap-2 small">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="fw-medium text-white"><span class="badge rounded-circle me-1" style="width: 8px; height: 8px; display: inline-block; background-color: #3b82f6;"></span>Sorsogon Branch</span>
                    <div class="d-flex align-items-center gap-2">
                        <span class="text-white-50">₱100</span>
                        <span class="badge bg-primary bg-opacity-10 text-primary" style="font-size: 0.65rem;">33.3%</span>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="fw-medium text-white"><span class="badge rounded-circle me-1" style="width: 8px; height: 8px; display: inline-block; background-color: #f59e0b;"></span> Juban Branch</span>
                    <div class="d-flex align-items-center gap-2">
                        <span class="text-white-50">₱100</span>
                        <span class="badge bg-warning bg-opacity-10 text-warning" style="font-size: 0.65rem;">33.3%</span>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="fw-medium text-white"><span class="badge rounded-circle me-1" style="width: 8px; height: 8px; display: inline-block; background-color: #334155;"></span> Bacon Branch</span>
                    <div class="d-flex align-items-center gap-2">
                        <span class="text-white-50">₱100</span>
                        <span class="badge bg-secondary bg-opacity-10 text-secondary" style="font-size: 0.65rem;">33.3%</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>