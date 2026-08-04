<?php
include 'includes/header.php';
?>
<div class="main-content">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h3 class="mb-1"><i class="fas fa-id-card text-primary me-2"></i>Student ID Card</h3>
            <div class="text-secondary small">Generate and manage student identity cards.</div>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-primary rounded-pill px-3">
                <i class="fas fa-print me-2"></i>Print All
            </button>
            <button class="btn btn-primary rounded-pill px-3">
                <i class="fas fa-plus me-2"></i>Generate ID Card
            </button>
        </div>
    </div>
    <div class="card border-0 rounded-4 shadow-sm mb-4">
        <div class="card-body">
            <div class="row g-3 align-items-center">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0">
                            <i class="fas fa-search text-secondary"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" placeholder="Search by name, admission no..." />
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
                        <option value="11">Grade 11</option>
                        <option value="12">Grade 12</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select">
                        <option value="">All Status</option>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                        <option value="Expired">Expired</option>
                    </select>
                </div>
                <div class="col-md-2">
                   <button class="btn btn-primary w-100 rounded-pill">
                        <i class="fas fa-search me-2"></i> Search
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
                            <th>
                                <input type="checkbox" class="form-check-input">
                            </th>
                            <th>#</th>
                            <th>Admission No</th>
                            <th>Student Name</th>
                            <th>Class</th>
                            <th>Section</th>
                            <th>DOB</th>
                            <th>Contact</th>
                            <th>Valid Till</th>
                            <th>Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <input type="checkbox" class="form-check-input">
                            </td>
                            <td>1</td>
                            <td><span class="badge bg-light text-dark">ADM-2025-001</span></td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <img src="https://ui-avatars.com/api/?name=Aarav+Sharma&background=2563eb&color=fff&size=30" alt="Student" style="width: 30px; height: 30px; border-radius: 50%;">
                                    <strong>Aarav Sharma</strong>
                                </div>
                            </td>
                            <td>Grade 10</td>
                            <td>A</td>
                            <td>15 Jan 2010</td>
                            <td>+91 98765 43210</td>
                            <td>Mar 2026</td>
                            <td><span class="status-badge bg-success-subtle text-success">✅ Active</span></td>
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    <button class="btn btn-sm btn-outline-primary rounded-circle" title="Print">
                                        <i class="fas fa-print"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-warning rounded-circle" title="Download">
                                        <i class="fas fa-download"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger rounded-circle" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" class="form-check-input">
                            </td>
                            <td>2</td>
                            <td><span class="badge bg-light text-dark">ADM-2025-002</span></td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <img src="https://ui-avatars.com/api/?name=Priya+Patel&background=2563eb&color=fff&size=30" alt="Student" style="width: 30px; height: 30px; border-radius: 50%;">
                                    <strong>Priya Patel</strong>
                                </div>
                            </td>
                            <td>Grade 8</td>
                            <td>B</td>
                            <td>22 Mar 2012</td>
                            <td>+91 87654 32109</td>
                            <td>Mar 2026</td>
                            <td><span class="status-badge bg-success-subtle text-success">✅ Active</span></td>
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    <button class="btn btn-sm btn-outline-primary rounded-circle"><i class="fas fa-print"></i></button>
                                    <button class="btn btn-sm btn-outline-warning rounded-circle"><i class="fas fa-download"></i></button>
                                    <button class="btn btn-sm btn-outline-danger rounded-circle"><i class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" class="form-check-input">
                            </td>
                            <td>3</td>
                            <td><span class="badge bg-light text-dark">ADM-2025-003</span></td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <img src="https://ui-avatars.com/api/?name=Rohit+Singh&background=2563eb&color=fff&size=30" alt="Student" style="width: 30px; height: 30px; border-radius: 50%;">
                                    <strong>Rohit Singh</strong>
                                </div>
                            </td>
                            <td>Grade 11</td>
                            <td>A</td>
                            <td>05 Jun 2009</td>
                            <td>+91 76543 21098</td>
                            <td>Mar 2026</td>
                            <td><span class="status-badge bg-warning-subtle text-warning">🟡 Pending</span></td>
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    <button class="btn btn-sm btn-outline-primary rounded-circle"><i class="fas fa-print"></i></button>
                                    <button class="btn btn-sm btn-outline-warning rounded-circle"><i class="fas fa-download"></i></button>
                                    <button class="btn btn-sm btn-outline-danger rounded-circle"><i class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" class="form-check-input">
                            </td>
                            <td>4</td>
                            <td><span class="badge bg-light text-dark">ADM-2025-004</span></td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <img src="https://ui-avatars.com/api/?name=Sneha+Reddy&background=2563eb&color=fff&size=30" alt="Student" style="width: 30px; height: 30px; border-radius: 50%;">
                                    <strong>Sneha Reddy</strong>
                                </div>
                            </td>
                            <td>Grade 6</td>
                            <td>C</td>
                            <td>18 Sep 2014</td>
                            <td>+91 65432 10987</td>
                            <td>Mar 2026</td>
                            <td><span class="status-badge bg-danger-subtle text-danger">❌ Inactive</span></td>
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    <button class="btn btn-sm btn-outline-primary rounded-circle"><i class="fas fa-print"></i></button>
                                    <button class="btn btn-sm btn-outline-warning rounded-circle"><i class="fas fa-download"></i></button>
                                    <button class="btn btn-sm btn-outline-danger rounded-circle"><i class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" class="form-check-input">
                            </td>
                            <td>5</td>
                            <td><span class="badge bg-light text-dark">ADM-2025-005</span></td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <img src="https://ui-avatars.com/api/?name=Amit+Kumar&background=2563eb&color=fff&size=30" alt="Student" style="width: 30px; height: 30px; border-radius: 50%;">
                                    <strong>Amit Kumar</strong>
                                </div>
                            </td>
                            <td>Grade 3</td>
                            <td>B</td>
                            <td>22 Nov 2016</td>
                            <td>+91 54321 09876</td>
                            <td>Mar 2026</td>
                            <td><span class="status-badge bg-success-subtle text-success">✅ Active</span></td>
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    <button class="btn btn-sm btn-outline-primary rounded-circle"><i class="fas fa-print"></i></button>
                                    <button class="btn btn-sm btn-outline-warning rounded-circle"><i class="fas fa-download"></i></button>
                                    <button class="btn btn-sm btn-outline-danger rounded-circle"><i class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" class="form-check-input">
                            </td>
                            <td>6</td>
                            <td><span class="badge bg-light text-dark">ADM-2025-006</span></td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <img src="https://ui-avatars.com/api/?name=Neha+Verma&background=2563eb&color=fff&size=30" alt="Student" style="width: 30px; height: 30px; border-radius: 50%;">
                                    <strong>Neha Verma</strong>
                                </div>
                            </td>
                            <td>Grade 9</td>
                            <td>A</td>
                            <td>10 Feb 2011</td>
                            <td>+91 98765 01234</td>
                            <td>Mar 2026</td>
                            <td><span class="status-badge bg-success-subtle text-success">✅ Active</span></td>
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    <button class="btn btn-sm btn-outline-primary rounded-circle"><i class="fas fa-print"></i></button>
                                    <button class="btn btn-sm btn-outline-warning rounded-circle"><i class="fas fa-download"></i></button>
                                    <button class="btn btn-sm btn-outline-danger rounded-circle"><i class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-transparent border-top-0 p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-secondary small">Showing 1-6 of 156 ID cards</div>
                <nav>
                    <ul class="pagination pagination-custom mb-0">
                        <li class="page-item disabled"><a class="page-link" href="#"><i class="fas fa-chevron-left"></i></a></li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">4</a></li>
                        <li class="page-item"><a class="page-link" href="#">5</a></li>
                        <li class="page-item"><a class="page-link" href="#"><i class="fas fa-chevron-right"></i></a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
<?php
include 'includes/footer.php';
?>