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
.id-card-container {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.85);
    z-index: 9999;
    justify-content: center;
    align-items: center;
    padding: 20px;
}

.id-card-container.active {
    display: flex;
}

.id-card-modal {
    background: white;
    border-radius: 16px;
    padding: 25px;
    width: 420px;
    max-width: 95%;
    max-height: 90vh;
    overflow-y: auto;
    box-shadow: 0 25px 80px rgba(0,0,0,0.5);
    position: relative;
}

/* Close Button */
.btn-close-card {
    position: sticky;
    top: 0;
    float: right;
    z-index: 100;
    background: #f3f4f6;
    border: none;
    width: 35px;
    height: 35px;
    border-radius: 50%;
    font-size: 16px;
    cursor: pointer;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 10px;
}

.btn-close-card:hover {
    background: #e5e7eb;
    transform: rotate(90deg);
}

/* Flip Container */
.flip-container {
    perspective: 1000px;
    width: 100%;
    max-width: 380px;
    margin: 0 auto;
    min-height: 450px;
}

.flip-container .flipper {
    position: relative;
    width: 100%;
    min-height: 450px;
    transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    transform-style: preserve-3d;
}

.flip-container .flipper.flipped {
    transform: rotateY(180deg);
}

.flip-container .front,
.flip-container .back {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    min-height: 450px;
    backface-visibility: hidden;
    -webkit-backface-visibility: hidden;
}

.flip-container .back {
    transform: rotateY(180deg);
}

/* Flip Button */
.flip-btn {
    display: flex;
    justify-content: center;
    gap: 15px;
    margin-top: 15px;
}

.flip-btn button {
    padding: 8px 25px;
    border: none;
    border-radius: 25px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
}

.flip-btn .btn-front {
    background: #2563eb;
    color: white;
}

.flip-btn .btn-front:hover {
    background: #1d4ed8;
    transform: scale(1.05);
}

.flip-btn .btn-back {
    background: #7c3aed;
    color: white;
}

.flip-btn .btn-back:hover {
    background: #6d28d9;
    transform: scale(1.05);
}

.flip-btn .btn-active {
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.3);
    transform: scale(0.95);
}

/* Loading */
.id-card-loading {
    text-align: center;
    padding: 60px 0;
}

