<?php
include '../config/config.php';
include 'includes/auth_check.php'; 
checkRole(['admin']);
include 'includes/header.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_fee'])) {
    $fee_id = trim($_POST['fee_id'] ?? '');
    $fee_name = trim($_POST['fee_name'] ?? '');
    $fee_amount = trim($_POST['fee_amount'] ?? '');
    $status = trim($_POST['status'] ?? '');

    if ($fee_id === '' || $fee_name === '' || $fee_amount === '') {
        $error = 'Please fill in all required fields.';
    } else {
        try {
            $stmt = $conn->prepare("INSERT INTO fees (fee_id, fee_name, fee_amount, status) VALUES (?, ?, ?, ?)");
            $stmt->execute([$fee_id, $fee_name, $fee_amount, $status]);
            header('Location: fees.php');
            exit();
        } catch (Exception $e) {
            $error = 'Database error: ' . $e->getMessage();
        }
    }
}
if  ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_fee'])) {
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
            header('Location: fees.php');
            exit();
        } catch (Exception $e) {
            $error = 'Database error: ' . $e->getMessage();
        }
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_fee'])) {
    $fee_id = trim($_POST['fee_id'] ?? '');
    if ($fee_id !== '') {
        try {
            $stmt = $conn->prepare("DELETE FROM fees WHERE fee_id = ?");
            $stmt->execute([$fee_id]);
            header('Location: fees.php');
            exit();
        } catch (Exception $e) {
            $error = 'Database error: ' . $e->getMessage();
        }
    }
    try {
    $stmt = $conn->query("SELECT * FROM fees ORDER BY fee_id DESC");
    $fees = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $fees = [];
    if ($error === '') $error = 'Failed to load fees.';
}
}
   
?>
<div class="main-content">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h3 class="mb-1">Fees</h3>
            <div class="text-secondary small">Manage academic fees and their details.</div>
        </div>
    </div>
    <div class="card border-0 rounded-4 shadow-sm mb-4">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                <h5 class="mb-0">Add New Fee</h5>
                <span class="text-secondary small">Create a new academic fee record</span>
            </div>
            <form class="row g-3" method="post">
                <div class="col-md-6">
                    <label class="form-label">Fee id</label>
                    <input type="number" class="form-control" name="fee_id" placeholder="FEE001" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Fee Name</label>
                    <select class="form-select" name="fee_name">
                        <option value="Tuition Fee" selected>Tuition Fee</option>
                        <option value="Exam Fee">Exam Fee</option>
                        <option value="Library Fee">Library Fee</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Fee Amount</label>
                    <input type="number" class="form-control" name="fee_amount" placeholder="1000" min="0" step="0.01"
                        required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Status</label>
                    <select class="form-select" name="status">
                        <option value="Active" selected>Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>
                <div class="col-12 d-flex justify-content-end gap-2">
                    <button type="reset" class="btn btn-outline-secondary rounded-pill px-3">Reset</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-3">Save Fee</button>
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
                            <th>ID</th>
                            <th>Fee Name</th>
                            <th>Fee Amount</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Grade 1</td>
                            <td>38</td>
                            <td>8000</td>
                            <td><span class="status-badge bg-success-subtle text-success">Active</span></td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="#" class="text-primary text-decoration-none">View</a>
                                    <a href="#" class="text-primary text-decoration-none">Edit</a>
                                    <a href="#" class="text-primary text-decoration-none">Delete</a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Grade 3</td>
                            <td>41</td>
                            <td>80000</td>
                            <td><span class="status-badge bg-warning-subtle text-warning">Pending</span></td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="#" class="text-primary text-decoration-none">View</a>
                                    <a href="#" class="text-primary text-decoration-none">Edit</a>
                                    <a href="#" class="text-primary text-decoration-none">Delete</a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Grade 6</td>
                            <td>36</td>
                            <td>800000</td>
                            <td><span class="status-badge bg-success-subtle text-success">Active</span></td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="#" class="text-primary text-decoration-none">View</a>
                                    <a href="#" class="text-primary text-decoration-none">Edit</a>
                                    <a href="#" class="text-primary text-decoration-none">Delete</a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Grade 9</td>
                            <td>44</td>
                            <td>80000</td>
                            <td><span class="status-badge bg-success-subtle text-success">Active</span></td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="#" class="text-primary text-decoration-none">View</a>
                                    <a href="#" class="text-primary text-decoration-none">Edit</a>
                                    <a href="#" class="text-primary text-decoration-none">Delete</a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php
include 'includes/footer.php';?>