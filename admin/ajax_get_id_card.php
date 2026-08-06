<?php
include '../config/config.php';

$student_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$side = isset($_GET['side']) ? $_GET['side'] : 'front';

if ($student_id > 0) {
    try {
        $stmt = $conn->prepare("SELECT s.*, c.class_name, sec.section_name 
                                FROM students s 
                                LEFT JOIN classes c ON s.class_id = c.id 
                                LEFT JOIN sections sec ON s.section_id = sec.id 
                                WHERE s.id = ?");
        $stmt->execute([$student_id]);
        $student = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($student) {
            $school_logo = "../images/logo.png";
            $photo = !empty($student['photo']) ? '../uploads/students/' . $student['photo'] : '';
            $default_photo = 'https://ui-avatars.com/api/?name=' . urlencode($student['name']) . '&background=2563eb&color=fff&size=120';
            
            if ($side == 'back') {
                // ====== BACK SIDE OF ID CARD ======
                ?>
                <!DOCTYPE html>
                <html>
                <head>
                    <style>
                        * { margin: 0; padding: 0; box-sizing: border-box; }
                        
                        .id-card-back {
                            background: white;
                            border-radius: 14px;
                            padding: 0;
                            max-width: 380px;
                            margin: 0 auto;
                            position: relative;
                            overflow: hidden;
                            border: 1px solid #e5e7eb;
                            font-family: 'Segoe UI', Arial, sans-serif;
                            min-height: 480px;
                        }
                        
                        .id-card-back .top-line {
                            height: 4px;
                            background: linear-gradient(90deg, #1a56db, #7c3aed, #1a56db);
                            margin-bottom: 0;
                        }
                        
                        .id-card-back .header {
                            text-align: center;
                            border-bottom: 2px solid #2563eb;
                            padding: 10px 20px 8px 20px;
                            margin-bottom: 10px;
                        }
                        
                        .id-card-back .logo {
                            width: 50px;
                            height: 50px;
                            border-radius: 50%;
                            object-fit: cover;
                            border: 3px solid #2563eb;
                            padding: 2px;
                            margin-bottom: 2px;
                        }
                        
                        .id-card-back .school-name {
                            font-size: 16px;
                            font-weight: 800;
                            color: #1a1a2e;
                            letter-spacing: 1px;
                        }
                        
                        .id-card-back .tagline {
                            font-size: 8px;
                            color: #6b7280;
                            letter-spacing: 1px;
                            font-weight: 500;
                            margin-top: -2px;
                        }
                        
                        .id-card-back .card-title {
                            background: linear-gradient(135deg, #2563eb, #7c3aed);
                            color: white;
                            padding: 3px 18px;
                            border-radius: 20px;
                            font-size: 11px;
                            font-weight: 700;
                            display: inline-block;
                            letter-spacing: 2px;
                            margin: 4px 0 2px 0;
                        }
                        
                        .id-card-back .back-content {
                            padding: 10px 20px 15px 20px;
                        }
                        
                        .id-card-back .terms-title {
                            font-size: 11px;
                            font-weight: 700;
                            color: #1a1a2e;
                            margin-bottom: 5px;
                            letter-spacing: 0.5px;
                        }
                        
                        .id-card-back .terms-text {
                            font-size: 9.5px;
                            color: #4b5563;
                            line-height: 1.6;
                            margin-bottom: 10px;
                            text-align: justify;
                        }
                        
                        .id-card-back .contact-info {
                            font-size: 9.5px;
                            color: #4b5563;
                            line-height: 1.8;
                            margin-bottom: 10px;
                        }
                        
                        .id-card-back .contact-info i {
                            width: 18px;
                            color: #2563eb;
                        }
                        
                        .id-card-back .signature-section {
                            display: flex;
                            justify-content: space-between;
                            align-items: center;
                            margin-top: 10px;
                            padding-top: 10px;
                            border-top: 1px dashed #e5e7eb;
                        }
                        
                        .id-card-back .signature-box {
                            text-align: center;
                            flex: 1;
                        }
                        
                        .id-card-back .signature-box .label {
                            font-size: 9px;
                            color: #6b7280;
                            font-weight: 600;
                        }
                        
                        .id-card-back .signature-box .line {
                            width: 80px;
                            border-top: 2px solid #1a1a2e;
                            margin: 5px auto 2px auto;
                        }
                        
                        .id-card-back .signature-box .name {
                            font-size: 9px;
                            color: #1a1a2e;
                            font-weight: 600;
                        }
                        
                        .id-card-back .signature-box .date {
                            font-size: 8px;
                            color: #6b7280;
                        }
                        
                        .id-card-back .footer-info {
                            display: flex;
                            justify-content: space-between;
                            margin-top: 10px;
                            padding-top: 8px;
                            border-top: 1px solid #e5e7eb;
                            font-size: 7.5px;
                            color: #9ca3af;
                        }
                        
                        .id-card-back .footer-info span {
                            display: inline-block;
                        }
                        
                        @media print {
                            .id-card-back {
                                border: none;
                                border-radius: 0;
                                max-width: 100%;
                                margin: 0;
                                box-shadow: none;
                                min-height: 100vh;
                            }
                        }
                    </style>
                </head>
                <body>
                    <div class="id-card-back">
                        <div class="top-line"></div>
                        
                        <div class="header">
                            <img src="<?= $school_logo ?>" alt="School Logo" class="logo" 
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='block'">
                            <div style="display:none; font-size:24px;">🏫</div>
                            <div class="school-name">KARTIKEY SCHOOL</div>
                            <div class="tagline">Promised To Ensure Quality Education.</div>
                            <div class="card-title">ID CARD</div>
                        </div>
                        
                        <div class="back-content">
                            <div class="terms-title">📋 TERMS AND CONDITIONS</div>
                            <div class="terms-text">
                                This identity card is the property of Kartikey School and must be returned upon request. 
                                The cardholder is responsible for the safe keeping of this card. In case of loss, 
                                please report immediately to the school administration. This card is non-transferable 
                                and must be presented upon request by school authorities.
                            </div>
                            
                            <div class="contact-info">
                                <div><i class="fas fa-phone"></i> +91 9664153249</div>
                                <div><i class="fas fa-envelope"></i> kartikeylodha567@gmail.com</div>
                                <div><i class="fas fa-globe"></i> www.kartikeyschool.com</div>
                            </div>
                            
                            <div class="signature-section">
                                <div class="signature-box">
                                    <div class="label">Principal</div>
                                    <div class="line"></div>
                                    <div class="name">Kartikey Lodha</div>
                                    <div class="date"><?= date('d/m/Y') ?></div>
                                </div>
                                <div class="signature-box">
                                    <div class="label">Valid Till</div>
                                    <div class="line"></div>
                                    <div class="name"><?= date('M Y', strtotime('+1 year')) ?></div>
                                    <div class="date">Academic Year <?= date('Y') . '-' . (date('Y') + 1) ?></div>
                                </div>
                            </div>
                            
                            <div class="footer-info">
                                <span>REGULAR COLOR</span>
                                <span>FREE FOR USE</span>
                                <span>300 DPI</span>
                            </div>
                            <div class="footer-info" style="margin-top:2px; padding-top:2px; border-top:none;">
                                <span>2.13" X 3.39" INCH</span>
                                <span>RGB COLOR</span>
                            </div>
                        </div>
                    </div>
                </body>
                </html>
                <?php
            } else {
                // ====== FRONT SIDE OF ID CARD ======
                ?>
                <!DOCTYPE html>
                <html>
                <head>
                    <style>
                        * { margin: 0; padding: 0; box-sizing: border-box; }
                        
                        .id-card-front {
                            background: white;
                            border-radius: 14px;
                            padding: 0;
                            max-width: 380px;
                            margin: 0 auto;
                            position: relative;
                            overflow: hidden;
                            border: 1px solid #e5e7eb;
                            font-family: 'Segoe UI', Arial, sans-serif;
                        }
                        
                        .id-card-front .top-line {
                            height: 4px;
                            background: linear-gradient(90deg, #1a56db, #7c3aed, #1a56db);
                            margin-bottom: 0;
                        }
                        
                        .id-card-front .header {
                            text-align: center;
                            border-bottom: 2px solid #2563eb;
                            padding: 10px 20px 8px 20px;
                            margin-bottom: 8px;
                        }
                        
                        .id-card-front .logo {
                            width: 55px;
                            height: 55px;
                            border-radius: 50%;
                            object-fit: cover;
                            border: 3px solid #2563eb;
                            padding: 2px;
                            margin-bottom: 2px;
                        }
                        
                        .id-card-front .school-name {
                            font-size: 17px;
                            font-weight: 800;
                            color: #1a1a2e;
                            letter-spacing: 1px;
                        }
                        
                        .id-card-front .tagline {
                            font-size: 8px;
                            color: #6b7280;
                            letter-spacing: 1px;
                            font-weight: 500;
                            margin-top: -2px;
                        }
                        
                        .id-card-front .card-title {
                            background: linear-gradient(135deg, #2563eb, #7c3aed);
                            color: white;
                            padding: 3px 18px;
                            border-radius: 20px;
                            font-size: 12px;
                            font-weight: 700;
                            display: inline-block;
                            letter-spacing: 2px;
                            margin: 4px 0 2px 0;
                        }
                        
                        .id-card-front .photo {
                            width: 95px;
                            height: 95px;
                            border-radius: 50%;
                            border: 4px solid #2563eb;
                            object-fit: cover;
                            margin: 0 auto 8px auto;
                            display: block;
                            box-shadow: 0 4px 15px rgba(37,99,235,0.2);
                        }
                        
                        .id-card-front .info-row {
                            display: flex;
                            padding: 3px 20px;
                            font-size: 12.5px;
                            align-items: baseline;
                            line-height: 1.5;
                        }
                        
                        .id-card-front .info-label {
                            font-weight: 600;
                            color: #4b5563;
                            width: 108px;
                            flex-shrink: 0;
                            font-size: 12px;
                        }
                        
                        .id-card-front .info-value {
                            font-weight: 600;
                            color: #1a1a2e;
                            flex: 1;
                            font-size: 12.5px;
                            padding-left: 2px;
                        }
                        
                        .id-card-front .footer {
                            margin-top: 8px;
                            padding: 8px 20px 12px 20px;
                            border-top: 2px solid #2563eb;
                            text-align: center;
                        }
                        
                        .id-card-front .principal {
                            font-size: 10.5px;
                            color: #6b7280;
                        }
                        
                        .id-card-front .sign-line {
                            display: inline-block;
                            width: 110px;
                            border-top: 2px solid #1a1a2e;
                            margin-top: 3px;
                        }
                        
                        .id-card-front .valid-till {
                            font-size: 9.5px;
                            color: #6b7280;
                            margin-top: 4px;
                        }
                        
                        .id-card-front .side-label {
                            position: absolute;
                            bottom: 10px;
                            right: 15px;
                            font-size: 8px;
                            color: #d1d5db;
                            letter-spacing: 1px;
                            opacity: 0.5;
                        }
                        
                        @media print {
                            .id-card-front {
                                border: none;
                                border-radius: 0;
                                max-width: 100%;
                                margin: 0;
                                box-shadow: none;
                            }
                        }
                    </style>
                </head>
                <body>
                    <div class="id-card-front">
                        <div class="top-line"></div>
                        <div class="side-label">FRONT</div>
                        
                        <div class="header">
                            <img src="<?= $school_logo ?>" alt="School Logo" class="logo" 
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='block'">
                            <div style="display:none; font-size:28px;">🏫</div>
                            <div class="school-name">KARTIKEY SCHOOL</div>
                            <div class="tagline">Promised To Ensure Quality Education.</div>
                            <div class="card-title">ID CARD</div>
                        </div>
                        
                        <img src="<?= $photo ? $photo : $default_photo ?>" 
                             alt="<?= htmlspecialchars($student['name']) ?>" 
                             class="photo"
                             onerror="this.src='<?= $default_photo ?>'">
                        
                        <div class="info-row">
                            <span class="info-label">Name</span>
                            <span class="info-value">: <?= htmlspecialchars($student['name']) ?></span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Class</span>
                            <span class="info-value">: <?= htmlspecialchars($student['class_name'] ?? 'N/A') ?></span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Section</span>
                            <span class="info-value">: <?= htmlspecialchars($student['section_name'] ?? 'N/A') ?></span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Admission No</span>
                            <span class="info-value">: <?= htmlspecialchars($student['admission_no']) ?></span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Date of Birth</span>
                            <span class="info-value">: <?= !empty($student['dob']) ? date('d-m-Y', strtotime($student['dob'])) : 'N/A' ?></span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Blood Group</span>
                            <span class="info-value">: <?= htmlspecialchars($student['blood_group'] ?? 'N/A') ?></span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Mobile</span>
                            <span class="info-value">: <?= htmlspecialchars($student['parent_phone'] ?? $student['phone'] ?? 'N/A') ?></span>
                        </div>
                        <?php if (!empty($student['parent_email'])): ?>
                        <div class="info-row">
                            <span class="info-label">Email</span>
                            <span class="info-value">: <?= htmlspecialchars($student['parent_email']) ?></span>
                        </div>
                        <?php endif; ?>
                        <div class="info-row">
                            <span class="info-label">Session</span>
                            <span class="info-value">: <?= date('Y') . '-' . (date('Y') + 1) ?></span>
                        </div>
                        
                        <div class="footer">
                            <div class="principal">
                                <div>Principal</div>
                                <div class="sign-line"></div>
                            </div>
                            <div class="valid-till">
                                <i class="fas fa-qrcode me-1"></i> Valid till: <?= date('M Y', strtotime('+1 year')) ?>
                            </div>
                        </div>
                    </div>
                </body>
                </html>
                <?php
            }
        } else {
            echo '<div class="text-center py-4 text-danger">Student not found.</div>';
        }
    } catch (Exception $e) {
        echo '<div class="text-center py-4 text-danger">Error: ' . $e->getMessage() . '</div>';
    }
} else {
    echo '<div class="text-center py-4 text-danger">Invalid student ID.</div>';
}
?>