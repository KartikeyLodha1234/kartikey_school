<?php
include '../config/config.php';
include 'includes/auth_check.php'; 
checkRole(['admin']);
include 'includes/header.php';

// ====== HANDLE ADD FEE ======
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_fee'])) {
    $fee_name = trim($_POST['fee_name'] ?? '');
    $fee_type = trim($_POST['fee_type'] ?? '');
    $amount = trim($_POST['amount'] ?? '');
    $status = trim($_POST['status'] ?? 'Active');

    if ($fee_name === '' || $amount === '') {
        $error = 'Please fill in all required fields.';
    } else {
        try {
            $stmt = $conn->prepare("INSERT INTO fees (fee_name, fee_type, amount, status) VALUES (?, ?, ?, ?)");
            $stmt->execute([$fee_name, $fee_type, $amount, $status]);
            $_SESSION['success'] = 'Fee added successfully!';
            header('Location: fees.php');
            exit();
        } catch (Exception $e) {
            $error = 'Database error: ' . $e->getMessage();
        }
    }
}

// ====== HANDLE EDIT FEE ======
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_fee'])) {
    $id = intval($_POST['id'] ?? 0);
    $fee_name = trim($_POST['fee_name'] ?? '');
    $fee_type = trim($_POST['fee_type'] ?? '');
    $amount = trim($_POST['amount'] ?? '');
    $status = trim($_POST['status'] ?? 'Active');

    if ($id === 0 || $fee_name === '' || $amount === '') {
        $error = 'Please fill in all required fields.';
    } else {
        try {
            $stmt = $conn->prepare("UPDATE fees SET fee_name = ?, fee_type = ?, amount = ?, status = ? WHERE id = ?");
            $stmt->execute([$fee_name, $fee_type, $amount, $status, $id]);
            $_SESSION['success'] = 'Fee updated successfully!';
            header('Location: fees.php');
            exit();
        } catch (Exception $e) {
            $error = 'Database error: ' . $e->getMessage();
        }
    }
}

// ====== HANDLE DELETE FEE ======
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_fee'])) {
    $id = intval($_POST['id'] ?? 0);
    if ($id > 0) {
        try {
            $stmt = $conn->prepare("DELETE FROM fees WHERE id = ?");
            $stmt->execute([$id]);
            $_SESSION['success'] = 'Fee deleted successfully!';
            header('Location: fees.php');
            exit();
        } catch (Exception $e) {
            $error = 'Database error: ' . $e->getMessage();
        }
    }
}

// ====== FETCH ALL FEES ======
try {
    $stmt = $conn->query("SELECT * FROM fees ORDER BY id DESC");
    $fees = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $fees = [];
    $error = 'Failed to load fees: ' . $e->getMessage();
}

// ====== FETCH SINGLE FEE FOR EDIT ======
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

// ====== CALCULATE STATISTICS ======
$total_fees = count($fees);
$active_fees = count(array_filter($fees, fn($f) => $f['status'] == 'Active'));
$total_amount = array_sum(array_column($fees, 'amount'));
?>

