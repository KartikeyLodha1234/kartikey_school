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

<!-- ====== ID CARD MODAL ====== -->
<div class="id-card-container" id="idCardModal" onclick="closeIDCard(event)">
    <div class="id-card" onclick="event.stopPropagation();">
        <div class="card-pattern"></div>
        <button class="btn btn-sm btn-outline-secondary rounded-circle position-absolute top-0 end-0 m-2 btn-close-card" 
                onclick="closeIDCard(event)" style="z-index: 10;">
            <i class="fas fa-times"></i>
        </button>
        <div id="idCardContent">
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
    
    content.innerHTML = `
        <div class="text-center py-5">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    `;
    
    modal.classList.add('active');
    document.body.style.overflow = 'hidden';
    
    fetch('ajax_get_id_card.php?id=' + studentId)
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

// ====== PRINT ID CARD WITH FRONT AND BACK ======
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
                }
                .card-page:last-child {
                    page-break-after: avoid;
                }
                .side-label {
                    text-align: center;
                    font-size: 10px;
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
                        display: flex;
                        flex-direction: column;
                        justify-content: center;
                        align-items: center;
                    }
                    .no-print { display: none !important; }
                    .card-page {
                        page-break-after: always;
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        width: 100%;
                        min-height: 100vh;
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
                // Load Front Side
                fetch('ajax_get_id_card.php?id=' + ${studentId} + '&side=front')
                    .then(response => response.text())
                    .then(frontData => {
                        // Load Back Side
                        fetch('ajax_get_id_card.php?id=' + ${studentId} + '&side=back')
                            .then(response => response.text())
                            .then(backData => {
                                document.getElementById('printContent').innerHTML = \`
                                    <div class="card-page">\${frontData}</div>
                                    <div class="card-page">\${backData}</div>
                                \`;
                                setTimeout(function() {
                                    window.print();
                                }, 800);
                            })
                            .catch(error => {
                                document.getElementById('printContent').innerHTML = \`
                                    <div style="text-align:center; padding:30px; color:#dc3545;">
                                        <i class="fas fa-exclamation-circle fa-3x mb-3"></i>
                                        <p>Error loading ID card back side.</p>
                                    </div>
                                \`;
                            });
                    })
                    .catch(error => {
                        document.getElementById('printContent').innerHTML = \`
                            <div style="text-align:center; padding:30px; color:#dc3545;">
                                <i class="fas fa-exclamation-circle fa-3x mb-3"></i>
                                <p>Error loading ID card. Please try again.</p>
                            </div>
                        \`;
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
                .id-card-print {
                    background: white;
                    border-radius: 12px;
                    padding: 0;
                    position: relative;
                    overflow: hidden;
                    border: 1px solid #e5e7eb;
                }
                .id-card-print .top-line {
                    height: 4px;
                    background: linear-gradient(90deg, #1a56db, #7c3aed, #1a56db);
                    margin-bottom: 12px;
                }
                .id-card-print .header {
                    text-align: center;
                    border-bottom: 2px solid #2563eb;
                    padding-bottom: 10px;
                    margin-bottom: 10px;
                    padding-left: 20px;
                    padding-right: 20px;
                }
                .id-card-print .logo {
                    width: 55px;
                    height: 55px;
                    border-radius: 50%;
                    object-fit: cover;
                    border: 3px solid #2563eb;
                    padding: 2px;
                    margin-bottom: 2px;
                }
                .id-card-print .school-name {
                    font-size: 17px;
                    font-weight: 800;
                    color: #1a1a2e;
                    letter-spacing: 1px;
                }
                .id-card-print .tagline {
                    font-size: 8px;
                    color: #6b7280;
                    letter-spacing: 1px;
                    font-weight: 500;
                }
                .id-card-print .card-title {
                    background: linear-gradient(135deg, #2563eb, #7c3aed);
                    color: white;
                    padding: 3px 18px;
                    border-radius: 20px;
                    font-size: 12px;
                    font-weight: 700;
                    display: inline-block;
                    letter-spacing: 2px;
                    margin: 4px 0 6px 0;
                }
                .id-card-print .photo {
                    width: 95px;
                    height: 95px;
                    border-radius: 50%;
                    border: 4px solid #2563eb;
                    object-fit: cover;
                    margin: 0 auto 8px auto;
                    display: block;
                }
                .id-card-print .info-row {
                    display: flex;
                    padding: 3px 0;
                    font-size: 12.5px;
                    align-items: baseline;
                    padding-left: 20px;
                    padding-right: 20px;
                }
                .id-card-print .info-label {
                    font-weight: 600;
                    color: #4b5563;
                    width: 108px;
                    flex-shrink: 0;
                    font-size: 12px;
                }
                .id-card-print .info-value {
                    font-weight: 600;
                    color: #1a1a2e;
                    flex: 1;
                    font-size: 12.5px;
                    padding-left: 2px;
                }
                .id-card-print .footer {
                    margin-top: 10px;
                    padding-top: 10px;
                    border-top: 2px solid #2563eb;
                    text-align: center;
                    padding-left: 20px;
                    padding-right: 20px;
                    padding-bottom: 15px;
                }
                .id-card-print .principal {
                    font-size: 10.5px;
                    color: #6b7280;
                }
                .id-card-print .sign-line {
                    display: inline-block;
                    width: 110px;
                    border-top: 2px solid #1a1a2e;
                    margin-top: 3px;
                }
                .id-card-print .valid-till {
                    font-size: 9.5px;
                    color: #6b7280;
                    margin-top: 4px;
                }
                @media print {
                    body { padding: 0; margin: 0; }
                    .card-wrapper { margin: 0 auto; }
                    .id-card-print { border: none; border-radius: 0; }
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
                    fetch('ajax_get_id_card.php?id=' + id)
                        .then(response => response.text())
                        .then(data => {
                            document.getElementById('card-' + id).innerHTML = data;
                            loadedCount++;
                            if (loadedCount === totalCards) {
                                setTimeout(function() {
                                    window.print();
                                }, 1000);
                            }
                        })
                        .catch(error => {
                            document.getElementById('card-' + id).innerHTML = \`
                                <div style="text-align:center; padding:20px; color:#dc3545;">
                                    Error loading card
                                </div>
                            \`;
                            loadedCount++;
                        });
                });
            <\/script>
        </body>
        </html>
    `);
    printWindow.document.close();
}

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