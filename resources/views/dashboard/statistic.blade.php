<div class="row g-3 mb-4">
    <!-- Left Column: Monthly Sales Trend (Line Chart Card) -->
    <div class="col-lg-8">
        <div class="card shadow mb-4 h-100 border-0">
            <!-- Card Header -->
            <div class="card-header py-3 d-flex justify-content-between align-items-center bg-white">
                <div>
                    <h6 class="m-0 font-weight-bold text-primary">Monthly Sales Trend</h6>
                    <div class="text-muted mt-1" style="font-size: 11px;">Jan – Jul 2026</div>
                </div>
                <div class="btn-group btn-group-sm bg-light p-1 rounded border border-secondary border-opacity-25" role="group">
                    <button type="button" class="btn btn-primary btn-sm px-3 py-1 shadow-sm text-white fw-medium" style="font-size: 0.75rem; background-color: #2563eb; border: none;">Revenue</button>
                    <button type="button" class="btn btn-light btn-sm px-3 py-1 text-black-50 border-0 shadow-none" style="font-size: 0.75rem;">Transactions</button>
                </div>
            </div>
            
            <!-- Card Body -->
            <div class="card-body">
                <div class="chart-area position-relative pt-2 ps-5 border-top border-secondary border-opacity-10 mt-1" style="height: 210px;">
                    
                    <!-- Y-Axis Grid Lines & Values -->
                    <div class="position-absolute w-100 h-100 d-flex flex-column justify-content-between pointer-events-none text-muted" style="top: 0; left: 0; font-size: 0.65rem; z-index: 1; padding-left: 0.5rem; padding-right: 1.5rem;">
                        <div class="border-bottom border-secondary border-opacity-10 w-100 d-flex justify-content-start pb-1"><span>400,000</span></div>
                        <div class="border-bottom border-secondary border-opacity-10 w-100 d-flex justify-content-start pb-1"><span>360,000</span></div>
                        <div class="border-bottom border-secondary border-opacity-10 w-100 d-flex justify-content-start pb-1"><span>320,000</span></div>
                        <div class="border-bottom border-secondary border-opacity-10 w-100 d-flex justify-content-start pb-1"><span>280,000</span></div>
                    </div>

                    <!-- SVG Smooth Line Graph with Area Fill -->
                    <div class="position-absolute w-100 h-100" style="top: 0; left: 0; padding-left: 3rem; padding-right: 2rem; padding-top: 10px; padding-bottom: 25px; z-index: 2;">
                        <svg viewBox="0 0 600 180" class="w-100 h-100 overflow-visible">
                            <defs>
                                <linearGradient id="chartGradient" x1="0" y1="0" x2="0" y2="1">
                                    <stop offset="0%" stop-color="#3b82f6" stop-opacity="0.25"></stop>
                                    <stop offset="100%" stop-color="#3b82f6" stop-opacity="0.0"></stop>
                                </linearGradient>
                            </defs>

                            <!-- Area Gradient Under the Line -->
                            <path d="M 0,140 Q 100,100 200,110 T 400,60 T 600,20 L 600,160 L 0,160 Z" fill="url(#chartGradient)"></path>

                            <!-- Main Smooth Trend Line -->
                            <path d="M 0,140 Q 100,100 200,110 T 400,60 T 600,20" fill="none" stroke="#2563eb" stroke-width="3" stroke-linecap="round"></path>

                            <!-- Data Points (Circles) -->
                            <circle cx="0" cy="140" r="2.5" fill="#ffffff" stroke="#2563eb" stroke-width="1.5"></circle>
                            <circle cx="100" cy="116" r="2.5" fill="#ffffff" stroke="#2563eb" stroke-width="1.5"></circle>
                            <circle cx="200" cy="110" r="2.5" fill="#ffffff" stroke="#2563eb" stroke-width="1.5"></circle>
                            <circle cx="300" cy="85" r="2.5" fill="#ffffff" stroke="#2563eb" stroke-width="1.5"></circle>
                            <circle cx="400" cy="60" r="2.5" fill="#ffffff" stroke="#2563eb" stroke-width="1.5"></circle>
                            <circle cx="500" cy="40" r="2.5" fill="#ffffff" stroke="#2563eb" stroke-width="1.5"></circle>
                            <circle cx="600" cy="20" r="2.5" fill="#ffffff" stroke="#2563eb" stroke-width="1.5"></circle>
                        </svg>
                    </div>

                </div>

                <!-- X-Axis Months Labels -->
                <div class="d-flex justify-content-between text-muted fw-medium mt-1 ps-5 pe-3" style="font-size: 0.75rem;">
                    <span>Jan</span>
                    <span>Feb</span>
                    <span>Mar</span>
                    <span>Apr</span>
                    <span>May</span>
                    <span>Jun</span>
                    <span>Jul</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column: Product Statistic / Donut Chart Card -->
    <div class="col-lg-4">
        <div class="card h-100 border-0 shadow-sm p-4 position-relative overflow-hidden">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <h5 class="fw-bold h6 mb-0 text-black">Total Transactions</h5>
                <select class="form-select form-select-sm border-0 w-auto py-0 px-2 shadow-sm bg-light text-black" style="font-size: 0.75rem;">
                    <option>Today</option>
                    <option>Monthly</option>
                </select>
            </div>
            <span class="text-black-50 small d-block mb-3" style="font-size: 0.75rem;">Track your product sales</span>

            <div class="d-flex justify-content-center align-items-center py-2">
                <div class="rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 140px; height: 140px; background: conic-gradient(#3b82f6 0% 33.3%, #f59e0b 33.3% 66.6%, #cbd5e1 66.6% 100%);">
                    <div class="rounded-circle d-flex align-items-center justify-content-center text-black shadow-inner" style="width: 70px; height: 70px; background-color: #ffffff;">
                        <span class="fw-bold small">₱450</span>
                    </div>
                </div>
            </div>

            <div class="mt-3 d-flex flex-column gap-2 small">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="fw-medium text-black"><span class="badge rounded-circle me-1" style="width: 8px; height: 8px; display: inline-block; background-color: #3b82f6;"></span>Sorsogon Branch</span>
                    <div class="d-flex align-items-center gap-2">
                        <span class="text-black-50">₱100</span>
                        <span class="badge bg-primary bg-opacity-10 text-primary" style="font-size: 0.65rem;">22.2%</span>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="fw-medium text-black"><span class="badge rounded-circle me-1" style="width: 8px; height: 8px; display: inline-block; background-color: #f59e0b;"></span> Juban Branch</span>
                    <div class="d-flex align-items-center gap-2">
                        <span class="text-black-50">₱150</span>
                        <span class="badge bg-warning bg-opacity-10 text-warning" style="font-size: 0.65rem;">33.3%</span>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="fw-medium text-black"><span class="badge rounded-circle me-1" style="width: 8px; height: 8px; display: inline-block; background-color: #64748b;"></span> Magallanes Branch</span>
                    <div class="d-flex align-items-center gap-2">
                        <span class="text-black-50">₱200</span>
                        <span class="badge bg-secondary bg-opacity-10 text-secondary" style="font-size: 0.65rem;">44.4%</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>