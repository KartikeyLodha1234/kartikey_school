<?php
ob_start();
include '../config/config.php';
include 'includes/auth_check.php';
checkRole(['admin']);

$id = intval($_GET['id'] ?? 0);
$printMode = isset($_GET['print']) && $_GET['print'] == '1';

if ($id <= 0) {
    echo "Invalid receipt id.";
    exit();
}

try {
    $stmt = $conn->prepare("SELECT sf.*, s.name as student_name, s.admission_no, c.class_name
        FROM student_fees sf
        LEFT JOIN students s ON sf.student_id = s.id
        LEFT JOIN classes c ON s.class_id = c.id
        WHERE sf.id = ?");
    $stmt->execute([$id]);
    $receipt = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $receipt = false;
}

if (!$receipt) {
    echo "Receipt not found.";
    exit();
}

// ====== FETCH ALL FEES FOR THIS STUDENT (Same Month & Year) ======
$all_fees = [];
try {
    $stmt = $conn->prepare("SELECT sf.*, f.fee_type 
                           FROM student_fees sf 
                           LEFT JOIN fees f ON sf.fee_id = f.id 
                           WHERE sf.student_id = ? AND sf.month = ? AND sf.year = ? 
                           ORDER BY sf.id");
    $stmt->execute([$receipt['student_id'], $receipt['month'], $receipt['year']]);
    $all_fees = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $all_fees = [];
}

// If no fees found, use the current receipt
if (empty($all_fees)) {
    $all_fees[] = $receipt;
}

// ====== CALCULATE TOTALS ======
$total_paid = 0;

foreach ($all_fees as $item) {
    // Use amount_paid as the main amount
    $amount = floatval($item['amount_paid'] ?? 0);
    $total_paid += $amount;
}

// If total_paid is still 0, try to get from receipt
if ($total_paid == 0 && isset($receipt['amount_paid'])) {
    $total_paid = floatval($receipt['amount_paid']);
}

// If still 0, try total_amount
if ($total_paid == 0 && isset($receipt['total_amount'])) {
    $total_paid = floatval($receipt['total_amount']);
}

function formatMoney($n) { 
    return '₹' . number_format((float)$n, 2); 
}

$payment_methods = [
    'cash' => 'Cash',
    'bank_transfer' => 'Bank Transfer',
    'card' => 'Credit/Debit Card',
    'upi' => 'UPI',
    'cheque' => 'Cheque',
    'online' => 'Online Payment'
];
$payment_method = $payment_methods[$receipt['payment_method'] ?? 'cash'] ?? 'Cash';

?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Receipt - REC-<?= date('Y') ?>-<?= str_pad($receipt['id'],4,'0',STR_PAD_LEFT) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        @page { margin: 15mm 10mm; size: A4 portrait; }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            background: #f0f2f5; 
            font-family: 'Segoe UI', Tahoma, Arial, sans-serif;
            padding: 20px;
        }
        .receipt-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            padding: 25px 30px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        }
        .school-name {
            font-size: 20px;
            font-weight: 800;
            color: #1a1a2e;
            letter-spacing: 1px;
        }
        .receipt-title {
            font-size: 13px;
            color: #2563eb;
            font-weight: 600;
        }
        .receipt-no {
            font-size: 14px;
            font-weight: 700;
            color: #1a1a2e;
        }
        .receipt-date {
            font-size: 13px;
            color: #6b7280;
        }
        .info-label {
            font-weight: 600;
            color: #4b5563;
            font-size: 13px;
        }
        .info-value {
            font-weight: 600;
            color: #1a1a2e;
            font-size: 14px;
        }
        .info-small {
            font-size: 12px;
            color: #6b7280;
        }
        .receipt-table {
            width: 100%;
            border-collapse: collapse;
            margin: 12px 0;
        }
        .receipt-table th {
            background: #f8f9fa;
            padding: 8px 12px;
            text-align: left;
            font-weight: 700;
            color: #1a1a2e;
            border-bottom: 2px solid #1a1a2e;
            font-size: 13px;
        }
        .receipt-table td {
            padding: 7px 12px;
            border-bottom: 1px solid #e5e7eb;
            color: #1a1a2e;
            font-size: 14px;
        }
        .receipt-table .text-right { text-align: right; }
        .receipt-table .text-center { text-align: center; }
        .total-row td {
            font-weight: 700;
            border-top: 2px solid #1a1a2e;
            font-size: 16px;
            padding: 10px 12px;
        }
        .total-amount {
            color: #2563eb;
            font-size: 18px;
        }
        .footer-text {
            font-size: 12px;
            color: #9ca3af;
            text-align: center;
            margin-top: 12px;
            padding-top: 10px;
            border-top: 1px solid #e5e7eb;
        }
        .footer-text .copy-label {
            font-size: 11px;
            letter-spacing: 2px;
            color: #2563eb;
            font-weight: 600;
            margin-top: 4px;
        }
        .print-btn-container {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
        }
        .print-btn-container button {
            padding: 10px 30px;
            border: none;
            border-radius: 50px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }
        .btn-print {
            background: #2563eb;
            color: white;
        }
        .btn-print:hover {
            background: #1d4ed8;
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(37,99,235,0.3);
        }
        .btn-back {
            background: #e5e7eb;
            color: #4b5563;
        }
        .btn-back:hover {
            background: #d1d5db;
        }
        .status-badge {
            display: inline-block;
            padding: 2px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .status-paid { background: #d1e7dd; color: #0f5132; }
        .status-partial { background: #fff3cd; color: #856404; }
        .status-pending { background: #f8d7da; color: #842029; }
        hr { margin: 10px 0; border-color: #e5e7eb; }
        @media print {
            body { background: white; padding: 0; margin: 0; }
            .receipt-container { box-shadow: none; border-radius: 0; padding: 15px 20px; max-width: 100%; margin: 0; }
            .print-btn-container { display: none !important; }
            .receipt-table th { background: #f8f9fa !important; -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>

<div class="receipt-container">
    
    <!-- ====== HEADER ====== -->
    <div class="d-flex align-items-center justify-content-between mb-2">
        <div class="d-flex align-items-center gap-3">
            <img src="../images/logo.png" alt="Logo" style="width:55px; height:55px; border-radius:50%; border:3px solid #2563eb; padding:2px; object-fit:cover;" 
                 onerror="this.style.display='none'; this.nextElementSibling.style.display='block'">
            <div style="display:none; font-size:28px;">🏫</div>
            <div>
                <div class="school-name">KARTIKEY SCHOOL</div>
                <div class="receipt-title">Student Fee Receipt</div>
            </div>
        </div>
        <div class="text-end">
            <div class="receipt-no"><i class="fas fa-receipt me-1"></i> REC-<?= date('Y') ?>-<?= str_pad($receipt['id'],4,'0',STR_PAD_LEFT) ?></div>
            <div class="receipt-date"><i class="far fa-calendar-alt me-1"></i> <?= !empty($receipt['paid_on']) ? date('d M Y', strtotime($receipt['paid_on'])) : date('d M Y') ?></div>
        </div>
    </div>

    <hr>

    <!-- ====== STUDENT INFO ====== -->
    <div class="row mb-2">
        <div class="col-md-5">
            <div class="info-label"><i class="fas fa-user-graduate me-1"></i> Student</div>
            <div class="info-value"><?= htmlspecialchars($receipt['student_name'] ?? '—') ?></div>
            <div class="info-small">Admission No: <?= htmlspecialchars($receipt['admission_no'] ?? '—') ?></div>
        </div>
        <div class="col-md-3">
            <div class="info-label"><i class="fas fa-school me-1"></i> Class</div>
            <div class="info-value"><?= htmlspecialchars($receipt['class_name'] ?? '—') ?></div>
        </div>
        <div class="col-md-4 text-end">
            <div class="info-label"><i class="fas fa-credit-card me-1"></i> Payment Method</div>
            <div class="info-value"><?= $payment_method ?></div>
            <div class="info-small">
                Status: 
                <?php 
                $status = $receipt['payment_status'] ?? 'Paid';
                if ($status == 'Paid') {
                    echo '<span class="status-badge status-paid">Paid</span>';
                } elseif ($status == 'Partial') {
                    echo '<span class="status-badge status-partial">Partial</span>';
                } else {
                    echo '<span class="status-badge status-pending">Pending</span>';
                }
                ?>
            </div>
        </div>
    </div>

    <!-- ====== FEE TABLE ====== -->
    <table class="receipt-table">
        <thead>
            <tr>
                <th style="width:45px;">#</th>
                <th>Fee Type</th>
                <th class="text-right" style="width:100px;">Amount</th>
                <th class="text-right" style="width:90px;">Late Fee</th>
                <th class="text-right" style="width:90px;">Discount</th>
                <th class="text-right" style="width:100px;">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($all_fees) > 0): ?>
                <?php $i = 1; foreach ($all_fees as $item): 
                    $amount = floatval($item['amount_paid'] ?? 0);
                    $late_fee = floatval($item['late_fee'] ?? 0);
                    $discount = floatval($item['discount'] ?? 0);
                    $total = $amount + $late_fee - $discount;
                ?>
                <tr>
                    <td class="text-center"><?= $i++ ?></td>
                    <td><?= htmlspecialchars($item['fee_type'] ?? 'Fee') ?></td>
                    <td class="text-right"><?= formatMoney($amount) ?></td>
                    <td class="text-right"><?= formatMoney($late_fee) ?></td>
                    <td class="text-right">- <?= formatMoney($discount) ?></td>
                    <td class="text-right"><strong><?= formatMoney($total) ?></strong></td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td class="text-center">1</td>
                    <td><?= htmlspecialchars($receipt['fee_type'] ?? 'Fee') ?></td>
                    <td class="text-right"><?= formatMoney($receipt['amount_paid'] ?? 0) ?></td>
                    <td class="text-right"><?= formatMoney($receipt['late_fee'] ?? 0) ?></td>
                    <td class="text-right">- <?= formatMoney($receipt['discount'] ?? 0) ?></td>
                    <td class="text-right"><strong><?= formatMoney(($receipt['amount_paid'] ?? 0) + ($receipt['late_fee'] ?? 0) - ($receipt['discount'] ?? 0)) ?></strong></td>
                </tr>
            <?php endif; ?>
            
            <!-- Total Row -->
            <tr class="total-row">
                <td colspan="5" class="text-right"><strong>Total</strong></td>
                <td class="text-right total-amount"><strong><?= formatMoney($total_paid) ?></strong></td>
            </tr>
        </tbody>
    </table>

    <!-- ====== FOOTER ====== -->
    <div class="footer-text">
        <i class="fas fa-qrcode me-1"></i> This is a computer generated receipt. Does not require signature.
        <div class="copy-label">PARENT COPY</div>
    </div>

</div>

<!-- ====== PRINT BUTTONS ====== -->
<div class="print-btn-container no-print">
    <button class="btn-back" onclick="window.location.href='student_fees.php'">
        <i class="fas fa-arrow-left me-2"></i>Back
    </button>
    <button class="btn-print" onclick="window.print()">
        <i class="fas fa-print me-2"></i>Print Receipt
    </button>
</div>

<script>
    var printMode = <?= $printMode ? 'true' : 'false' ?>;
    if (printMode) {
        setTimeout(function(){ window.print(); }, 500);
    }
</script>

</body>
</html>
<?php ob_end_flush(); ?>