.id-card-loading .spinner {
    border: 4px solid #f3f3f3;
    border-top: 4px solid #2563eb;
    border-radius: 50%;
    width: 45px;
    height: 45px;
    animation: spin 1s linear infinite;
    margin: 0 auto 15px;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Print Styles */
@media print {
    .id-card-container {
        position: static;
        background: white;
        padding: 0;
    }
    .id-card-modal {
        box-shadow: none;
        border: 1px solid #ddd;
        border-radius: 0;
        padding: 15px;
        max-width: 100%;
        max-height: 100%;
        overflow: visible;
    }
    .btn-close-card,
    .flip-btn {
        display: none !important;
    }
    .flip-container .flipper {
        transform: none !important;
    }
    .flip-container .front,
    .flip-container .back {
        position: relative !important;
        transform: none !important;
        backface-visibility: visible !important;
        min-height: auto !important;
    }
    .flip-container .back {
        margin-top: 20px;
        border-top: 2px dashed #ccc;
        padding-top: 20px;
    }
    .flip-container {
        min-height: auto !important;
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
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h3 class="mb-1"><i class="fas fa-id-card text-primary me-2"></i>Student ID Card</h3>
            <div class="text-secondary small">Generate and manage student identity cards.</div>
        </div>
        <div class="d-flex gap-2 no-print">
            <button class="btn btn-outline-primary rounded-pill px-3" onclick="printAllCards()">
                <i class="fas fa-print me-2"></i>Print All
            </button>
        </div>
    </div>

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

<!-- ====== ID CARD MODAL WITH FLIP ====== -->
<div class="id-card-container" id="idCardModal" onclick="closeIDCard(event)">
    <div class="id-card-modal" onclick="event.stopPropagation();">
        <!-- Close Button -->
        <button class="btn-close-card" onclick="closeIDCard(event)">
            <i class="fas fa-times"></i>
        </button>
        
        <!-- Flip Container -->
        <div class="flip-container" id="flipContainer">
            <div class="flipper" id="flipper">
                <!-- Front Side -->
                <div class="front" id="frontContent">
                    <div class="id-card-loading">
                        <div class="spinner"></div>
                        <p style="color:#6b7280;">Loading Front Side...</p>
                    </div>
                </div>
                <!-- Back Side -->
                <div class="back" id="backContent">
                    <div class="id-card-loading">
                        <div class="spinner"></div>
                        <p style="color:#6b7280;">Loading Back Side...</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Flip Buttons -->
        <div class="flip-btn no-print">
            <button class="btn-front btn-active" id="btnFront" onclick="showFront()">
                <i class="fas fa-id-card"></i> Front
            </button>
            <button class="btn-back" id="btnBack" onclick="showBack()">
                <i class="fas fa-id-card"></i> Back
            </button>
        </div>
    </div>
</div>

<!-- ====== JAVASCRIPT ====== -->
<script>
let currentStudentId = 0;
let isFlipped = false;

function openIDCard(studentId) {
    currentStudentId = studentId;
    const modal = document.getElementById('idCardModal');
    const frontContent = document.getElementById('frontContent');
    const backContent = document.getElementById('backContent');
    const flipper = document.getElementById('flipper');
    
    // Reset flip
    flipper.classList.remove('flipped');
    isFlipped = false;
    document.getElementById('btnFront').classList.add('btn-active');
    document.getElementById('btnBack').classList.remove('btn-active');
    
    // Show loading
    frontContent.innerHTML = `
        <div class="id-card-loading">
            <div class="spinner"></div>
            <p style="color:#6b7280;">Loading Front Side...</p>
        </div>
    `;
    backContent.innerHTML = `
        <div class="id-card-loading">
            <div class="spinner"></div>
            <p style="color:#6b7280;">Loading Back Side...</p>
        </div>
    `;
    
    modal.classList.add('active');
    document.body.style.overflow = 'hidden';
    
    // Load Front Side
    fetch('ajax_get_id_card.php?id=' + studentId + '&side=front')
        .then(response => response.text())
        .then(data => {
            frontContent.innerHTML = data;
        })
        .catch(error => {
            frontContent.innerHTML = `
                <div class="text-center py-5 text-danger">
                    <i class="fas fa-exclamation-circle fa-3x mb-3"></i>
                    <p>Error loading front side.</p>
                </div>
            `;
        });
    
    // Load Back Side
    fetch('ajax_get_id_card.php?id=' + studentId + '&side=back')
        .then(response => response.text())
        .then(data => {
            backContent.innerHTML = data;
        })
        .catch(error => {
            backContent.innerHTML = `
                <div class="text-center py-5 text-danger">
                    <i class="fas fa-exclamation-circle fa-3x mb-3"></i>
                    <p>Error loading back side.</p>
                </div>
            `;
        });
}

function closeIDCard(event) {
    if (event && event.target !== event.currentTarget && !event.target.closest('.btn-close-card')) return;
    const modal = document.getElementById('idCardModal');
    modal.classList.remove('active');
    document.body.style.overflow = '';
}

function showFront() {
    const flipper = document.getElementById('flipper');
    flipper.classList.remove('flipped');
    isFlipped = false;
    document.getElementById('btnFront').classList.add('btn-active');
    document.getElementById('btnBack').classList.remove('btn-active');
}

function showBack() {
    const flipper = document.getElementById('flipper');
    flipper.classList.add('flipped');
    isFlipped = true;
    document.getElementById('btnBack').classList.add('btn-active');
    document.getElementById('btnFront').classList.remove('btn-active');
}

// ====== PRINT ID CARD ======
function printIDCard(studentId) {
    const printWindow = window.open('', '_blank', 'width=450,height=650,menubar=no,toolbar=no,location=no,status=no');
    
    printWindow.document.write(`
        <!DOCTYPE html>
        <html>
        <head>
            <title>Student ID Card</title>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
            <style>
                * { margin: 0; padding: 0; box-sizing: border-box; }
                body { 
                    margin: 0; 
                    padding: 0; 
                    display: flex; 
                    justify-content: center; 
                    align-items: center; 
                    min-height: 100vh; 
                    background: #f0f2f5;
                    font-family: 'Segoe UI', Arial, sans-serif;
                }
                .print-container {
                    background: white;
                    border-radius: 14px;
                    padding: 20px;
                    box-shadow: 0 10px 40px rgba(0,0,0,0.15);
                    max-width: 420px;
                    width: 100%;
                    margin: 20px;
                }
                .loading {
                    text-align: center;
                    padding: 40px 0;
                }
                .spinner {
                    border: 4px solid #f3f3f3;
                    border-top: 4px solid #2563eb;
                    border-radius: 50%;
                    width: 40px;
                    height: 40px;
                    animation: spin 1s linear infinite;
                    margin: 0 auto 15px;
                }
                @keyframes spin {
                    0% { transform: rotate(0deg); }
                    100% { transform: rotate(360deg); }
                }
                .card-page {
                    page-break-after: always;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    min-height: 100vh;
                }
                .card-page:last-child {
                    page-break-after: avoid;
                }
                .side-label-print {
                    text-align: center;
                    font-size: 9px;
                    color: #9ca3af;
                    margin-top: 5px;
                    letter-spacing: 2px;
                }
                @media print {
                    body { 
                        background: white; 
                        padding: 0; 
                        margin: 0;
                        min-height: 100vh;
                    }
                    .print-container { 
                        box-shadow: none; 
                        border: none;
                        border-radius: 0;
                        padding: 0;
                        max-width: 100%;
                        width: 100%;
                        min-height: 100vh;
                        margin: 0;
                    }
                    .no-print { display: none !important; }
                    .card-page {
                        min-height: 100vh;
                        page-break-after: always;
                    }
                    .card-page:last-child {
                        page-break-after: avoid;
                    }
                }
            </style>
        </head>
        <body>
            <div class="print-container" id="printContent">
                <div class="loading">
                    <div class="spinner"></div>
                    <p style="color:#6b7280; font-size:14px;">Loading ID Card...</p>
                </div>
            </div>
            <script>
                let loadedCount = 0;
                let frontHTML = '';
                let backHTML = '';
                
                // Load Front Side
                fetch('ajax_get_id_card.php?id=' + ${studentId} + '&side=front')
                    .then(response => response.text())
                    .then(frontData => {
                        frontHTML = frontData;
                        loadedCount++;
                        if (loadedCount === 2) {
                            document.getElementById('printContent').innerHTML = \`
                                <div class="card-page">\${frontHTML}</div>
                                <div class="card-page">\${backHTML}</div>
                            \`;
                            setTimeout(function() { window.print(); }, 600);
                        }
                    })
                    .catch(error => {
                        frontHTML = '<div style="text-align:center;padding:40px;color:#dc3545;">Error loading front</div>';
                        loadedCount++;
                    });
                
                // Load Back Side
                fetch('ajax_get_id_card.php?id=' + ${studentId} + '&side=back')
                    .then(response => response.text())
                    .then(backData => {
                        backHTML = backData;
                        loadedCount++;
                        if (loadedCount === 2) {
                            document.getElementById('printContent').innerHTML = \`
                                <div class="card-page">\${frontHTML}</div>
                                <div class="card-page">\${backHTML}</div>
                            \`;
                            setTimeout(function() { window.print(); }, 600);
                        }
                    })
                    .catch(error => {
                        backHTML = '<div style="text-align:center;padding:40px;color:#dc3545;">Error loading back</div>';
                        loadedCount++;
                    });
            <\/script>
        </body>
        </html>
    `);
    printWindow.document.close();
}

// ====== PRINT ALL CARDS ======
function printAllCards() {
    const studentIds = <?= json_encode(array_column($students, 'id')) ?>;
    if (studentIds.length === 0) {
        alert('No students found to print.');
        return;
    }
    
    const printWindow = window.open('', '_blank', 'width=450,height=650');
    let cardsHtml = '';
    
    studentIds.forEach((id, index) => {
        cardsHtml += `<div class="card-wrapper" id="card-${id}">Loading card ${index + 1}...</div>`;
    });
    
    printWindow.document.write(`
        <!DOCTYPE html>
        <html>
        <head>
            <title>All Student ID Cards</title>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
            <style>
                * { margin: 0; padding: 0; box-sizing: border-box; }
                body { 
                    margin: 0; 
                    padding: 20px; 
                    background: white;
                    font-family: 'Segoe UI', Arial, sans-serif;
                }
                .card-wrapper {
                    margin: 10px auto;
                    max-width: 420px;
                    page-break-after: always;
                }
                .card-wrapper:last-child {
                    page-break-after: avoid;
                }
                .spinner {
                    border: 4px solid #f3f3f3;
                    border-top: 4px solid #2563eb;
                    border-radius: 50%;
                    width: 30px;
                    height: 30px;
                    animation: spin 1s linear infinite;
                    margin: 0 auto 15px;
                }
                @keyframes spin {
                    0% { transform: rotate(0deg); }
                    100% { transform: rotate(360deg); }
                }
                .student-card {
                    background: white;
                    border-radius: 12px;
                    border: 1px solid #e5e7eb;
                    overflow: hidden;
                }
                .student-card .top-line {
                    height: 4px;
                    background: linear-gradient(90deg, #1a56db, #7c3aed, #1a56db);
                }
                @media print {
                    body { padding: 0; margin: 0; }
                    .card-wrapper { margin: 0 auto; }
                }
            </style>
        </head>
        <body>
            <div id="allCardsContainer">
                ${cardsHtml}
            </div>
            <script>
                const studentIds = ${json_encode(array_column($students, 'id'))};
                let loadedCount = 0;
                const totalCards = studentIds.length;
                
                studentIds.forEach((id) => {
                    let frontLoaded = false;
                    let backLoaded = false;
                    let frontHTML = '';
                    let backHTML = '';
                    
                    fetch('ajax_get_id_card.php?id=' + id + '&side=front')
                        .then(response => response.text())
                        .then(data => {
                            frontHTML = data;
                            frontLoaded = true;
                            checkAndRender(id);
                        })
                        .catch(() => {
                            frontHTML = '<div style="text-align:center;padding:20px;color:#dc3545;">Error</div>';
                            frontLoaded = true;
                            checkAndRender(id);
                        });
                    
                    fetch('ajax_get_id_card.php?id=' + id + '&side=back')
                        .then(response => response.text())
                        .then(data => {
                            backHTML = data;
                            backLoaded = true;
                            checkAndRender(id);
                        })
                        .catch(() => {
                            backHTML = '<div style="text-align:center;padding:20px;color:#dc3545;">Error</div>';
                            backLoaded = true;
                            checkAndRender(id);
                        });
                    
                    function checkAndRender(id) {
                        if (frontLoaded && backLoaded) {
                            document.getElementById('card-' + id).innerHTML = \`
                                <div class="student-card">
                                    <div class="top-line"></div>
                                    \${frontHTML}
                                    <div style="border-top:2px dashed #ccc;margin:10px 0;padding:10px 0;">
                                        \${backHTML}
                                    </div>
                                </div>
                            \`;
                            loadedCount++;
                            if (loadedCount === totalCards) {
                                setTimeout(function() { window.print(); }, 1000);
                            }
                        }
                    }
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