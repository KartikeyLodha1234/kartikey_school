<?php
include 'includes/header.php';
?>
<div class="main-content">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h3 class="mb-1">Admission</h3>
            <div class="text-secondary small">Manage student admissions, applications, and enrollments</div>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-primary rounded-pill px-3">
                <i class="fas fa-file-export me-2"></i>Export
            </button>
        </div>
    </div>

    <div class="card border-0 rounded-4 shadow-sm mb-4">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                <h5 class="mb-0">Add New Admission</h5>
                <span class="text-secondary small">Create a new admission record for a student</span>
            </div>

            <form class="row g-3">
                <h6 class="fw-bold mb-3"><i class="fas fa-user text-primary me-2"></i>Personal Information</h6>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Passport Photo</label>
                    <input type="file" class="form-control" id="photo" accept=".jpg,.png,.pdf" />
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Student Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" placeholder="John Doe" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Date of Birth <span class="text-danger">*</span></label>
                    <input type="date" class="form-control" required>
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
                <div class="col-12">
                    <h6 class="fw-bold mb-3 mt-2"><i class="fas fa-address-card text-primary me-2"></i>Parent / Guardian
                        Details</h6>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Father Name<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" placeholder="Father Name">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Mother Name<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" placeholder="Mother Name">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Parent Contact<span class="text-danger">*</span></label>
                    <input type="tel" class="form-control" placeholder="+91 98765 43210">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Parent Email<span class="text-danger">*</span></label>
                    <input type="email" class="form-control" placeholder="parent@example.com">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Father Aadhaar<span class="text-danger">*</span></label>
                    <input type="file" class="form-control" name="father_aadhaar" accept=".jpg,.png,.pdf">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Mother Aadhaar<span class="text-danger">*</span></label>
                    <input type="file" class="form-control" name="mother_aadhaar" accept=".jpg,.png,.pdf">
                </div>
                <div class="col-md-12">
                    <label class="form-label fw-semibold">Address<span class="text-danger">*</span></label>
                    <textarea class="form-control" rows="2" placeholder="Full Address"></textarea>
                </div>
                <div class="col-12">
                    <h6 class="fw-bold mb-3 mt-4"><i class="fas fa-book-open text-primary me-2"></i>Academic Details
                    </h6>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Applying for Class <span class="text-danger">*</span></label>
                    <select class="form-select" required>
                        <option value="">Select Class</option>
                        <option value="1">Grade 1</option>
                        <option value="2">Grade 2</option>
                        <option value="3">Grade 3</option>
                        <option value="4">Grade 4</option>
                        <option value="5">Grade 5</option>
                        <option value="6">Grade 6</option>
                        <option value="7">Grade 7</option>
                        <option value="8">Grade 8</option>
                        <option value="9">Grade 9</option>
                        <option value="10">Grade 10</option>
                        <option value="11">Grade 11</option>
                        <option value="12">Grade 12</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Previous School<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" placeholder="Previous School Name" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Previous Class<span class="text-danger">*</span></label>
                    <select class="form-select" required>
                        <option value="">Select Previous Class</option>
                        <option value="1">Grade 1</option>
                        <option value="2">Grade 2</option>
                        <option value="3">Grade 3</option>
                        <option value="4">Grade 4</option>
                        <option value="5">Grade 5</option>
                        <option value="6">Grade 6</option>
                        <option value="7">Grade 7</option>
                        <option value="8">Grade 8</option>
                        <option value="9">Grade 9</option>
                        <option value="10">Grade 10</option>
                        <option value="11">Grade 11</option>
                        <option value="12">Grade 12</option>
                    </select>
                </div>
                <h6 class="fw-bold mb-3 mt-4"><i class="fas fa-file-upload text-primary me-2"></i>Documents Upload</h6>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Birth Certificate</label>
                        <input type="file" class="form-control" id="birthCertificate" accept=".pdf,.jpg,.png" />
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Previous Marksheet</label>
                        <input type="file" class="form-control" id="marksheet" accept=".pdf,.jpg,.png" />
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Transfer Certificate (TC)</label>
                        <input type="file" class="form-control" id="tcCertificate" accept=".pdf,.jpg,.png" />
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Student Aadhaar</label>
                        <input type="file" class="form-control" id="aadhaar" accept=".jpg,.png,.pdf" />
                    </div>
                </div>
                <div class="col-12 d-flex justify-content-end gap-2 mt-3">
                    <button type="reset" class="btn btn-outline-secondary rounded-pill px-4">
                        <i class="fas fa-undo me-2"></i>Reset
                    </button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">
                        <i class="fas fa-save me-2"></i>Submit Admission
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
include 'includes/footer.php';
?>