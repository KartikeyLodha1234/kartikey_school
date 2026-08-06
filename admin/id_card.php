<?php
ob_start();
include '../config/config.php';
include 'includes/auth_check.php'; 
checkRole(['admin']);

// ====== FETCH ALL STUDENTS ======
$search = $_GET['search'] ?? '';
$class_filter = $_GET['class_id'] ?? '';
$status_filter = $_GET['status'] ?? '';

try {
    $sql = "SELECT s.*, c.class_name, sec.section_name 
            FROM students s 
            LEFT JOIN classes c ON s.class_id = c.id 
            LEFT JOIN sections sec ON s.section_id = sec.id 
            WHERE 1=1";
    
    $params = [];
    
    if (!empty($search)) {
        $sql .= " AND (s.name LIKE ? OR s.admission_no LIKE ?)";
        $params[] = "%$search%";
        $params[] = "%$search%";
    }
    
    if (!empty($class_filter)) {
        $sql .= " AND s.class_id = ?";
        $params[] = $class_filter;
    }
    
    if (!empty($status_filter)) {
        $sql .= " AND s.status = ?";
        $params[] = $status_filter;
    }
    
    $sql .= " ORDER BY s.id DESC LIMIT 50";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $students = [];
    $error = 'Failed to load students: ' . $e->getMessage();
}

// ====== FETCH ALL CLASSES FOR FILTER ======
try {
    $stmt = $conn->query("SELECT id, class_name FROM classes WHERE status = 'Active' ORDER BY class_name");
    $classes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $classes = [];
}

include 'includes/header.php';
?>

<style>
/* ====== ID CARD PRINT STYLES ====== */
.id-card-container {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.7);
    z-index: 9999;
    justify-content: center;
    align-items: center;
    padding: 20px;
}

.id-card-container.active {
    display: flex;
}

.id-card {
    background: white;
    border-radius: 15px;
    padding: 25px;
    width: 400px;
    max-width: 95%;
    box-shadow: 0 20px 60px rgba(0,0,0,0.3);
    position: relative;
    overflow: hidden;
}

.id-card .card-pattern {
    position: absolute;
    top: -50px;
    right: -50px;
    width: 200px;
    height: 200px;
    background: linear-gradient(135deg, #2563eb, #7c3aed);
    border-radius: 50%;
    opacity: 0.1;
}

.id-card .card-header {
    text-align: center;
    border-bottom: 2px solid #2563eb;
    padding-bottom: 15px;
    margin-bottom: 15px;
    position: relative;
    z-index: 1;
}

.id-card .school-logo {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #2563eb;
    padding: 2px;
    margin-bottom: 5px;
}

.id-card .school-name {
    font-size: 20px;
    font-weight: 800;
    color: #1a1a2e;
    letter-spacing: 1px;
}

.id-card .school-tagline {
    font-size: 11px;
    color: #6b7280;
    letter-spacing: 2px;
    font-weight: 500;
}

.id-card .card-title {
    background: linear-gradient(135deg, #2563eb, #7c3aed);
    color: white;
    padding: 5px 20px;
    border-radius: 20px;
    font-size: 14px;
    font-weight: 700;
    display: inline-block;
    letter-spacing: 2px;
    margin: 5px 0 10px 0;
}

.id-card .student-photo {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    border: 4px solid #2563eb;
    object-fit: cover;
    margin: 0 auto;
    display: block;
}

.id-card .card-body {
    position: relative;
    z-index: 1;
}

.id-card .info-row {
    display: flex;
    padding: 4px 0;
    border-bottom: 1px dashed #e5e7eb;
    font-size: 13px;
}

.id-card .info-row:last-child {
    border-bottom: none;
}

.id-card .info-label {
    font-weight: 600;
    color: #6b7280;
    width: 90px;
    flex-shrink: 0;
}

.id-card .info-value {
    font-weight: 600;
    color: #1a1a2e;
    flex: 1;
}

.id-card .card-footer {
    margin-top: 12px;
    padding-top: 12px;
    border-top: 2px solid #2563eb;
    text-align: center;
    position: relative;
    z-index: 1;
}

.id-card .principal-sign {
    font-size: 12px;
    color: #6b7280;
}

.id-card .principal-sign .sign-line {
    display: inline-block;
    width: 120px;
    border-top: 2px solid #1a1a2e;
    margin-top: 5px;
}

/* Print Styles */
@media print {
    .id-card-container {
        position: static;
        background: white;
        padding: 0;
    }
    .id-card {
        box-shadow: none;
        border: 1px solid #ddd;
        page-break-after: always;
        width: 100%;
    }
    .id-card-container .btn-close-card {
        display: none !important;
    }
    .no-print {
        display: none !important;
    }
}

/* ID Card Grid View */
.id-card-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 20px;
    margin-top: 15px;
}

.id-card-mini {
    background: white;
    border-radius: 12px;
    padding: 15px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    border: 1px solid #e5e7eb;
    transition: all 0.3s ease;
    cursor: pointer;
}

.id-card-mini:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.12);
    border-color: #2563eb;
}

