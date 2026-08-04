<?php
include 'includes/header.php';
?>
<div class="main-content">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h3 class="mb-1">📚 Subjects</h3>
            <div class="text-secondary small">Manage academic subjects and their details.</div>
        </div>
    </div>
    <div class="card border-0 rounded-4 shadow-sm mb-4">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                <h5 class="mb-0">Add New Subject</h5>
                <span class="text-secondary small">Create a new academic subject record</span>
            </div>
            <form class="row g-3" method="post">
                <div class="col-md-4">
                    <label class="form-label">Subject Name</label>
                    <input type="text" class="form-control" name="subject_name" placeholder="Mathematics" required>
                </div>
            </form>
        </div>
    </div>
</div>