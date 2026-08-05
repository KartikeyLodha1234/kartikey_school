<?php
include 'includes/header.php';
?>

<div class="card border-0 rounded-4 shadow-sm mt-4">
    <div class="card-header bg-transparent border-bottom d-flex justify-content-between align-items-center p-3">
        <h5 class="mb-0"><i class="fas fa-file-alt text-primary me-2"></i>Student Report Card</h5>
        <span class="badge bg-primary rounded-pill">Term 1, 2026</span>
    </div>
    <div class="card-body p-0">
        <div class="p-3 bg-light rounded-4 m-3">
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="d-flex align-items-center gap-3">
                        <div class="avatar-lg bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width:60px;height:60px;font-size:24px;">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">Rahul Sharma</h6>
                            <div class="text-secondary small">Class: Grade 10-A | Roll: 12</div>
                            <div class="text-secondary small">Admission: 2024-25</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 text-md-end">
                    <div><span class="text-secondary small">Attendance: </span><strong>94%</strong></div>
                    <div><span class="text-secondary small">Overall Grade: </span><span class="badge bg-success">A</span></div>
                    <div><span class="text-secondary small">GPA: </span><strong>8.7</strong> / 10</div>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-custom align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Subject</th>
                        <th>Teacher</th>
                        <th>Marks (Max 100)</th>
                        <th>Grade</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td><strong>Mathematics</strong></td>
                        <td>Mr. Rajesh Kumar</td>
                        <td>92</td>
                        <td><span class="badge bg-success">A</span></td>
                        <td><span class="status-badge bg-success-subtle text-success">Pass</span></td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td><strong>Physics</strong></td>
                        <td>Mrs. Priya Sharma</td>
                        <td>78</td>
                        <td><span class="badge bg-warning text-dark">B+</span></td>
                        <td><span class="status-badge bg-success-subtle text-success">Pass</span></td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td><strong>Chemistry</strong></td>
                        <td>Mr. Amit Singh</td>
                        <td>65</td>
                        <td><span class="badge bg-info text-dark">B</span></td>
                        <td><span class="status-badge bg-success-subtle text-success">Pass</span></td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td><strong>Biology</strong></td>
                        <td>Ms. Neha Patel</td>
                        <td>88</td>
                        <td><span class="badge bg-success">A-</span></td>
                        <td><span class="status-badge bg-success-subtle text-success">Pass</span></td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td><strong>English</strong></td>
                        <td>Mrs. Sangeeta Verma</td>
                        <td>45</td>
                        <td><span class="badge bg-danger">F</span></td>
                        <td><span class="status-badge bg-danger-subtle text-danger">Fail</span></td>
                    </tr>
                </tbody>
                <tfoot class="table-light">
                    <tr>
                        <td colspan="3" class="text-end fw-bold">Total / Average</td>
                        <td><strong>368 / 73.6</strong></td>
                        <td><span class="badge bg-warning text-dark">B+</span></td>
                        <td>—</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <div class="card-footer bg-transparent border-top-0 p-3 d-flex justify-content-between">
        <div class="text-secondary small">
            <i class="fas fa-print me-2"></i>Printed on: 05 Aug 2026
        </div>
        <div>
            <button class="btn btn-outline-primary rounded-pill btn-sm me-2"><i class="fas fa-print"></i> Print</button>
            <button class="btn btn-primary rounded-pill btn-sm"><i class="fas fa-download"></i> Download PDF</button>
        </div>
    </div>
</div>