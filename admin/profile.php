<?php
include 'includes/header.php';
?>
<div class="main-content">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h3 class="mb-1"><i class="fas fa-user-circle text-primary me-2"></i>Profile</h3>
            <div class="text-secondary small">Manage your profile information and account settings.</div>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-primary rounded-pill px-3">
                <i class="fas fa-undo me-2"></i>Reset
            </button>
            <button class="btn btn-primary rounded-pill px-3">
                <i class="fas fa-save me-2"></i>Save Changes
            </button>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-xl-3 col-lg-4">
            <div class="card border-0 rounded-4 shadow-sm text-center">
                <div class="card-body p-4">
                    <div class="mx-auto mb-3" style="width: 120px; height: 120px; border-radius: 50%; overflow: hidden; border: 4px solid #2563eb;">
                        <img src="https://ui-avatars.com/api/?name=Admin+User&background=2563eb&color=fff&size=120" alt="Profile" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <h5 class="fw-bold mb-0">Admin User</h5>
                    <div class="text-secondary small">Administrator</div>
                    <div class="mt-3">
                        <span class="status-badge bg-success-subtle text-success">🟢 Active</span>
                    </div>
                    <hr>
                    <div class="text-start">
                        <div class="d-flex justify-content-between py-2">
                            <span class="text-secondary">Staff ID</span>
                            <span class="fw-semibold">ADM-001</span>
                        </div>
                        <div class="d-flex justify-content-between py-2 border-top">
                            <span class="text-secondary">Department</span>
                            <span class="fw-semibold">Administration</span>
                        </div>
                        <div class="d-flex justify-content-between py-2 border-top">
                            <span class="text-secondary">Join Date</span>
                            <span class="fw-semibold">01 Jan 2020</span>
                        </div>
                        <div class="d-flex justify-content-between py-2 border-top">
                            <span class="text-secondary">Last Login</span>
                            <span class="fw-semibold">Today, 10:30 AM</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-9 col-lg-8">
            <div class="card border-0 rounded-4 shadow-sm">
                <div class="card-body p-4">
                    <ul class="nav nav-pills mb-4" id="profileTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="personal-tab" data-bs-toggle="pill" data-bs-target="#personal" type="button" role="tab">
                                <i class="fas fa-user me-2"></i>Personal
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="account-tab" data-bs-toggle="pill" data-bs-target="#account" type="button" role="tab">
                                <i class="fas fa-cog me-2"></i>Account
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="security-tab" data-bs-toggle="pill" data-bs-target="#security" type="button" role="tab">
                                <i class="fas fa-lock me-2"></i>Security
                            </button>
                        </li>
                    </ul>
                    <div class="tab-content" id="profileTabContent">
                        <div class="tab-pane fade show active" id="personal" role="tabpanel">
                            <h6 class="fw-bold mb-3"><i class="fas fa-user text-primary me-2"></i>Personal Information</h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" value="Admin User" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" value="admin@school.com" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Phone <span class="text-danger">*</span></label>
                                    <input type="tel" class="form-control" value="+91 98765 43210" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Gender</label>
                                    <select class="form-select">
                                        <option value="Male" selected>Male</option>
                                        <option value="Female">Female</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Date of Birth</label>
                                    <input type="date" class="form-control" value="1990-01-01">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Blood Group</label>
                                    <select class="form-select">
                                        <option value="A+">A+</option>
                                        <option value="A-">A-</option>
                                        <option value="B+" selected>B+</option>
                                        <option value="B-">B-</option>
                                        <option value="AB+">AB+</option>
                                        <option value="AB-">AB-</option>
                                        <option value="O+">O+</option>
                                        <option value="O-">O-</option>
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-semibold">Address</label>
                                    <textarea class="form-control" rows="2">123, Main Street, City, State - 123456</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="account" role="tabpanel">
                            <h6 class="fw-bold mb-3"><i class="fas fa-cog text-primary me-2"></i>Account Settings</h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Username <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" value="admin" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Role</label>
                                    <input type="text" class="form-control" value="Administrator" disabled style="background: #f8f9fa;">
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
                                    <label class="form-label fw-semibold">Time Zone</label>
                                    <select class="form-select">
                                        <option value="asia/kolkata" selected>Asia/Kolkata (UTC+5:30)</option>
                                        <option value="asia/dubai">Asia/Dubai (UTC+4)</option>
                                        <option value="europe/london">Europe/London</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="emailNotif" checked>
                                        <label class="form-check-label fw-semibold" for="emailNotif">Email Notifications</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="smsNotif">
                                        <label class="form-check-label fw-semibold" for="smsNotif">SMS Notifications</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="security" role="tabpanel">
                            <h6 class="fw-bold mb-3"><i class="fas fa-lock text-primary me-2"></i>Security Settings</h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Current Password <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" placeholder="Enter current password">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">New Password <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" placeholder="Enter new password">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Confirm Password <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" placeholder="Confirm new password">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Two Factor Authentication</label>
                                    <select class="form-select">
                                        <option value="disabled">Disabled</option>
                                        <option value="email">Email</option>
                                        <option value="phone">Phone</option>
                                        <option value="authenticator">Authenticator App</option>
                                    </select>
                                </div>
                                <div class="col-12 mt-3">
                                    <div class="alert alert-warning">
                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                        <strong>Note:</strong> Use a strong password with at least 8 characters, including uppercase, lowercase, numbers, and special characters.
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-warning rounded-pill px-4">
                                        <i class="fas fa-key me-2"></i>Change Password
                                    </button>
                                </div>
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