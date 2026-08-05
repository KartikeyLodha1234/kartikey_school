<?php
include '../config/config.php';
include 'includes/auth_check.php'; 
checkRole(['admin']);
include 'includes/header.php';

// ====== HANDLE ADD FEE ======
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_fee'])) {
    $fee_id = trim($_POST['fee_id'] ?? '');
    $fee_name = trim($_POST['fee_name'] ?? '');
    $fee_amount = trim($_POST['fee_amount'] ?? '');
    $status = trim($_POST['status'] ?? 'Active');

    if ($fee_id === '' || $fee_name === '' || $fee_amount === '') {
        $error = 'Please fill in all required fields.';
    } else {
        try {
            $stmt = $conn->prepare("INSERT INTO fees (fee_id, fee_name, fee_amount, status) VALUES (?, ?, ?, ?)");
            $stmt->execute([$fee_id, $fee_name, $fee_amount, $status]);
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
    $fee_id = trim($_POST['fee_id'] ?? '');
    $fee_name = trim($_POST['fee_name'] ?? '');
    $fee_amount = trim($_POST['fee_amount'] ?? '');
    $status = trim($_POST['status'] ?? '');

    if ($fee_id === '' || $fee_name === '' || $fee_amount === '') {
        $error = 'Please fill in all required fields.';
    } else {
        try {
            $stmt = $conn->prepare("UPDATE fees SET fee_name = ?, fee_amount = ?, status = ? WHERE fee_id = ?");
            $stmt->execute([$fee_name, $fee_amount, $status, $fee_id]);
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
    $fee_id = trim($_POST['fee_id'] ?? '');
    if ($fee_id !== '') {
        try {
            $stmt = $conn->prepare("DELETE FROM fees WHERE fee_id = ?");
            $stmt->execute([$fee_id]);
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
    $stmt = $conn->query("SELECT * FROM fees ORDER BY fee_id DESC");
    $fees = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $fees = [];
    $error = 'Failed to load fees: ' . $e->getMessage();
}

// ====== FETCH SINGLE FEE FOR EDIT (AJAX/Modal) ======
$edit_fee = null;
if (isset($_GET['edit_id'])) {
    try {
        $stmt = $conn->prepare("SELECT * FROM fees WHERE fee_id = ?");
        $stmt->execute([$_GET['edit_id']]);
        $edit_fee = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        $error = 'Failed to load fee details.';
    }
}
?>

<!-- ====== PAGE CONTENT ====== -->
<div class="main-content">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h3 class="mb-1"><i class="fas fa-money-bill-wave text-primary me-2"></i>Fees Management</h3>
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
            <i class="fas fa-check-circle me-2"></i><?= $_SESSION['success'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger alert-dismissible fade show rounded-4" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i><?= $error ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

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
                            <div class="col-md-6">
                                <label class="form-label required">Fee ID</label>
                                <input type="text" class="form-control" name="fee_id" placeholder="FEE001" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label required">Fee Name</label>
                                <input type="text" class="form-control" name="fee_name" placeholder="Tuition Fee" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label required">Fee Amount (₹)</label>
                                <input type="number" class="form-control" name="fee_amount" placeholder="1000" min="0" step="0.01" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Status</label>
                                <select class="form-select" name="status">
                                    <option value="Active" selected>Active</option>
                                    <option value="Inactive">Inactive</option>
                                    <option value="Pending">Pending</option>
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
                            <div class="col-md-6">
                                <label class="form-label">Fee ID</label>
                                <input type="text" class="form-control" name="fee_id" value="<?= htmlspecialchars($edit_fee['fee_id']) ?>" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label required">Fee Name</label>
                                <input type="text" class="form-control" name="fee_name" value="<?= htmlspecialchars($edit_fee['fee_name']) ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label required">Fee Amount (₹)</label>
                                <input type="number" class="form-control" name="fee_amount" value="<?= htmlspecialchars($edit_fee['fee_amount']) ?>" min="0" step="0.01" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Status</label>
                                <select class="form-select" name="status">
                                    <option value="Active" <?= $edit_fee['status'] == 'Active' ? 'selected' : '' ?>>Active</option>
                                    <option value="Inactive" <?= $edit_fee['status'] == 'Inactive' ? 'selected' : '' ?>>Inactive</option>
                                    <option value="Pending" <?= $edit_fee['status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
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
                            <th>Fee ID</th>
                            <th>Fee Name</th>
                            <th>Fee Amount (₹)</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($fees) > 0): ?>
                            <?php $i = 1; foreach ($fees as $fee): ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><span class="badge bg-light text-dark"><?= htmlspecialchars($fee['fee_id']) ?></span></td>
                                    <td><strong><?= htmlspecialchars($fee['fee_name']) ?></strong></td>
                                    <td>₹ <?= number_format($fee['fee_amount'], 2) ?></td>
                                    <td>
                                        <?php
                                        $status_class = '';
                                        $status_text = '';
                                        switch ($fee['status']) {
                                            case 'Active':
                                                $status_class = 'bg-success-subtle text-success';
                                                $status_text = 'Active';
                                                break;
                                            case 'Inactive':
                                                $status_class = 'bg-danger-subtle text-danger';
                                                $status_text = 'Inactive';
                                                break;
                                            case 'Pending':
                                                $status_class = 'bg-warning-subtle text-warning';
                                                $status_text = 'Pending';
                                                break;
                                            default:
                                                $status_class = 'bg-secondary-subtle text-secondary';
                                                $status_text = $fee['status'];
                                        }
                                        ?>
                                        <span class="status-badge <?= $status_class ?>"><?= $status_text ?></span>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="fees.php?edit_id=<?= $fee['fee_id'] ?>" class="btn btn-sm btn-outline-primary rounded-pill">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form method="post" onsubmit="return confirm('Are you sure you want to delete this fee?')">
                                                <input type="hidden" name="fee_id" value="<?= $fee['fee_id'] ?>">
                                                <button type="submit" name="delete_fee" class="btn btn-sm btn-outline-danger rounded-pill">
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
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-secondary small">
                        Showing <?= count($fees) ?> fee<?= count($fees) > 1 ? 's' : '' ?> total
                    </div>
                    <div class="text-secondary small">
                        <i class="fas fa-calendar-alt me-1"></i>Last updated: <?= date('d M Y, h:i A') ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?> 