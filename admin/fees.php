<?php
include 'includes/header.php';
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
                    <input type="number" class="form-control" name="fee_amount" placeholder="1000" min="0" step="0.01" required>
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
</div>