.id-card-mini .mini-header {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 10px;
}

.id-card-mini .mini-photo {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    border: 2px solid #2563eb;
    object-fit: cover;
}

.id-card-mini .mini-name {
    font-weight: 700;
    color: #1a1a2e;
    font-size: 16px;
}

.id-card-mini .mini-details {
    font-size: 13px;
    color: #6b7280;
}

.id-card-mini .mini-details span {
    display: inline-block;
    margin-right: 10px;
}

.id-card-mini .mini-actions {
    display: flex;
    gap: 8px;
    margin-top: 10px;
    padding-top: 10px;
    border-top: 1px solid #e5e7eb;
}
</style>

<!-- ====== PAGE CONTENT ====== -->
<div class="main-content">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h3 class="mb-1"><i class="fas fa-id-card text-primary me-2"></i>Student ID Card</h3>
            <div class="text-secondary small">Generate and manage student identity cards.</div>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-primary rounded-pill px-3 no-print" onclick="window.print()">
                <i class="fas fa-print me-2"></i>Print All
            </button>
        </div>
    </div>

    <!-- ====== SEARCH/FILTER ====== -->
    <div class="card border-0 rounded-4 shadow-sm mb-4 no-print">
        <div class="card-body">
            <form method="get" class="row g-3 align-items-center">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0">
                            <i class="fas fa-search text-secondary"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" name="search" placeholder="Search by name, admission no..." value="<?= htmlspecialchars($search) ?>" />
                    </div>
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="class_id">
                        <option value="">All Classes</option>
                        <?php foreach ($classes as $class): ?>
                        <option value="<?= $class['id'] ?>" <?= $class_filter == $class['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($class['class_name']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="status">
                        <option value="">All Status</option>
                        <option value="Active" <?= $status_filter == 'Active' ? 'selected' : '' ?>>Active</option>
                        <option value="Inactive" <?= $status_filter == 'Inactive' ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100 rounded-pill">
                        <i class="fas fa-search me-2"></i> Search
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ====== ID CARD GRID VIEW ====== -->
    <div class="card border-0 rounded-4 shadow-sm">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0 fw-bold"><i class="fas fa-id-card text-primary me-2"></i>Student ID Cards</h6>
                <span class="text-secondary small">Total: <?= count($students) ?> students</span>
            </div>
            
            <?php if (count($students) > 0): ?>
            <div class="id-card-grid">
                <?php foreach ($students as $student): ?>
                <div class="id-card-mini" onclick="openIDCard(<?= $student['id'] ?>)">
                    <div class="mini-header">
                        <img src="<?= !empty($student['photo']) ? '../uploads/students/' . $student['photo'] : 'https://ui-avatars.com/api/?name=' . urlencode($student['name']) . '&background=2563eb&color=fff&size=50' ?>" 
                             alt="<?= htmlspecialchars($student['name']) ?>" 
                             class="mini-photo"
                             onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($student['name']) ?>&background=2563eb&color=fff&size=50'">
                        <div>
                            <div class="mini-name"><?= htmlspecialchars($student['name']) ?></div>
                            <div class="mini-details">
                                <span>📚 <?= htmlspecialchars($student['class_name'] ?? 'N/A') ?></span>
                                <span>🎓 <?= htmlspecialchars($student['admission_no']) ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="mini-details">
                        <span>👤 <?= htmlspecialchars($student['father_name'] ?: 'N/A') ?></span>
                        <span>📞 <?= htmlspecialchars($student['parent_phone'] ?: 'N/A') ?></span>
                    </div>
                    <div class="mini-actions">
                        <button class="btn btn-sm btn-outline-primary rounded-pill" onclick="event.stopPropagation(); openIDCard(<?= $student['id'] ?>)">
                            <i class="fas fa-eye me-1"></i> View
                        </button>
                        <button class="btn btn-sm btn-outline-success rounded-pill" onclick="event.stopPropagation(); printIDCard(<?= $student['id'] ?>)">
                            <i class="fas fa-print me-1"></i> Print
                        </button>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <div class="text-center py-5">
                <i class="fas fa-id-card fa-4x text-muted mb-3"></i>
                <h6 class="text-secondary">No students found</h6>
                <p class="text-secondary small">Add students to generate ID cards.</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- ====== ID CARD MODAL ====== -->
<div class="id-card-container" id="idCardModal" onclick="closeIDCard(event)">
    <div class="id-card" onclick="event.stopPropagation();">
        <div class="card-pattern"></div>
        
        <!-- Close Button -->
        <button class="btn btn-sm btn-outline-secondary rounded-circle position-absolute top-0 end-0 m-2 btn-close-card" 
                onclick="closeIDCard(event)" style="z-index: 10;">
            <i class="fas fa-times"></i>
        </button>
        
        <div id="idCardContent">
            <!-- ID Card content loaded via AJAX -->
            <div class="text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ====== JAVASCRIPT ====== -->
<script>
function openIDCard(studentId) {
    const modal = document.getElementById('idCardModal');
    const content = document.getElementById('idCardContent');
    
    // Show loading
    content.innerHTML = `
        <div class="text-center py-5">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    `;
    
    modal.classList.add('active');
    document.body.style.overflow = 'hidden';
    
    // Fetch ID card data
    fetch(`ajax_get_id_card.php?id=${studentId}`)
        .then(response => response.text())
        .then(data => {
            content.innerHTML = data;
        })
        .catch(error => {
            content.innerHTML = `
                <div class="text-center py-4 text-danger">
                    <i class="fas fa-exclamation-circle fa-3x mb-2"></i>
                    <p>Error loading ID card. Please try again.</p>
                </div>
            `;
        });
}

function closeIDCard(event) {
    if (event && event.target !== event.currentTarget) return;
    const modal = document.getElementById('idCardModal');
    modal.classList.remove('active');
    document.body.style.overflow = '';
}

function printIDCard(studentId) {
    // Open in new window for printing
    const printWindow = window.open('', '_blank', 'width=800,height=600');
    printWindow.document.write(`
        <!DOCTYPE html>
        <html>
        <head>
            <title>Student ID Card</title>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
            <style>
                body { 
                    margin: 0; 
                    padding: 20px; 
                    display: flex; 
                    justify-content: center; 
                    align-items: center; 
                    min-height: 100vh; 
                    background: #f3f4f6;
                }
                .id-card {
                    background: white;
                    border-radius: 15px;
                    padding: 25px;
                    width: 400px;
                    box-shadow: 0 20px 60px rgba(0,0,0,0.3);
                }
                @media print {
                    body { background: white; padding: 0; }
                    .id-card { box-shadow: none; border: 1px solid #ddd; }
                }
            </style>
        </head>
        <body>
            <div id="printContent" class="text-center">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
            <script>
                fetch('ajax_get_id_card.php?id=' + ${studentId})
                    .then(response => response.text())
                    .then(data => {
                        document.getElementById('printContent').innerHTML = data;
                        setTimeout(() => window.print(), 500);
                    });
            <\/script>
        </body>
        </html>
    `);
    printWindow.document.close();
}

// Close modal on ESC key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeIDCard(null);
    }
});
</script>

<?php 
include 'includes/footer.php';
ob_end_flush();
?>