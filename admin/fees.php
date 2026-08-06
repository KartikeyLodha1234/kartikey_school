<?php
ob_start();
include '../config/config.php';
include 'includes/auth_check.php'; 
checkRole(['admin']);
include 'includes/header.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_fee'])) {
    $class_id = intval($_POST['class_id'] ?? 0);
    $fee_type = trim($_POST['fee_type'] ?? '');
    $amount = trim($_POST['amount'] ?? '');
    $status = trim($_POST['status'] ?? 'Active');
    if ($class_id === 0 || $amount === '') {
        $error = 'Please select a class and enter amount.';
    } else {
        try {
            // Get class name from classes table
            $stmt = $conn->prepare("SELECT class_name FROM classes WHERE id = ?");
            $stmt->execute([$class_id]);
            $class = $stmt->fetch(PDO::FETCH_ASSOC);
            $fee_name = $class ? $class['class_name'] : '';

            $stmt = $conn->prepare("INSERT INTO fees (fee_name, class_id, fee_type, amount, status) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$fee_name, $class_id, $fee_type, $amount, $status]);
            $_SESSION['success'] = 'Fee added successfully!';
            ob_end_clean();
            header('Location: fees.php');
            exit();
        } catch (Exception $e) {
            $error = 'Database error: ' . $e->getMessage();
        }
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_fee'])) {
    $id = intval($_POST['id'] ?? 0);
    $class_id = intval($_POST['class_id'] ?? 0);
    $fee_type = trim($_POST['fee_type'] ?? '');
    $amount = trim($_POST['amount'] ?? '');
    $status = trim($_POST['status'] ?? 'Active');
    if ($id === 0 || $class_id === 0 || $amount === '') {
        $error = 'Please select a class and enter amount.';
    } else {
        try {
            $stmt = $conn->prepare("SELECT class_name FROM classes WHERE id = ?");
            $stmt->execute([$class_id]);
            $class = $stmt->fetch(PDO::FETCH_ASSOC);
            $fee_name = $class ? $class['class_name'] : '';
            $stmt = $conn->prepare("UPDATE fees SET fee_name = ?, class_id = ?, fee_type = ?, amount = ?, status = ? WHERE id = ?");
            $stmt->execute([$fee_name, $class_id, $fee_type, $amount, $status, $id]);
            $_SESSION['success'] = 'Fee updated successfully!';
            ob_end_clean();
            header('Location: fees.php');
            exit();
        } catch (Exception $e) {
            $error = 'Database error: ' . $e->getMessage();
        }
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_fee'])) {
    $id = intval($_POST['id'] ?? 0);
    if ($id > 0) {
        try {
            $stmt = $conn->prepare("DELETE FROM fees WHERE id = ?");
            $stmt->execute([$id]);
            $_SESSION['success'] = 'Fee deleted successfully!';
            
            // ====== CLEAN OUTPUT BUFFER BEFORE REDIRECT ======
            ob_end_clean();
            header('Location: fees.php');
            exit();
        } catch (Exception $e) {
            $error = 'Database error: ' . $e->getMessage();
        }
    }
}
try {
    $stmt = $conn->query("SELECT id, class_name FROM classes WHERE status = 'Active' ORDER BY class_name");
    $classes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $classes = [];
    $error = 'Failed to load classes: ' . $e->getMessage();
}
try {
    $stmt = $conn->query("SELECT * FROM fees ORDER BY id DESC");
    $fees = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $fees = [];
    $error = 'Failed to load fees: ' . $e->getMessage();
}
$edit_fee = null;
if (isset($_GET['edit_id'])) {
    $edit_id = intval($_GET['edit_id']);
    try {
        $stmt = $conn->prepare("SELECT * FROM fees WHERE id = ?");
        $stmt->execute([$edit_id]);
        $edit_fee = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        $error = 'Failed to load fee details.';
    }
}
$total_fees = count($fees);
$active_fees = count(array_filter($fees, fn($f) => $f['status'] == 'Active'));
$total_amount = array_sum(array_column($fees, 'amount'));
?>
<div class="main-content">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h3 class="mb-1">Fees</h3>
            <div class="text-secondary small">Manage academic fees and their details.</div>
        </div>
    </div>
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 rounded-4 shadow-sm">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-secondary small">Total Fees</div>
                            <h3 class="mb-0 fw-bold"><?= $total_fees ?></h3>
                            <div class="text-secondary small">All fees</div>
                        </div>
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-list text-primary fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 rounded-4 shadow-sm">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-secondary small">Active Fees</div>
                            <h3 class="mb-0 fw-bold text-success"><?= $active_fees ?></h3>
                            <div class="text-secondary small">Currently active</div>
                        </div>
                        <div class="bg-success bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-check-circle text-success fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 rounded-4 shadow-sm">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-secondary small">Total Amount</div>
                            <h3 class="mb-0 fw-bold text-warning">₹<?= number_format($total_amount, 0) ?></h3>
                            <div class="text-secondary small">Total fee amount</div>
                        </div>
                        <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-rupee-sign text-warning fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show rounded-4" role="alert">
            <i class="fas fa-check-circle me-2"></i><?= htmlspecialchars($_SESSION['success']) ?>
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
    <div class="card border-0 rounded-4 shadow-sm mb-4">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                <h5 class="mb-0"><?= $edit_fee ? 'Edit Fee' : 'Add New Fee' ?></h5>
                <span class="text-secondary small"><?= $edit_fee ? 'Update fee details' : 'Create a new academic fee record' ?></span>
            </div>
            <form class="row g-3" method="post">
                <?php if ($edit_fee): ?>
                    <input type="hidden" name="id" value="<?= $edit_fee['id'] ?>">
                <?php endif; ?>
                
                <!-- Class Name Dropdown from Database -->
                <div class="col-md-6">
                    <label class="form-label required">Class Name</label>
                    <select class="form-select" name="class_id" required>
                        <option value="">Select Class</option>
                        <?php foreach ($classes as $class): ?>
                            <option value="<?= $class['id'] ?>" 
                                <?= $edit_fee && isset($edit_fee['class_id']) && $edit_fee['class_id'] == $class['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($class['class_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (count($classes) == 0): ?>
                        <small class="text-danger">No active classes found. Please <a href="classes.php">add a class</a> first.</small>
                    <?php endif; ?>
                </div>
                
                <div class="col-md-6">
                    <label class="form-label">Fee Type</label>
                    <select class="form-select" name="fee_type">
                        <option value="">Select Fee Type</option>
                        <option value="Admission" <?= $edit_fee && $edit_fee['fee_type'] == 'Admission' ? 'selected' : '' ?>>Admission</option>
                        <option value="Tuition" <?= $edit_fee && $edit_fee['fee_type'] == 'Tuition' ? 'selected' : '' ?>>Tuition</option>
                        <option value="Exam" <?= $edit_fee && $edit_fee['fee_type'] == 'Exam' ? 'selected' : '' ?>>Exam</option>
                        <option value="Library" <?= $edit_fee && $edit_fee['fee_type'] == 'Library' ? 'selected' : '' ?>>Library</option>
                        <option value="Sports" <?= $edit_fee && $edit_fee['fee_type'] == 'Sports' ? 'selected' : '' ?>>Sports</option>
                        <option value="Lab" <?= $edit_fee && $edit_fee['fee_type'] == 'Lab' ? 'selected' : '' ?>>Lab</option>
                        <option value="Transport" <?= $edit_fee && $edit_fee['fee_type'] == 'Transport' ? 'selected' : '' ?>>Transport</option>
                        <option value="Hostel" <?= $edit_fee && $edit_fee['fee_type'] == 'Hostel' ? 'selected' : '' ?>>Hostel</option>
                        <option value="Other" <?= $edit_fee && $edit_fee['fee_type'] == 'Other' ? 'selected' : '' ?>>Other</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label required">Amount (₹)</label>
                    <input type="number" class="form-control" name="amount" 
                           placeholder="1000.00" min="0" step="0.01"
                           value="<?= $edit_fee ? $edit_fee['amount'] : '' ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <select class="form-select" name="status">
                        <option value="Active" <?= $edit_fee && $edit_fee['status'] == 'Active' ? 'selected' : '' ?>>Active</option>
                        <option value="Inactive" <?= $edit_fee && $edit_fee['status'] == 'Inactive' ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </div>
                <div class="col-12 d-flex justify-content-end gap-2">
                    <?php if ($edit_fee): ?>
                        <a href="fees.php" class="btn btn-outline-secondary rounded-pill px-3">Cancel</a>
                        <button type="submit" name="edit_fee" class="btn btn-warning rounded-pill px-3">
                            <i class="fas fa-edit me-1"></i>Update Fee
                        </button>
                    <?php else: ?>
                        <button type="reset" class="btn btn-outline-secondary rounded-pill px-3">Reset</button>
                        <button type="submit" name="add_fee" class="btn btn-primary rounded-pill px-3">
                            <i class="fas fa-save me-1"></i>Save Fee
                        </button>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>
    <div class="card border-0 rounded-4 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-custom align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Class Name</th>
                            <th>Fee Type</th>
                            <th>Amount (₹)</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($fees) > 0): ?>
                            <?php $i = 1; foreach ($fees as $fee): ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><strong><?= htmlspecialchars($fee['fee_name']) ?></strong></td>
                                    <td>
                                        <?php if ($fee['fee_type']): ?>
                                            <span class="badge bg-info text-dark"><?= htmlspecialchars($fee['fee_type']) ?></span>
                                        <?php else: ?>
                                            <span class="text-secondary small">—</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>₹ <?= number_format($fee['amount'], 2) ?></td>
                                    <td>
                                        <?php if ($fee['status'] == 'Active'): ?>
                                            <span class="status-badge bg-success-subtle text-success">Active</span>
                                        <?php else: ?>
                                            <span class="status-badge bg-danger-subtle text-danger">Inactive</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="fees.php?edit_id=<?= $fee['id'] ?>" class="btn btn-sm btn-outline-primary rounded-pill" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form method="post" onsubmit="return confirm('Are you sure you want to delete this fee?')" style="display:inline;">
                                                <input type="hidden" name="id" value="<?= $fee['id'] ?>">
                                                <button type="submit" name="delete_fee" class="btn btn-sm btn-outline-danger rounded-pill" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center py-4 text-secondary">
                                    <i class="fas fa-inbox fa-3x d-block mb-2 text-muted"></i>
                                    No fees found. Fill the form above to add one.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php if (count($fees) > 0): ?>
            <div class="card-footer bg-transparent border-top-0 p-3">
                <div class="text-secondary small">
                    <i class="fas fa-list me-1"></i>Total: <?= count($fees) ?> fees
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php 
include 'includes/footer.php';
ob_end_flush();
?>