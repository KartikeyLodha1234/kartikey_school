<?php
include 'includes/header.php';
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
                                            <td><a href="#" class="text-primary text-decoration-none">View</a></td>
                                        </tr>
                                        <tr>
                                            <td>Grade 3</td>
                                            <td>41</td>
                                            <td><span class="status-badge bg-warning-subtle text-warning">Pending</span></td>
                                            <td><a href="#" class="text-primary text-decoration-none">View</a></td>
                                        </tr>
                                        <tr>
                                            <td>Grade 6</td>
                                            <td>36</td>
                                            <td><span class="status-badge bg-success-subtle text-success">Active</span></td>
                                            <td><a href="#" class="text-primary text-decoration-none">View</a></td>
                                        </tr>
                                        <tr>
                                            <td>Grade 9</td>
                                            <td>44</td>
                                            <td><span class="status-badge bg-success-subtle text-success">Active</span></td>
                                            <td><a href="#" class="text-primary text-decoration-none">View</a></td>
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