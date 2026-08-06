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

// ====== FETCH ALL FEES FOR THIS STUDENT (For Multiple Fee Types) ======
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

// If multiple fees exist, use them, otherwise use single receipt
$fee_items = $all_fees;

// Calculate totals
$total_amount = 0;
$total_late_fee = 0;
$total_discount = 0;
$total_paid = 0;

foreach ($fee_items as $item) {
    $total_amount += floatval($item['amount_paid'] ?? 0);
    $total_late_fee += floatval($item['late_fee'] ?? 0);
    $total_discount += floatval($item['discount'] ?? 0);
    $total_paid += floatval($item['total_amount'] ?? $item['amount_paid'] ?? 0);
}

// If no fee items found, use single receipt
if (empty($fee_items)) {
    $fee_items[] = $receipt;
    $total_amount = floatval($receipt['amount_paid'] ?? 0);
    $total_late_fee = floatval($receipt['late_fee'] ?? 0);
    $total_discount = floatval($receipt['discount'] ?? 0);
    $total_paid = floatval($receipt['total_amount'] ?? $receipt['amount_paid'] ?? 0);
}

function formatMoney($n) { 
    return '₹' . number_format((float)$n, 2); 
}

// Get payment method display
$method_names = [
    'cash' => 'Cash',
    'bank_transfer' => 'Bank Transfer',
    'card' => 'Credit/Debit Card',
    'upi' => 'UPI',
    'cheque' => 'Cheque',
    'online' => 'Online Payment'
];
$payment_method = $method_names[$receipt['payment_method'] ?? 'cash'] ?? 'Cash';

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
        @page { 
            margin: 15mm 10mm; 
            size: A4 portrait;
        }
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
            padding: 30px 35px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        }
        .school-name {
            font-size: 22px;
            font-weight: 800;
            color: #1a1a2e;
            letter-spacing: 1px;
        }
        .receipt-title {
            font-size: 14px;
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
            margin: 15px 0;
        }
        .receipt-table th {
            background: #f8f9fa;
            padding: 10px 12px;
            text-align: left;
            font-weight: 700;
            color: #1a1a2e;
            border-bottom: 2px solid #1a1a2e;
            font-size: 13px;
        }
        .receipt-table td {
            padding: 8px 12px;
            border-bottom: 1px solid #e5e7eb;
            color: #1a1a2e;
            font-size: 14px;
        }
        .receipt-table .text-right { text-align: right; }
        .receipt-table .text-center { text-align: center; }
        .receipt-table tbody tr:hover { background: #f8fafc; }
        .total-row td {
            font-weight: 700;
            border-top: 2px solid #1a1a2e;
            font-size: 16px;
        }
        .total-amount {
            color: #2563eb;
            font-size: 18px;
        }
        .remarks-text {
            font-size: 13px;
            color: #4b5563;
            padding: 8px 0;
        }
        .footer-text {
            font-size: 12px;
            color: #9ca3af;
            text-align: center;
            margin-top: 15px;
            padding-top: 12px;
            border-top: 1px solid #e5e7eb;
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

        @media print {
            body { 
                background: white; 
                padding: 0; 
                margin: 0; 
            }
            .receipt-container {
                box-shadow: none;
                border-radius: 0;
                padding: 15px 20px;
                max-width: 100%;
                margin: 0;
            }
            .print-btn-container {
                display: none !important;
            }
            .receipt-table th {
                background: #f8f9fa !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>

<div class="receipt-container" id="receiptContainer">
    
    <!-- ====== HEADER ====== -->
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div class="d-flex align-items-center gap-3">
            <img src="../images/logo.png" alt="Logo" style="width:60px; height:60px; border-radius:50%; border:3px solid #2563eb; padding:2px; object-fit:cover;" 
                 onerror="this.style.display='none'; this.nextElementSibling.style.display='block'">
            <div style="display:none; font-size:30px;">🏫</div>
            <div>
                <div class="school-name">KARTIKEY SCHOOL</div>
                <div class="receipt-title">Student Fee Receipt</div>
            </div>
        </div>
        <div class="text-end">
            <div class="receipt-no">REC-<?= date('Y') ?>-<?= str_pad($receipt['id'],4,'0',STR_PAD_LEFT) ?></div>
            <div class="receipt-date"><i class="far fa-calendar-alt me-1"></i> <?= !empty($receipt['paid_on']) ? date('d M Y', strtotime($receipt['paid_on'])) : date('d M Y') ?></div>
        </div>
    </div>

    <hr>

    <!-- ====== STUDENT INFO ====== -->
    <div class="row mb-3">
        <div class="col-md-6">
            <div class="info-label">Student</div>
            <div class="info-value"><?= htmlspecialchars($receipt['student_name'] ?? '—') ?></div>
            <div class="info-small">Admission No: <?= htmlspecialchars($receipt['admission_no'] ?? '—') ?></div>
        </div>
        <div class="col-md-3">
            <div class="info-label">Class</div>
            <div class="info-value"><?= htmlspecialchars($receipt['class_name'] ?? '—') ?></div>
        </div>
        <div class="col-md-3 text-end">
            <div class="info-label">Payment Method</div>
            <div class="info-value"><?= $payment_method ?></div>
            <div class="info-small">Status: <?= $receipt['payment_status'] ?? 'Paid' ?></div>
        </div>
    </div>

    <!-- ====== FEE TABLE ====== -->
    <table class="receipt-table">
        <thead>
            <tr>
                <th style="width:50px;">#</th>
                <th>Fee Type</th>
                <th class="text-right">Amount</th>
                <th class="text-right">Late Fee</th>
                <th class="text-right">Discount</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; foreach ($fee_items as $item): ?>
            <tr>
                <td class="text-center"><?= $i++ ?></td>
                <td><?= htmlspecialchars($item['fee_type'] ?? 'Fee') ?></td>
                <td class="text-right"><?= formatMoney($item['amount_paid'] ?? 0) ?></td>
                <td class="text-right"><?= formatMoney($item['late_fee'] ?? 0) ?></td>
                <td class="text-right">- <?= formatMoney($item['discount'] ?? 0) ?></td>
                <td class="text-right"><strong><?= formatMoney($item['total_amount'] ?? $item['amount_paid'] ?? 0) ?></strong></td>
            </tr>
            <?php endforeach; ?>
            
            <!-- Total Row -->
            <tr class="total-row">
                <td colspan="5" class="text-right"><strong>Total</strong></td>
                <td class="text-right total-amount"><strong><?= formatMoney($total_paid) ?></strong></td>
            </tr>
        </tbody>
    </table>

    <!-- ====== REMARKS ====== -->
    <?php if (!empty($receipt['remarks'])): ?>
    <div class="remarks-text">
        <strong>Remarks:</strong> <?= htmlspecialchars($receipt['remarks']) ?>
    </div>
    <?php endif; ?>

    <!-- ====== FOOTER ====== -->
    <div class="footer-text">
        <i class="fas fa-qrcode me-1"></i> This is a computer generated receipt. Does not require signature.
        <div style="margin-top:5px; font-size:11px; letter-spacing:2px; color:#2563eb; font-weight:600;">
            PARENT COPY
        </div>
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
    // Auto print if print mode is set
    (function(){
        var printMode = <?= $printMode ? 'true' : 'false' ?>;
        if (printMode) {
            setTimeout(function(){ 
                window.print(); 
            }, 500);
        }
    })();
</script>

</body>
</html>
<?php ob_end_flush(); ?>