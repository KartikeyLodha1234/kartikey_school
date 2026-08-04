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
                <div class="col-md-6">
                    <label class="form-label">Subject id</label>
                    <input type="number" class="form-control" name="subject_id" placeholder="SUB001">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Subject Code</label>
                    <input type="text" class="form-control" name="subject_code" placeholder="001">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Subject Name</label>
                    <input type="text" class="form-control" name="subject_name" placeholder="Mathematics" required>
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
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="stat-label">Total Subjects</div>
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
                        <div class="stat-label">Active Subjects</div>
                        <div class="stat-number">42</div>
                    </div>
                    <div class="stat-icon" style="background:#0ea5e9;"><i class="fas fa-layer-group"></i></div>
                </div>
                <div class="stat-sub">Sections currently running</div>
            </div>
        </div>
    </div>
    <div class="card border-0 rounded-4 shadow-sm mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0"><i
                                class="fas fa-search text-secondary"></i></span>
                        <input type="text" class="form-control border-start-0" placeholder="Search subjects..." />
                    </div>
                </div>
                <div class="col-md-3">
                    <select class="form-select">
                        <option value="">All Classes</option>
                        <option value="1">Grade 1</option>
                        <option value="2">Grade 2</option>
                        <option value="3">Grade 3</option>
                        <option value="4">Grade 4</option>
                        <option value="5">Grade 5</option>
                        <option value="6">Grade 6</option>
                        <option value="7">Grade 7</option>
                        <option value="8">Grade 8</option>
                        <option value="9">Grade 9</option>
                        <option value="10">Grade 10</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select">
                        <option value="">All Subjects</option>
                        <option value="core">Core/Compulsory</option>
                        <option value="elective">Elective</option>
                        <option value="optional">Optional</option>
                        <option value="vocational">Vocational</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary w-100 rounded-pill">
                        <i class="fas fa-filter me-2"></i>Filter
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="card border-0 rounded-4 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-custom align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Subject Name</th>
                            <th>Code</th>
                            <th>Class</th>
                            <th>Teacher</th>
                            <th>Students</th>
                            <th>Pass %</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td><strong>Mathematics</strong></td>
                            <td><span class="badge bg-light text-dark">MATH-101</span></td>
                            <td>Grade 10</td>
                            <td>Mr. Rajesh Kumar</td>
                            <td>38</td>
                            <td>92%</td>
                            <td><span class="status-badge bg-success-subtle text-success">Active</span></td>
                            <td>
                                <div class="d-flex gap-1">
                                    <button class="btn btn-sm btn-outline-primary rounded-circle" title="View"><i
                                            class="fas fa-eye"></i></button>
                                    <button class="btn btn-sm btn-outline-warning rounded-circle" title="Edit"><i
                                            class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-outline-danger rounded-circle" title="Delete"><i
                                            class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td><strong>Physics</strong></td>
                            <td><span class="badge bg-light text-dark">PHY-201</span></td>
                            <td>Grade 10</td>
                            <td>Mrs. Priya Sharma</td>
                            <td>36</td>
                            <td>88%</td>
                            <td><span class="status-badge bg-success-subtle text-success">Active</span></td>
                            <td>
                                <div class="d-flex gap-1">
                                    <button class="btn btn-sm btn-outline-primary rounded-circle"><i
                                            class="fas fa-eye"></i></button>
                                    <button class="btn btn-sm btn-outline-warning rounded-circle"><i
                                            class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-outline-danger rounded-circle"><i
                                            class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td><strong>Chemistry</strong></td>
                            <td><span class="badge bg-light text-dark">CHEM-301</span></td>
                            <td>Grade 10</td>
                            <td>Mr. Amit Singh</td>
                            <td>35</td>
                            <td>85%</td>
                            <td><span class="status-badge bg-warning-subtle text-warning">Pending</span></td>
                            <td>
                                <div class="d-flex gap-1">
                                    <button class="btn btn-sm btn-outline-primary rounded-circle"><i
                                            class="fas fa-eye"></i></button>
                                    <button class="btn btn-sm btn-outline-warning rounded-circle"><i
                                            class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-outline-danger rounded-circle"><i
                                            class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td><strong>Biology</strong></td>
                            <td><span class="badge bg-light text-dark">BIO-401</span></td>
                            <td>Grade 9</td>
                            <td>Ms. Neha Patel</td>
                            <td>40</td>
                            <td>90%</td>
                            <td><span class="status-badge bg-success-subtle text-success">Active</span></td>
                            <td>
                                <div class="d-flex gap-1">
                                    <button class="btn btn-sm btn-outline-primary rounded-circle"><i
                                            class="fas fa-eye"></i></button>
                                    <button class="btn btn-sm btn-outline-warning rounded-circle"><i
                                            class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-outline-danger rounded-circle"><i
                                            class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td><strong>English</strong></td>
                            <td><span class="badge bg-light text-dark">ENG-501</span></td>
                            <td>Grade 8</td>
                            <td>Mrs. Sangeeta Verma</td>
                            <td>42</td>
                            <td>94%</td>
                            <td><span class="status-badge bg-success-subtle text-success">Active</span></td>
                            <td>
                                <div class="d-flex gap-1">
                                    <button class="btn btn-sm btn-outline-primary rounded-circle"><i
                                            class="fas fa-eye"></i></button>
                                    <button class="btn btn-sm btn-outline-warning rounded-circle"><i
                                            class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-outline-danger rounded-circle"><i
                                            class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-transparent border-top-0 p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-secondary small">Showing 1-5 of 24 subjects</div>
                <nav>
                    <ul class="pagination pagination-custom mb-0">
                        <li class="page-item disabled"><a class="page-link" href="#"><i
                                    class="fas fa-chevron-left"></i></a></li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">4</a></li>
                        <li class="page-item"><a class="page-link" href="#">5</a></li>
                        <li class="page-item"><a class="page-link" href="#"><i class="fas fa-chevron-right"></i></a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
<?php
include 'includes/footer.php';
?>