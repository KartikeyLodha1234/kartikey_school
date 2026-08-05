<?php
include '../config/config.php';
include 'includes/auth_check.php'; 
checkRole(['admin']);
include 'includes/header.php';
?>
<div class="main-content">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h3 class="mb-1">Section</h3>
            <div class="text-secondary small">Manage academic class strength.</div>
        </div>
    </div>
    <div class="card border-0 rounded-4 shadow-sm mb-4">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                <h5 class="mb-0">Add New Section</h5>
                <span class="text-secondary small">Create a new academic section record</span>
            </div>
            <form class="row g-3" method="post">
                 <div class="col-md-4">
                    <label class="form-label">Class id</label>
                    <input type="text" class="form-control" name="class_id" placeholder="Class ID" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Class Name</label>
                    <input type="text" class="form-control" name="class_name" placeholder="Grade 10" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Section</label>
                    <select class="form-select" name="section">
                        <option value="A" selected>A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Student Capacity</label>
                    <input type="number" class="form-control" name="student_capacity" placeholder="40" min="1" required>
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
                            <th>id</th>
                            <th>Class</th>
                            <th>Section</th>
                            <th>Students</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Grade 1</td>
                            <td>A</td>
                            <td>38</td>
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
                            <td>2</td>
                            <td>Grade 3</td>
                            <td>B</td>
                            <td>41</td>
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
                        <td>3</td>
                            <td>Grade 6</td>
                            <td>C</td>
                            <td>36</td>
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
                            <td>4</td>
                            <td>Grade 9</td>
                            <td>D</td>
                            <td>44</td>
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
include 'includes/footer.php';
?>