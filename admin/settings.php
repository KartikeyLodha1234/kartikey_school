<?php
include 'includes/header.php';
?>
<div class="main-content">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h3 class="mb-1"><i class="fas fa-cog text-primary me-2"></i>Settings</h3>
            <div class="text-secondary small">Manage school system settings and configurations.</div>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-primary rounded-pill px-3">
                <i class="fas fa-undo me-2"></i>Reset
            </button>
            <button class="btn btn-primary rounded-pill px-3">
                <i class="fas fa-save me-2"></i>Save Settings
            </button>
        </div>
    </div>
    <div class="card border-0 rounded-4 shadow-sm">
        <div class="card-body">
            <ul class="nav nav-pills mb-4" id="settingsTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="general-tab" data-bs-toggle="pill" data-bs-target="#general" type="button" role="tab">
                        <i class="fas fa-home me-2"></i>General
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="school-tab" data-bs-toggle="pill" data-bs-target="#school" type="button" role="tab">
                        <i class="fas fa-school me-2"></i>School
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="academic-tab" data-bs-toggle="pill" data-bs-target="#academic" type="button" role="tab">
                        <i class="fas fa-book me-2"></i>Academic
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="fee-tab" data-bs-toggle="pill" data-bs-target="#fee" type="button" role="tab">
                        <i class="fas fa-coins me-2"></i>Fee
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="email-tab" data-bs-toggle="pill" data-bs-target="#email" type="button" role="tab">
                        <i class="fas fa-envelope me-2"></i>Email
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="backup-tab" data-bs-toggle="pill" data-bs-target="#backup" type="button" role="tab">
                        <i class="fas fa-database me-2"></i>Backup
                    </button>
                </li>
            </ul>
            <div class="tab-content" id="settingsTabContent">
                <div class="tab-pane fade show active" id="general" role="tabpanel">
                    <h6 class="fw-bold mb-3"><i class="fas fa-home text-primary me-2"></i>General Settings</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">System Name</label>
                            <input type="text" class="form-control" placeholder="School ERP" value="School ERP">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">System Version</label>
                            <input type="text" class="form-control" placeholder="v2.4.0" value="v2.4.0">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Time Zone</label>
                            <select class="form-select">
                                <option value="asia/kolkata" selected>Asia/Kolkata (UTC+5:30)</option>
                                <option value="asia/dubai">Asia/Dubai (UTC+4)</option>
                                <option value="europe/london">Europe/London</option>
                                <option value="america/new_york">America/New York</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Date Format</label>
                            <select class="form-select">
                                <option value="d-m-y" selected>DD-MM-YYYY</option>
                                <option value="m-d-y">MM-DD-YYYY</option>
                                <option value="y-m-d">YYYY-MM-DD</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Language</label>
                            <select class="form-select">
                                <option value="english" selected>English</option>
                                <option value="hindi">Hindi</option>
                                <option value="marathi">Marathi</option>
                                <option value="gujarati">Gujarati</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Currency</label>
                            <select class="form-select">
                                <option value="inr" selected>₹ Indian Rupee</option>
                                <option value="usd">$ US Dollar</option>
                                <option value="eur">€ Euro</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="school" role="tabpanel">
                    <h6 class="fw-bold mb-3"><i class="fas fa-school text-primary me-2"></i>School Settings</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">School Name</label>
                            <input type="text" class="form-control" placeholder="School Name" value="International School">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">School Code</label>
                            <input type="text" class="form-control" placeholder="SCH-001" value="SCH-001">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Principal Name</label>
                            <input type="text" class="form-control" placeholder="Dr. Principal">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">School Email</label>
                            <input type="email" class="form-control" placeholder="school@example.com">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">School Phone</label>
                            <input type="tel" class="form-control" placeholder="+91 98765 43210">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Establishment Year</label>
                            <input type="number" class="form-control" placeholder="2000" value="2000">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-semibold">School Address</label>
                            <textarea class="form-control" rows="2" placeholder="Full School Address"></textarea>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="academic" role="tabpanel">
                    <h6 class="fw-bold mb-3"><i class="fas fa-book text-primary me-2"></i>Academic Settings</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Current Academic Year</label>
                            <select class="form-select">
                                <option value="2024-25">2024-25</option>
                                <option value="2025-26" selected>2025-26</option>
                                <option value="2026-27">2026-27</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Session Start</label>
                            <input type="date" class="form-control" value="2025-06-01">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Session End</label>
                            <input type="date" class="form-control" value="2026-04-30">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Promotion Month</label>
                            <select class="form-select">
                                <option value="March">March</option>
                                <option value="April" selected>April</option>
                                <option value="May">May</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="fee" role="tabpanel">
                    <h6 class="fw-bold mb-3"><i class="fas fa-coins text-primary me-2"></i>Fee Settings</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Late Fee Charge (₹)</label>
                            <input type="number" class="form-control" placeholder="100" value="100">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Late Fee Days</label>
                            <input type="number" class="form-control" placeholder="10" value="10">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">GST (%)</label>
                            <input type="number" class="form-control" placeholder="18" value="18">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Transport Fee (₹)</label>
                            <input type="number" class="form-control" placeholder="1500" value="1500">
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="email" role="tabpanel">
                    <h6 class="fw-bold mb-3"><i class="fas fa-envelope text-primary me-2"></i>Email Settings</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">SMTP Server</label>
                            <input type="text" class="form-control" placeholder="smtp.example.com">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">SMTP Port</label>
                            <input type="number" class="form-control" placeholder="587" value="587">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Email Username</label>
                            <input type="email" class="form-control" placeholder="email@example.com">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Email Password</label>
                            <input type="password" class="form-control" placeholder="••••••••">
                        </div>
                        <div class="col-md-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="enableEmail">
                                <label class="form-check-label" for="enableEmail">
                                    Enable Email Notifications
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="backup" role="tabpanel">
                    <h6 class="fw-bold mb-3"><i class="fas fa-database text-primary me-2"></i>Backup Settings</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Auto Backup</label>
                            <select class="form-select">
                                <option value="daily">Daily</option>
                                <option value="weekly" selected>Weekly</option>
                                <option value="monthly">Monthly</option>
                                <option value="off">Off</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Backup Time</label>
                            <input type="time" class="form-control" value="02:00">
                        </div>
                        <div class="col-md-12">
                            <div class="d-flex gap-2">
                                <button class="btn btn-primary rounded-pill px-4">
                                    <i class="fas fa-download me-2"></i>Download Backup
                                </button>
                                <button class="btn btn-outline-secondary rounded-pill px-4">
                                    <i class="fas fa-upload me-2"></i>Restore Backup
                                </button>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                Last backup: 03 Aug 2025, 02:00 AM
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include 'includes/footer.php';
?>