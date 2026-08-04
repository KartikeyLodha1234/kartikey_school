<?php
include 'includes/header.php';
?>
<div class="main-content">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h3 class="mb-1">Add Staff</h3>
            <div class="text-secondary small">Register new staff members.</div>
        </div>
    </div>
    <div class="card border-0 rounded-4 shadow-sm mb-4">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                <h5 class="mb-0"><i class="fas fa-user-plus text-primary me-2"></i>Add New Staff</h5>
                <span class="text-secondary small">Create a new staff record</span>
            </div>
            <form class="row g-3">
                <div class="col-12">
                    <h6 class="fw-bold mb-2" style="color: #2563eb; border-bottom: 2px solid #e5e7eb; padding-bottom: 8px;">
                        <i class="fas fa-user me-2"></i>Personal Information
                    </h6>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Staff ID</label>
                    <input type="text" class="form-control" placeholder="e.g., STF-001" value="STF-006">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" placeholder="Staff full name" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Gender <span class="text-danger">*</span></label>
                    <select class="form-select" required>
                        <option value="">Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Date of Birth</label>
                    <input type="date" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Blood Group</label>
                    <select class="form-select">
                        <option value="">Select Blood Group</option>
                        <option value="A+">A+</option>
                        <option value="A-">A-</option>
                        <option value="B+">B+</option>
                        <option value="B-">B-</option>
                        <option value="AB+">AB+</option>
                        <option value="AB-">AB-</option>
                        <option value="O+">O+</option>
                        <option value="O-">O-</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Nationality</label>
                    <input type="text" class="form-control" placeholder="e.g., Indian" value="Indian">
                </div>
                <div class="col-12 mt-3">
                    <h6 class="fw-bold mb-2" style="color: #2563eb; border-bottom: 2px solid #e5e7eb; padding-bottom: 8px;">
                        <i class="fas fa-address-card me-2"></i>Contact Information
                    </h6>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" placeholder="staff@example.com" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Phone <span class="text-danger">*</span></label>
                    <input type="tel" class="form-control" placeholder="+91 98765 43210" required>
                </div>

                <div class="col-md-12">
                    <label class="form-label fw-semibold">Address</label>
                    <textarea class="form-control" rows="2" placeholder="Full address"></textarea>
                </div>
                <div class="col-12 mt-3">
                    <h6 class="fw-bold mb-2" style="color: #2563eb; border-bottom: 2px solid #e5e7eb; padding-bottom: 8px;">
                        <i class="fas fa-briefcase me-2"></i>Employment Details
                    </h6>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Designation <span class="text-danger">*</span></label>
                    <select class="form-select" required>
                        <option value="">Select Designation</option>
                        <option value="teacher">Teacher</option>
                        <option value="principal">Principal</option>
                        <option value="admin">Admin Staff</option>
                        <option value="accountant">Accountant</option>
                        <option value="librarian">Librarian</option>
                        <option value="peon">Peon</option>
                        <option value="driver">Driver</option>
                        <option value="security">Security</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Department</label>
                    <select class="form-select">
                        <option value="">Select Department</option>
                        <option value="science">Science</option>
                        <option value="maths">Mathematics</option>
                        <option value="english">English</option>
                        <option value="hindi">Hindi</option>
                        <option value="social">Social Studies</option>
                        <option value="computer">Computer Science</option>
                        <option value="arts">Arts</option>
                        <option value="sports">Sports</option>
                        <option value="admin">Administration</option>
                        <option value="accounts">Accounts</option>
                        <option value="transport">Transport</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Qualification</label>
                    <input type="text" class="form-control" placeholder="e.g., M.Sc, B.Ed">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Experience (Years)</label>
                    <input type="number" class="form-control" placeholder="e.g., 5" min="0">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Join Date <span class="text-danger">*</span></label>
                    <input type="date" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Contract Type</label>
                    <select class="form-select">
                        <option value="permanent">Permanent</option>
                        <option value="contract">Contract</option>
                        <option value="probation">Probation</option>
                        <option value="part_time">Part Time</option>
                        <option value="temporary">Temporary</option>
                    </select>
                </div>
                <div class="col-12 mt-3">
                    <h6 class="fw-bold mb-2" style="color: #2563eb; border-bottom: 2px solid #e5e7eb; padding-bottom: 8px;">
                        <i class="fas fa-rupee-sign me-2"></i>Salary Details
                    </h6>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Salary (₹) <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" placeholder="e.g., 25000" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Bank Name</label>
                    <input type="text" class="form-control" placeholder="Bank name">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Account Number</label>
                    <input type="text" class="form-control" placeholder="Bank account number">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">PAN Number</label>
                    <input type="text" class="form-control" placeholder="e.g., ABCDE1234F">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Aadhar Number</label>
                    <input type="text" class="form-control" placeholder="e.g., 1234 5678 9012">
                </div>
                <div class="col-12 mt-3">
                    <h6 class="fw-bold mb-2" style="color: #2563eb; border-bottom: 2px solid #e5e7eb; padding-bottom: 8px;">
                        <i class="fas fa-file-upload me-2"></i>Documents
                    </h6>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Photo</label>
                    <input type="file" class="form-control" accept=".jpg,.png">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Resume/CV</label>
                    <input type="file" class="form-control" accept=".pdf,.doc,.docx">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Certificates</label>
                    <input type="file" class="form-control" accept=".pdf,.jpg,.png">
                </div>
                <div class="col-12 mt-3">
                    <h6 class="fw-bold mb-2" style="color: #2563eb; border-bottom: 2px solid #e5e7eb; padding-bottom: 8px;">
                        <i class="fas fa-info-circle me-2"></i>Status
                    </h6>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Employment Status</label>
                    <select class="form-select">
                        <option value="Active">🟢 Active</option>
                        <option value="Inactive">🔴 Inactive</option>
                        <option value="On Leave">🟡 On Leave</option>
                        <option value="Resigned">⚫ Resigned</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Remarks</label>
                    <input type="text" class="form-control" placeholder="Any additional notes...">
                </div>
                <div class="col-12 d-flex justify-content-end gap-2 mt-3">
                    <button type="reset" class="btn btn-outline-secondary rounded-pill px-4">
                        <i class="fas fa-undo me-2"></i>Reset
                    </button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">
                        <i class="fas fa-save me-2"></i>Save Staff
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
include 'includes/footer.php';
?>