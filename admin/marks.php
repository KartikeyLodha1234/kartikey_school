<?php
include 'includes/header.php';
?>
<div class="main-content">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h3 class="mb-1">Marks</h3>
            <div class="text-secondary small">Manage student marks and grades.</div>
        </div>
    </div>

    <div class="card border-0 rounded-4 shadow-sm mb-4">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                <h5 class="mb-0">Add New Mark Entry</h5>
                <span class="text-secondary small">Create a new mark record for a student</span>
            </div>
            <form class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">id</label>
                    <input type="number" class="form-control" placeholder="1">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Class</label>
                    <select class="form-select" name="class">
                        <option selected disabled>Select Class</option>
                        <option>Grade 1</option>
                        <option>Grade 2</option>
                        <option>Grade 3</option>
                        <option>Grade 4</option>
                        <option>Grade 5</option>
                        <option>Grade 6</option>
                        <option>Grade 7</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Subject Name</label>
                    <select class="form-select" name="subject_name">
                        <option selected disabled>Select subject</option>
                        <option>ok</option>
                        <option>G 2</option>
                        <option>scs</option>
                        <option>Grade 4</option>
                        <option>Grade 5</option>
                        <option>Grade 6</option>
                        <option>Grade 7</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Subject Marks</label>
                    <input type="number" class="form-control" placeholder="500">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Exam Type</label>
                    <select class="form-select" name="exam_type">
                        <option selected disabled>Select Exam Type</option>
                        <option>Unit Test</option>
                        <option>Monthly Test</option>
                        <option>Quarterly Exam</option>
                        <option>Half Yearly Exam</option>
                        <option>Pre Board Exam</option>
                        <option>Annual Exam</option>
                    </select>
                </div>
                <div class="col-12 d-flex justify-content-end gap-2">
                    <button type="reset" class="btn btn-outline-secondary rounded-pill px-3">Reset</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-3">Save Class</button>
                </div>
            </form>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="stat-label">Total Classes</div>
                        <div class="stat-number">18</div>
                    </div>
                    <div class="stat-icon" style="background:#2563eb;"><i class="fas fa-school"></i></div>
                </div>
                <div class="stat-sub">Across primary and senior wing</div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="stat-label">Active Sections</div>
                        <div class="stat-number">42</div>
                    </div>
                    <div class="stat-icon" style="background:#0ea5e9;"><i class="fas fa-layer-group"></i></div>
                </div>
                <div class="stat-sub">Sections currently running</div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="stat-label">Students Enrolled</div>
                        <div class="stat-number">826</div>
                    </div>
                    <div class="stat-icon" style="background:#f59e0b;"><i class="fas fa-user-graduate"></i></div>
                </div>
                <div class="stat-sub">Live student count</div>
            </div>
        </div>
    </div>

    <div class="card border-0 rounded-4 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-custom align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Class</th>
                            <th>Students</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Grade 1</td>
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
                            <td>Grade 3</td>
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
                            <td>Grade 6</td>
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
                            <td>Grade 9</td>
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