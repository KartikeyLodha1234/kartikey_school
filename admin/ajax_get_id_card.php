<?php
include '../config/config.php';

$student_id = intval($_GET['id'] ?? 0);

if ($student_id > 0) {
    try {
        $stmt = $conn->prepare("SELECT s.*, c.class_name, sec.section_name 
                                FROM students s 
                                LEFT JOIN classes c ON s.class_id = c.id 
                                LEFT JOIN sections sec ON s.section_id = sec.id 
                                WHERE s.id = ?");
        $stmt->execute([$student_id]);
        $student = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($student) {
            // Get school name from settings or use default
            $school_name = "KARTIKEY SCHOOL";
            $school_tagline = "Promised To Ensure Quality Education.";
            $school_logo = "../images/logo.png"; // Your logo path
            
            $photo = !empty($student['photo']) ? '../uploads/students/' . $student['photo'] : '';
            $default_photo = 'https://ui-avatars.com/api/?name=' . urlencode($student['name']) . '&background=2563eb&color=fff&size=100';
            ?>
            
            <div class="card-body">
                <!-- School Header -->
                <div class="card-header text-center">
                    <img src="<?= $school_logo ?>" alt="School Logo" class="school-logo" 
                         onerror="this.style.display='none'; this.nextElementSibling.style.display='block'">
                    <div style="display:none; font-size:28px;">🏫</div>
                    <div class="school-name"><?= $school_name ?></div>
                    <div class="school-tagline"><?= $school_tagline ?></div>
                    <div class="card-title">ID CARD</div>
                </div>
                
                <!-- Student Photo -->
                <img src="<?= $photo ? $photo : $default_photo ?>" 
                     alt="<?= htmlspecialchars($student['name']) ?>" 
                     class="student-photo"
                     onerror="this.src='<?= $default_photo ?>'">
                
                <!-- Student Details -->
                <div class="card-body mt-3">
                    <div class="info-row">
                        <span class="info-label">Name</span>
                        <span class="info-value">: <?= htmlspecialchars($student['name']) ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Class</span>
                        <span class="info-value">: <?= htmlspecialchars($student['class_name'] ?? 'N/A') ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Section</span>
                        <span class="info-value">: <?= htmlspecialchars($student['section_name'] ?? 'N/A') ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Admission No</span>
                        <span class="info-value">: <?= htmlspecialchars($student['admission_no']) ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Date of Birth</span>
                        <span class="info-value">: <?= date('d-m-Y', strtotime($student['dob'])) ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Blood Group</span>
                        <span class="info-value">: <?= htmlspecialchars($student['blood_group'] ?? 'N/A') ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Mobile</span>
                        <span class="info-value">: <?= htmlspecialchars($student['parent_phone'] ?? 'N/A') ?></span>
                    </div>
                    <?php if (!empty($student['parent_email'])): ?>
                    <div class="info-row">
                        <span class="info-label">Email</span>
                        <span class="info-value">: <?= htmlspecialchars($student['parent_email']) ?></span>
                    </div>
                    <?php endif; ?>
                    <div class="info-row">
                        <span class="info-label">Session</span>
                        <span class="info-value">: <?= date('Y') . '-' . (date('Y') + 1) ?></span>
                    </div>
                </div>
                
                <!-- Footer -->
                <div class="card-footer">
                    <div class="principal-sign">
                        <div>Principal</div>
                        <div class="sign-line"></div>
                    </div>
                    <div class="text-secondary small mt-2">
                        <i class="fas fa-qrcode me-1"></i> Valid till: <?= date('M Y', strtotime('+1 year')) ?>
                    </div>
                </div>
            </div>
            
            <?php
        } else {
            echo '<div class="text-center py-4 text-danger">Student not found.</div>';
        }
    } catch (Exception $e) {
        echo '<div class="text-center py-4 text-danger">Error: ' . $e->getMessage() . '</div>';
    }
} else {
    echo '<div class="text-center py-4 text-danger">Invalid student ID.</div>';
}
?>