<!-- ====== PAGE CONTENT ====== -->
<div class="main-content">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h3 class="mb-1"><i class="fas fa-money-bill-wave text-primary me-2"></i>Fees</h3>
            <div class="text-secondary small">Manage academic fees and their details.</div>
        </div>
        <div>
            <a href="#addFeeModal" class="btn btn-primary rounded-pill" data-bs-toggle="modal">
                <i class="fas fa-plus me-2"></i>Add New Fee
            </a>
        </div>
    </div>

    <!-- ====== SUCCESS/ERROR MESSAGES ====== -->
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

    <!-- ====== STATISTICS CARDS (Like Class Management) ====== -->
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

    <!-- ====== ADD FEE MODAL ====== -->
    <div class="modal fade" id="addFeeModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header border-0">
                    <h5 class="modal-title"><i class="fas fa-plus-circle text-primary me-2"></i>Add New Fee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="post">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label required">Fee Name</label>
                                <input type="text" class="form-control" name="fee_name" placeholder="e.g., Tuition Fee" required>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Fee Type</label>
                                <select class="form-select" name="fee_type">
                                    <option value="">Select Fee Type</option>
                                    <option value="Tuition">Tuition</option>
                                    <option value="Exam">Exam</option>
                                    <option value="Library">Library</option>
                                    <option value="Sports">Sports</option>
                                    <option value="Lab">Lab</option>
                                    <option value="Transport">Transport</option>
                                    <option value="Hostel">Hostel</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label required">Amount (₹)</label>
                                <input type="number" class="form-control" name="amount" placeholder="1000.00" min="0" step="0.01" required>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Status</label>
                                <select class="form-select" name="status">
                                    <option value="Active" selected>Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-outline-secondary rounded-pill" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="add_fee" class="btn btn-primary rounded-pill">
                            <i class="fas fa-save me-2"></i>Save Fee
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ====== EDIT FEE MODAL ====== -->
    <?php if ($edit_fee): ?>
    <div class="modal fade show" id="editFeeModal" tabindex="-1" style="display: block; background: rgba(0,0,0,0.5);">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header border-0">
                    <h5 class="modal-title"><i class="fas fa-edit text-warning me-2"></i>Edit Fee</h5>
                    <button type="button" class="btn-close" onclick="window.location.href='fees.php'"></button>
                </div>
                <form method="post">
                    <div class="modal-body">
                        <div class="row g-3">
                            <input type="hidden" name="id" value="<?= $edit_fee['id'] ?>">
                            <div class="col-md-12">
                                <label class="form-label required">Fee Name</label>
                                <input type="text" class="form-control" name="fee_name" value="<?= htmlspecialchars($edit_fee['fee_name']) ?>" required>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Fee Type</label>
                                <select class="form-select" name="fee_type">
                                    <option value="">Select Fee Type</option>
                                    <option value="Tuition" <?= $edit_fee['fee_type'] == 'Tuition' ? 'selected' : '' ?>>Tuition</option>
                                    <option value="Exam" <?= $edit_fee['fee_type'] == 'Exam' ? 'selected' : '' ?>>Exam</option>
                                    <option value="Library" <?= $edit_fee['fee_type'] == 'Library' ? 'selected' : '' ?>>Library</option>
                                    <option value="Sports" <?= $edit_fee['fee_type'] == 'Sports' ? 'selected' : '' ?>>Sports</option>
                                    <option value="Lab" <?= $edit_fee['fee_type'] == 'Lab' ? 'selected' : '' ?>>Lab</option>
                                    <option value="Transport" <?= $edit_fee['fee_type'] == 'Transport' ? 'selected' : '' ?>>Transport</option>
                                    <option value="Hostel" <?= $edit_fee['fee_type'] == 'Hostel' ? 'selected' : '' ?>>Hostel</option>
                                    <option value="Other" <?= $edit_fee['fee_type'] == 'Other' ? 'selected' : '' ?>>Other</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label required">Amount (₹)</label>
                                <input type="number" class="form-control" name="amount" value="<?= $edit_fee['amount'] ?>" min="0" step="0.01" required>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Status</label>
                                <select class="form-select" name="status">
                                    <option value="Active" <?= $edit_fee['status'] == 'Active' ? 'selected' : '' ?>>Active</option>
                                    <option value="Inactive" <?= $edit_fee['status'] == 'Inactive' ? 'selected' : '' ?>>Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-outline-secondary rounded-pill" onclick="window.location.href='fees.php'">Cancel</button>
                        <button type="submit" name="edit_fee" class="btn btn-warning rounded-pill">
                            <i class="fas fa-edit me-2"></i>Update Fee
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- ====== FEES TABLE ====== -->
    <div class="card border-0 rounded-4 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-custom align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Fee Name</th>
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
                                            <span class="text-secondary small">Not specified</span>
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
                                    No fees found. Click "Add New Fee" to create one.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php if (count($fees) > 0): ?>
            <div class="card-footer bg-transparent border-top-0 p-3">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div class="text-secondary small">
                        <i class="fas fa-list me-1"></i>Total: <?= count($fees) ?> fees
                    </div>
                    <div class="d-flex gap-3">
                        <span class="badge bg-success-subtle text-success">
                            <i class="fas fa-check-circle me-1"></i>Active: <?= $active_fees ?>
                        </span>
                        <span class="badge bg-danger-subtle text-danger">
                            <i class="fas fa-times-circle me-1"></i>Inactive: <?= $total_fees - $active_fees ?>
                        </span>
                        <span class="badge bg-warning-subtle text-warning">
                            <i class="fas fa-rupee-sign me-1"></i>Total: ₹<?= number_format($total_amount, 0) ?>
                        </span>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>