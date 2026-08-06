<?php
ob_start();
include '../config/config.php';
include 'includes/auth_check.php'; 
checkRole(['admin']);

// ====== PASSWORD GENERATE FUNCTION ======
function generatePassword($length = 8) {
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$';
    $password = '';
    for ($i = 0; $i < $length; $i++) {
        $password .= $chars[rand(0, strlen($chars) - 1)];
    }
    return $password;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_admission'])) {
    // Personal Information
    $name = trim($_POST['name'] ?? '');
    $dob = trim($_POST['dob'] ?? '');
    $gender = trim($_POST['gender'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $father_name = trim($_POST['father_name'] ?? '');
    $mother_name = trim($_POST['mother_name'] ?? '');
    $parent_phone = trim($_POST['parent_phone'] ?? '');
    $parent_email = trim($_POST['parent_email'] ?? '');
    $class_id = intval($_POST['class_id'] ?? 0);
    $section_id = intval($_POST['section_id'] ?? 0);
    $student_type = trim($_POST['student_type'] ?? 'Non-RTO');
    $admission_fees = floatval($_POST['admission_fees'] ?? 0);
    $blood_group = trim($_POST['blood_group'] ?? '');
    
    // ====== MANUAL PASSWORD ======
    $student_password = trim($_POST['student_password'] ?? '');
    if (empty($student_password)) {
        $student_password = generatePassword(8);
    }
    $hashed_password = password_hash($student_password, PASSWORD_DEFAULT);
    
    $admission_no = 'ADM-' . date('Y') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
    
    if ($name === '' || $dob === '' || $gender === '' || $class_id === 0) {
        $error = 'Please fill in all required fields.';
    } else {
        try {
            $conn->beginTransaction();
            
            $stmt = $conn->prepare("SELECT id FROM students WHERE admission_no = ?");
            $stmt->execute([$admission_no]);
            if ($stmt->rowCount() > 0) {
                $admission_no = 'ADM-' . date('Y') . '-' . str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT);
            }
            
            $upload_dir = '../uploads/students/';
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }            
            
            // File uploads...
            $photo = '';
            if (isset($_FILES['photo']) && $_FILES['photo']['error'] === 0) {
                $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
                $photo = 'photo_' . time() . '_' . rand(1000, 9999) . '.' . $ext;
                move_uploaded_file($_FILES['photo']['tmp_name'], $upload_dir . $photo);
            }
            
            $birth_certificate = '';
            if (isset($_FILES['birth_certificate']) && $_FILES['birth_certificate']['error'] === 0) {
                $ext = pathinfo($_FILES['birth_certificate']['name'], PATHINFO_EXTENSION);
                $birth_certificate = 'birth_' . time() . '_' . rand(1000, 9999) . '.' . $ext;
                move_uploaded_file($_FILES['birth_certificate']['tmp_name'], $upload_dir . $birth_certificate);
            }
            
            $marksheet = '';
            if (isset($_FILES['marksheet']) && $_FILES['marksheet']['error'] === 0) {
                $ext = pathinfo($_FILES['marksheet']['name'], PATHINFO_EXTENSION);
                $marksheet = 'marksheet_' . time() . '_' . rand(1000, 9999) . '.' . $ext;
                move_uploaded_file($_FILES['marksheet']['tmp_name'], $upload_dir . $marksheet);
            }
            
            $tc_certificate = '';
            if (isset($_FILES['tc_certificate']) && $_FILES['tc_certificate']['error'] === 0) {
                $ext = pathinfo($_FILES['tc_certificate']['name'], PATHINFO_EXTENSION);
                $tc_certificate = 'tc_' . time() . '_' . rand(1000, 9999) . '.' . $ext;
                move_uploaded_file($_FILES['tc_certificate']['tmp_name'], $upload_dir . $tc_certificate);
            }
            
            $aadhaar = '';
            if (isset($_FILES['aadhaar']) && $_FILES['aadhaar']['error'] === 0) {
                $ext = pathinfo($_FILES['aadhaar']['name'], PATHINFO_EXTENSION);
                $aadhaar = 'aadhaar_' . time() . '_' . rand(1000, 9999) . '.' . $ext;
                move_uploaded_file($_FILES['aadhaar']['tmp_name'], $upload_dir . $aadhaar);
            }
            
            $father_aadhaar = '';
            if (isset($_FILES['father_aadhaar']) && $_FILES['father_aadhaar']['error'] === 0) {
                $ext = pathinfo($_FILES['father_aadhaar']['name'], PATHINFO_EXTENSION);
                $father_aadhaar = 'father_aadhaar_' . time() . '_' . rand(1000, 9999) . '.' . $ext;
                move_uploaded_file($_FILES['father_aadhaar']['tmp_name'], $upload_dir . $father_aadhaar);
            }
            
            $mother_aadhaar = '';
            if (isset($_FILES['mother_aadhaar']) && $_FILES['mother_aadhaar']['error'] === 0) {
                $ext = pathinfo($_FILES['mother_aadhaar']['name'], PATHINFO_EXTENSION);
                $mother_aadhaar = 'mother_aadhaar_' . time() . '_' . rand(1000, 9999) . '.' . $ext;
                move_uploaded_file($_FILES['mother_aadhaar']['tmp_name'], $upload_dir . $mother_aadhaar);
            }
            
            // ====== INSERT STUDENT ======
            $stmt = $conn->prepare("INSERT INTO students (admission_no, name, class_id, section_id, gender, dob, phone, email, address, father_name, mother_name, parent_phone, parent_email, photo, birth_certificate, marksheet, tc_certificate, aadhaar, father_aadhaar, mother_aadhaar, student_type, admission_fees, blood_group, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Active')");
            $stmt->execute([$admission_no, $name, $class_id, $section_id, $gender, $dob, $phone, $email, $address, $father_name, $mother_name, $parent_phone, $parent_email, $photo, $birth_certificate, $marksheet, $tc_certificate, $aadhaar, $father_aadhaar, $mother_aadhaar, $student_type, $admission_fees, $blood_group]);
            
            $student_id = $conn->lastInsertId();
            
            // ====== CREATE STUDENT LOGIN ======
            $username = strtolower(str_replace(' ', '_', $name)) . '_' . $student_id;
            
            // Check if user already exists
            $stmt = $conn->prepare("SELECT id FROM users WHERE student_id = ?");
            $stmt->execute([$student_id]);
            if ($stmt->rowCount() == 0) {
                $stmt = $conn->prepare("INSERT INTO users (name, email, password, role, student_id, username) VALUES (?, ?, ?, 'student', ?, ?)");
                $stmt->execute([$name, $email, $hashed_password, $student_id, $username]);
            }
            
            $conn->commit();
            
            $_SESSION['success'] = '✅ Student admitted successfully!<br>Admission No: ' . $admission_no . '<br>Username: ' . $username . '<br>Password: ' . $student_password;
            ob_end_clean();
            header('Location: admission.php?success=1');
            exit();
            
        } catch (Exception $e) {
            $conn->rollBack();
            $error = 'Database error: ' . $e->getMessage();
        }
    }
}

