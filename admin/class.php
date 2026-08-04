<?php
include '../config/config.php';
include 'includes/header.php';

$classes = $conn->query("SELECT id, class_name, section_count FROM classes ORDER BY id ASC")->fetchAll();
?>
<div class="main-content">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h3 class="mb-1">Classes</h3>
            <div class="text-secondary small">Manage academic class strength.</div>
        </div>
    </div>

    <div class="card border-0 rounded-4 shadow-sm mb-4">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                <h5 class="mb-0">Add New Class</h5>
                <span class="text-secondary small">Create a new academic class record</span>
            </div>
            <form class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Class id</label>
                    <input type="text" class="form-control" placeholder="Class ID">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Class Name</label>
                    <input type="text" class="form-control" placeholder="Grade 10">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Student Capacity</label>
                    <input type="number" class="form-control" placeholder="40">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Status</label>
                    <select class="form-select">
                        <option selected>Active</option>
                        <option>Inactive</option>
                    </select>
                </div>
                <div class="col-12 d-flex justify-content-end gap-2">
                    <button type="reset" class="btn btn-outline-secondary rounded-pill px-3">Reset</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-3">Save Class</button>
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
                            <th>Class ID</th>
                            <th>Class</th>
                            <th>Students</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($classes)): ?>
                            <?php foreach ($classes as $row): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                                    <td><?php echo htmlspecialchars($row['class_name']); ?></td>
                                    <td><?php echo (int)$row['section_count']; ?></td>
                                    <td><span class="status-badge bg-success-subtle text-success">Active</span></td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="#" class="text-primary text-decoration-none">View</a>
                                            <a href="#" class="text-primary text-decoration-none">Edit</a>
                                            <a href="#" class="text-primary text-decoration-none">Delete</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center text-secondary py-4">No classes found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php
include 'includes/footer.php';
?>