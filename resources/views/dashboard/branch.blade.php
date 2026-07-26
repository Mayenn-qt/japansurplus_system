<div class="row g-4 mb-4">
    <!-- Recent Sales Table -->
    <div class="col-lg-7">
        <div class="dashboard-card h-100 p-4 d-flex flex-column justify-content-between">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="fw-bold h6 mb-0 text-white">Recent Sales</div>
                    <a href="#" class="btn btn-dark btn-sm px-3 py-1 border border-secondary border-opacity-25 text-white-50 rounded-pill shadow-sm" style="font-size: 0.75rem;" onclick="showPage('reports', document.querySelector('[data-page=reports]')); return false;">View all</a>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-dark table-hover mb-0 align-middle" style="background-color: transparent; font-size: 0.8rem; border-collapse: separate; border-spacing: 0 6px;">
                        <thead>
                            <tr class="text-white-50" style="font-size: 0.7rem;">
                                <th class="ps-3 py-1 border-0">Invoice</th>
                                <th class="py-1 border-0">Customer</th>
                                <th class="py-1 border-0">Branch</th>
                                <th class="py-1 border-0">Amount</th>
                                <th class="pe-3 py-1 border-0 text-end">Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Row 1: Slate Tone 1 -->
                            <tr style="background-color: #1e293b; box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.04);">
                                <td class="ps-3 py-2 fw-semibold text-white rounded-start" style="border-top-left-radius: 6px; border-bottom-left-radius: 6px;">INV-10231</td>
                                <td class="py-2 text-white-50">Walk-in</td>
                                <td class="py-2"><span class="badge bg-dark border border-secondary border-opacity-50 text-white px-2 py-1 rounded-pill" style="font-size: 0.65rem;">Bacon</span></td>
                                <td class="py-2 fw-medium text-white">₱1,850</td>
                                <td class="pe-3 py-2 text-white-50 text-end rounded-end" style="border-top-right-radius: 6px; border-bottom-right-radius: 6px;">10:42 AM</td>
                            </tr>
                            <!-- Row 2: Slate Tone 2 (Soft Alternating Tint) -->
                            <tr style="background-color: #141c2e; box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.04);">
                                <td class="ps-3 py-2 fw-semibold text-white rounded-start" style="border-top-left-radius: 6px; border-bottom-left-radius: 6px;">INV-10230</td>
                                <td class="py-2 text-white-50">Walk-in</td>
                                <td class="py-2"><span class="badge bg-dark border border-secondary border-opacity-50 text-white px-2 py-1 rounded-pill" style="font-size: 0.65rem;">Sorsogon</span></td>
                                <td class="py-2 fw-medium text-white">₱4,200</td>
                                <td class="pe-3 py-2 text-white-50 text-end rounded-end" style="border-top-right-radius: 6px; border-bottom-right-radius: 6px;">10:15 AM</td>
                            </tr>
                            <!-- Row 3: Slate Tone 1 -->
                            <tr style="background-color: #1e293b; box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.04);">
                                <td class="ps-3 py-2 fw-semibold text-white rounded-start" style="border-top-left-radius: 6px; border-bottom-left-radius: 6px;">INV-10229</td>
                                <td class="py-2 text-white-50">Walk-in</td>
                                <td class="py-2"><span class="badge bg-dark border border-secondary border-opacity-50 text-white px-2 py-1 rounded-pill" style="font-size: 0.65rem;">Bacon</span></td>
                                <td class="py-2 fw-medium text-white">₱650</td>
                                <td class="pe-3 py-2 text-white-50 text-end rounded-end" style="border-top-right-radius: 6px; border-bottom-right-radius: 6px;">9:58 AM</td>
                            </tr>
                            <!-- Row 4: Slate Tone 2 -->
                            <tr style="background-color: #141c2e; box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.04);">
                                <td class="ps-3 py-2 fw-semibold text-white rounded-start" style="border-top-left-radius: 6px; border-bottom-left-radius: 6px;">INV-10228</td>
                                <td class="py-2 text-white-50">Walk-in</td>
                                <td class="py-2"><span class="badge bg-dark border border-secondary border-opacity-50 text-white px-2 py-1 rounded-pill" style="font-size: 0.65rem;">Juban</span></td>
                                <td class="py-2 fw-medium text-white">₱2,300</td>
                                <td class="pe-3 py-2 text-white-50 text-end rounded-end" style="border-top-right-radius: 6px; border-bottom-right-radius: 6px;">9:31 AM</td>
                            </tr>
                            <!-- Row 5: Slate Tone 1 -->
                            <tr style="background-color: #1e293b; box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.04);">
                                <td class="ps-3 py-2 fw-semibold text-white rounded-start" style="border-top-left-radius: 6px; border-bottom-left-radius: 6px;">INV-10227</td>
                                <td class="py-2 text-white-50">Walk-in</td>
                                <td class="py-2"><span class="badge bg-dark border border-secondary border-opacity-50 text-white px-2 py-1 rounded-pill" style="font-size: 0.65rem;">Sorsogon</span></td>
                                <td class="py-2 fw-medium text-white">₱980</td>
                                <td class="pe-3 py-2 text-white-50 text-end rounded-end" style="border-top-right-radius: 6px; border-bottom-right-radius: 6px;">9:02 AM</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Low Stock Products Table -->
    <div class="col-lg-5">
        <div class="dashboard-card h-100 p-4 d-flex flex-column justify-content-between">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="fw-bold h6 mb-0 text-white">Low Stock Products</div>
                    <a href="#" class="btn btn-dark btn-sm px-3 py-1 border border-secondary border-opacity-25 text-white-50 rounded-pill shadow-sm" style="font-size: 0.75rem;" onclick="showPage('stock', document.querySelector('[data-page=stock]')); return false;">Manage</a>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-dark table-hover mb-0 align-middle" style="background-color: transparent; font-size: 0.8rem; border-collapse: separate; border-spacing: 0 6px;">
                        <thead>
                            <tr class="text-white-50" style="font-size: 0.7rem;">
                                <th class="ps-3 py-1 border-0">Product</th>
                                <th class="py-1 border-0">Branch</th>
                                <th class="pe-3 py-1 border-0 text-end">Stock</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Row 1: Slate Tone 1 -->
                            <tr style="background-color: #1e293b; box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.04);">
                                <td class="ps-3 py-2 text-white fw-medium rounded-start" style="border-top-left-radius: 6px; border-bottom-left-radius: 6px;">Panasonic Rice Cooker</td>
                                <td class="py-2"><span class="badge bg-dark border border-secondary border-opacity-50 text-white px-2 py-1 rounded-pill" style="font-size: 0.65rem;">Sorsogon</span></td>
                                <td class="pe-3 py-2 text-end rounded-end" style="border-top-right-radius: 6px; border-bottom-right-radius: 6px;"><span class="badge bg-danger bg-opacity-25 text-danger border border-danger border-opacity-50 px-2.5 py-1 rounded-pill" style="font-size: 0.65rem;">0 left</span></td>
                            </tr>
                            <!-- Row 2: Slate Tone 2 -->
                            <tr style="background-color: #141c2e; box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.04);">
                                <td class="ps-3 py-2 text-white fw-medium rounded-start" style="border-top-left-radius: 6px; border-bottom-left-radius: 6px;">Sony Speaker Set</td>
                                <td class="py-2"><span class="badge bg-dark border border-secondary border-opacity-50 text-white px-2 py-1 rounded-pill" style="font-size: 0.65rem;">Juban</span></td>
                                <td class="pe-3 py-2 text-end rounded-end" style="border-top-right-radius: 6px; border-bottom-right-radius: 6px;"><span class="badge bg-danger bg-opacity-25 text-danger border border-danger border-opacity-50 px-2.5 py-1 rounded-pill" style="font-size: 0.65rem;">0 left</span></td>
                            </tr>
                            <!-- Row 3: Slate Tone 1 -->
                            <tr style="background-color: #1e293b; box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.04);">
                                <td class="ps-3 py-2 text-white fw-medium rounded-start" style="border-top-left-radius: 6px; border-bottom-left-radius: 6px;">Toshiba TV 32"</td>
                                <td class="py-2"><span class="badge bg-dark border border-secondary border-opacity-50 text-white px-2 py-1 rounded-pill" style="font-size: 0.65rem;">Sorsogon</span></td>
                                <td class="pe-3 py-2 text-end rounded-end" style="border-top-right-radius: 6px; border-bottom-right-radius: 6px;"><span class="badge bg-warning bg-opacity-25 text-warning border border-warning border-opacity-50 px-2.5 py-1 rounded-pill" style="font-size: 0.65rem;">1 left</span></td>
                            </tr>
                            <!-- Row 4: Slate Tone 2 -->
                            <tr style="background-color: #141c2e; box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.04);">
                                <td class="ps-3 py-2 text-white fw-medium rounded-start" style="border-top-left-radius: 6px; border-bottom-left-radius: 6px;">Sanyo Microwave</td>
                                <td class="py-2"><span class="badge bg-dark border border-secondary border-opacity-50 text-white px-2 py-1 rounded-pill" style="font-size: 0.65rem;">Bacon</span></td>
                                <td class="pe-3 py-2 text-end rounded-end" style="border-top-right-radius: 6px; border-bottom-right-radius: 6px;"><span class="badge bg-warning bg-opacity-25 text-warning border border-warning border-opacity-50 px-2.5 py-1 rounded-pill" style="font-size: 0.65rem;">1 left</span></td>
                            </tr>
                            <!-- Row 5: Slate Tone 1 -->
                            <tr style="background-color: #1e293b; box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.04);">
                                <td class="ps-3 py-2 text-white fw-medium rounded-start" style="border-top-left-radius: 6px; border-bottom-left-radius: 6px;">Wooden Study Desk</td>
                                <td class="py-2"><span class="badge bg-dark border border-secondary border-opacity-50 text-white px-2 py-1 rounded-pill" style="font-size: 0.65rem;">Sorsogon</span></td>
                                <td class="pe-3 py-2 text-end rounded-end" style="border-top-right-radius: 6px; border-bottom-right-radius: 6px;"><span class="badge bg-warning bg-opacity-25 text-warning border border-warning border-opacity-50 px-2.5 py-1 rounded-pill" style="font-size: 0.65rem;">1 left</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>