try {
    $stmt = $conn->query("SELECT class_id, amount FROM fees WHERE fee_type = 'Admission' AND status = 'Active' ORDER BY class_id");
    $admission_fee_map = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $admission_fee_map[(int)$row['class_id']] = (float)$row['amount'];
    }
} catch (Exception $e) {
    $admission_fee_map = [];
}

try {
    $stmt = $conn->query("SELECT id, class_name FROM classes WHERE status = 'Active' ORDER BY class_name");
    $classes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $classes = [];
}

try {
    $stmt = $conn->query("SELECT s.*, c.class_name FROM sections s LEFT JOIN classes c ON s.class_id = c.id ORDER BY c.class_name, s.section_name");
    $sections = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $sections = [];
}

try {
    $stmt = $conn->query("SELECT s.*, c.class_name, sec.section_name FROM students s LEFT JOIN classes c ON s.class_id = c.id LEFT JOIN sections sec ON s.section_id = sec.id ORDER BY s.id DESC LIMIT 10");
    $recent_admissions = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $recent_admissions = [];
}

try {
    $stmt = $conn->query("SELECT COUNT(*) as total FROM students");
    $total_students = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
} catch (Exception $e) {
    $total_students = 0;
}

try {
    $stmt = $conn->query("SELECT COUNT(*) as total FROM students WHERE status = 'Active'");
    $active_students = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
} catch (Exception $e) {
    $active_students = 0;
}

try {
    $stmt = $conn->query("SELECT COUNT(*) as total FROM students WHERE DATE(created_at) = CURDATE()");
    $today_admissions = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
} catch (Exception $e) {
    $today_admissions = 0;
}

include 'includes/header.php';
?>

<style>
.password-input-group {
    display: flex;
    gap: 8px;
}
.password-input-group input {
    flex: 1;
}
.password-input-group .btn-generate {
    white-space: nowrap;
    padding: 8px 15px;
}
.credential-box {
    background: #f8f9fa;
    padding: 8px 12px;
    border-radius: 4px;
    border: 1px dashed #86efac;
    display: inline-block;
    font-family: monospace;
    font-size: 14px;
    margin-top: 4px;
}
</style>

<div class="main-content">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h3 class="mb-1"><i class="fas fa-user-graduate text-primary me-2"></i>Admission</h3>
            <div class="text-secondary small">Manage student admissions, applications, and enrollments</div>
        </div>
        <div>
            <a href="student_report.php" class="btn btn-outline-primary rounded-pill px-3">
                <i class="fas fa-list me-2"></i>View All Students
            </a>
        </div>
    </div>
    
    <?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show rounded-4" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        <?= nl2br(htmlspecialchars($_SESSION['success'])) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (isset($error)): ?>
    <div class="alert alert-danger alert-dismissible fade show rounded-4" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i><?= htmlspecialchars($error) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <!-- ====== STATISTICS CARDS ====== -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 rounded-4 shadow-sm">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-secondary small">Total Students</div>
                            <h3 class="mb-0 fw-bold"><?= $total_students ?></h3>
                            <div class="text-secondary small">All students</div>
                        </div>
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-users text-primary fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 rounded-4 shadow-sm">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-secondary small">Active Students</div>
                            <h3 class="mb-0 fw-bold text-success"><?= $active_students ?></h3>
                            <div class="text-secondary small">Currently active</div>
                        </div>
                        <div class="bg-success bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-check-circle text-success fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 rounded-4 shadow-sm">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-secondary small">Today's Admissions</div>
                            <h3 class="mb-0 fw-bold text-info"><?= $today_admissions ?></h3>
                            <div class="text-secondary small">New enrollments today</div>
                        </div>
                        <div class="bg-info bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-calendar-plus text-info fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 rounded-4 shadow-sm">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-secondary small">Total Classes</div>
                            <h3 class="mb-0 fw-bold text-warning"><?= count($classes) ?></h3>
                            <div class="text-secondary small">Active classes</div>
                        </div>
                        <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-school text-warning fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 rounded-4 shadow-sm mb-4">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                <h5 class="mb-0"><i class="fas fa-plus-circle text-primary me-2"></i>Add New Admission</h5>
                <span class="text-secondary small">Create a new admission record for a student</span>
            </div>
            
            <form class="row g-3" method="post" enctype="multipart/form-data">
                <input type="hidden" name="add_admission" value="1">
                
                <!-- Personal Information -->
                <div class="col-12">
                    <h6 class="fw-bold mb-3"><i class="fas fa-user text-primary me-2"></i>Personal Information</h6>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Student Photo</label>
                    <input type="file" class="form-control" name="photo" accept=".jpg,.png,.jpeg,.gif" />
                    <small class="text-secondary">Max size: 2MB (JPG, PNG)</small>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Student Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="name" placeholder="John Doe" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Date of Birth <span class="text-danger">*</span></label>
                    <input type="date" class="form-control" name="dob" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Gender <span class="text-danger">*</span></label>
                    <select class="form-select" name="gender" required>
                        <option value="">Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Phone</label>
                    <input type="tel" class="form-control" name="phone" placeholder="+91 98765 43210">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Blood Group</label>
                    <select class="form-select" name="blood_group">
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
                    <label class="form-label fw-semibold">Email</label>
                    <input type="email" class="form-control" name="email" placeholder="student@example.com">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Address</label>
                    <input type="text" class="form-control" name="address" placeholder="Full Address">
                </div>

                <!-- Parent Details -->
                <div class="col-12">
                    <h6 class="fw-bold mb-3 mt-2"><i class="fas fa-address-card text-primary me-2"></i>Parent / Guardian Details</h6>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Father Name</label>
                    <input type="text" class="form-control" name="father_name" placeholder="Father Name">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Mother Name</label>
                    <input type="text" class="form-control" name="mother_name" placeholder="Mother Name">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Parent Phone <span class="text-danger">*</span></label>
                    <input type="tel" class="form-control" name="parent_phone" placeholder="+91 98765 43210" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Parent Email</label>
                    <input type="email" class="form-control" name="parent_email" placeholder="parent@example.com">
                </div>

                <!-- Aadhaar Documents -->
                <div class="col-12">
                    <h6 class="fw-bold mb-3 mt-4"><i class="fas fa-id-card text-primary me-2"></i>Aadhaar Documents</h6>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Father Aadhaar</label>
                    <input type="file" class="form-control" name="father_aadhaar" accept=".jpg,.png,.jpeg,.pdf">
                    <small class="text-secondary">Upload Father's Aadhaar</small>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Mother Aadhaar</label>
                    <input type="file" class="form-control" name="mother_aadhaar" accept=".jpg,.png,.jpeg,.pdf">
                    <small class="text-secondary">Upload Mother's Aadhaar</small>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Student Aadhaar</label>
                    <input type="file" class="form-control" name="aadhaar" accept=".jpg,.png,.jpeg,.pdf">
                    <small class="text-secondary">Upload Student's Aadhaar</small>
                </div>

                <!-- Academic Details -->
                <div class="col-12">
                    <h6 class="fw-bold mb-3 mt-4"><i class="fas fa-book-open text-primary me-2"></i>Academic Details</h6>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Class <span class="text-danger">*</span></label>
                    <select class="form-select" name="class_id" id="classSelect" required>
                        <option value="">Select Class</option>
                        <?php foreach ($classes as $class): ?>
                        <option value="<?= $class['id'] ?>"><?= htmlspecialchars($class['class_name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (count($classes) == 0): ?>
                    <small class="text-danger">No classes found. Please <a href="classes.php">add a class</a> first.</small>
                    <?php endif; ?>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Section</label>
                    <select class="form-select" name="section_id">
                        <option value="">Select Section</option>
                        <?php foreach ($sections as $section): ?>
                        <option value="<?= $section['id'] ?>"><?= htmlspecialchars($section['section_name']) ?> (<?= htmlspecialchars($section['class_name']) ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Admission No</label>
                    <input type="text" class="form-control" value="Auto-generated" disabled>
                    <small class="text-secondary">Will be auto-generated on submit</small>
                </div>

                <!-- Fee Details -->
                <div class="col-12">
                    <h6 class="fw-bold mb-3 mt-4"><i class="fas fa-tag text-primary me-2"></i>Fee Details</h6>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Student Type</label>
                    <select class="form-select" name="student_type" id="studentType">
                        <option value="Non-RTO">Non-RTO</option>
                        <option value="RTO">RTO</option>
                    </select>
                    <small class="text-secondary">RTO - Right to Education (No fees), Non-RTO - General (Fee applicable)</small>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Admission Fees (₹)</label>
                    <input type="number" class="form-control" id="admission_fees" name="admission_fees" placeholder="Select class first" min="0" step="0.01" readonly>
                    <small class="text-secondary">Auto-filled from fees.php (Admission fee type)</small>
                </div>

                <!-- ====== MANUAL PASSWORD SECTION ====== -->
                <div class="col-12">
                    <h6 class="fw-bold mb-3 mt-4"><i class="fas fa-lock text-primary me-2"></i>Login Credentials</h6>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Username (Auto-generated)</label>
                    <input type="text" class="form-control" id="usernamePreview" value="student_name_id" readonly style="background:#f8f9fa;">
                    <small class="text-secondary">Auto-generated from student name</small>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Set Password</label>
                    <div class="password-input-group">
                        <input type="text" class="form-control" name="student_password" 
                               id="studentPassword" placeholder="Enter password or auto-generate">
                        <button type="button" class="btn btn-outline-secondary btn-generate" onclick="generateManualPassword()">
                            <i class="fas fa-sync"></i> Generate
                        </button>
                    </div>
                    <small class="text-secondary">Leave empty to auto-generate 8 character password</small>
                </div>

                <!-- Other Documents -->
                <div class="col-12">
                    <h6 class="fw-bold mb-3 mt-4"><i class="fas fa-file-upload text-primary me-2"></i>Other Documents</h6>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Birth Certificate</label>
                    <input type="file" class="form-control" name="birth_certificate" accept=".pdf,.jpg,.png,.jpeg">
                    <small class="text-secondary">Upload Birth Certificate</small>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Previous Marksheet</label>
                    <input type="file" class="form-control" name="marksheet" accept=".pdf,.jpg,.png,.jpeg">
                    <small class="text-secondary">Upload Previous Marksheet</small>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Transfer Certificate (TC)</label>
                    <input type="file" class="form-control" name="tc_certificate" accept=".pdf,.jpg,.png,.jpeg">
                    <small class="text-secondary">Upload Transfer Certificate</small>
                </div>

                <div class="col-12 d-flex justify-content-end gap-2 mt-3">
                    <button type="reset" class="btn btn-outline-secondary rounded-pill px-4">
                        <i class="fas fa-undo me-2"></i>Reset
                    </button>
                    <button type="submit" name="add_admission" class="btn btn-primary rounded-pill px-4">
                        <i class="fas fa-save me-2"></i>Submit Admission
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const classSelect = document.getElementById('classSelect');
    const feeInput = document.getElementById('admission_fees');
    const studentType = document.getElementById('studentType');
    const nameInput = document.querySelector('input[name="name"]');
    const usernamePreview = document.getElementById('usernamePreview');
    const feeMap = <?= json_encode($admission_fee_map, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;
    
    // Update username preview
    function updateUsernamePreview() {
        const name = nameInput.value.trim() || 'student';
        const cleanName = name.toLowerCase().replace(/\s+/g, '_').replace(/[^a-z0-9_]/g, '');
        usernamePreview.value = cleanName + '_id';
    }
    
    nameInput.addEventListener('input', updateUsernamePreview);
    updateUsernamePreview();
    
    function updateAdmissionFee() {
        const classId = classSelect.value;
        const type = studentType.value;
        const amount = feeMap[classId] || 0;
        
        if (type === 'RTO') {
            feeInput.value = '';
            feeInput.style.backgroundColor = '#f8f9fa';
            feeInput.style.borderColor = '#dee2e6';
            feeInput.placeholder = 'No fees (RTO)';
            feeInput.style.color = '#6c757d';
            feeInput.style.fontWeight = 'normal';
        } else if (classId && amount > 0) {
            feeInput.value = Number(amount).toFixed(2);
            feeInput.style.backgroundColor = '#e8f5e9';
            feeInput.style.borderColor = '#28a745';
            feeInput.placeholder = '';
            feeInput.style.color = '#155724';
            feeInput.style.fontWeight = 'bold';
        } else if (classId && amount === 0) {
            feeInput.value = '';
            feeInput.style.backgroundColor = '#fff3cd';
            feeInput.style.borderColor = '#ffc107';
            feeInput.placeholder = '⚠️ No fee configured for this class';
            feeInput.style.color = '#856404';
            feeInput.style.fontWeight = 'normal';
        } else {
            feeInput.value = '';
            feeInput.style.backgroundColor = '#ffffff';
            feeInput.style.borderColor = '#dee2e6';
            feeInput.placeholder = 'Select class first';
            feeInput.style.color = '#6c757d';
            feeInput.style.fontWeight = 'normal';
        }
    }
    
    classSelect.addEventListener('change', updateAdmissionFee);
    studentType.addEventListener('change', updateAdmissionFee);
    updateAdmissionFee();
});

// ====== MANUAL PASSWORD GENERATE ======
function generateManualPassword() {
    const chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$';
    let password = '';
    for (let i = 0; i < 8; i++) {
        password += chars[Math.floor(Math.random() * chars.length)];
    }
    document.getElementById('studentPassword').value = password;
}
</script>

<?php 
include 'includes/footer.php';
ob_end_flush();
?>