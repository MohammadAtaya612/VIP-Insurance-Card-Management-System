<!DOCTYPE html>
<html lang="ar">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
        font-family: 'Arial', 'DejaVu Sans', sans-serif;
        direction: rtl;
        width: 160mm;
    }

    .card {
        width: 160mm;
        height: 100mm;
        position: relative;
        border-radius: 10px;
        overflow: hidden;
        color: #ffffff;
    }

    .card.gold {
        background-color: #b8860b;
        border: 2px solid #d4af37;
    }

    .card.silver {
        background-color: #607080;
        border: 2px solid #a0aec0;
    }

    .card-overlay {
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
    }

.card.gold .card-overlay {
    background-color: #d4af37;
}

.card.silver .card-overlay {
    background-color: #7f8c9a;
}

    .card-content {
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        padding: 8mm 7mm;
    }

    .top-table {
        width: 100%;
        border-collapse: collapse;
    }

    .top-table td {
        vertical-align: top;
        padding: 0;
    }

    .td-info { text-align: right; }
    .td-qr   { text-align: left; width: 28mm; }

    .logo {
        font-size: 10pt;
        font-weight: bold;
        color: #ffffff;
    }

    .card-type {
        font-size: 20pt;
        font-weight: bold;
        color: #ffffff;
        margin-top: 2mm;
        letter-spacing: 1pt;
    }

    .divider {
        width: 55mm;
        height: 0.5mm;
        background-color: rgba(255,255,255,0.6);
        margin: 4mm 0 3mm auto;
    }

    .card-name {
        font-size: 13pt;
        font-weight: bold;
        color: #ffffff;
        text-align: right;
    }

    .card-number {
        font-size: 10pt;
        color: rgba(255,255,255,0.95);
        text-align: right;
        margin-top: 1.5mm;
        letter-spacing: 1pt;
    }

    .card-expiry {
        position: absolute;
        bottom: 7mm;
        right: 7mm;
        font-size: 9pt;
        color: rgba(255,255,255,0.9);
        text-align: right;
    }

    .qr-box {
        background: #ffffff;
        padding: 2mm;
        border-radius: 4px;
        display: inline-block;
    }

    .qr-box img {
        width: 24mm;
        height: 24mm;
        display: block;
    }
</style>
</head>
<body>
<div class="card <?php echo e($card->card_type->value); ?>">
    <div class="card-overlay"></div>
    <div class="card-content">

        <table class="top-table">
            <tr>
                <td class="td-info">
                    <div class="logo">&#10003; <?php echo e(config('vip.company_name', 'شركة التأمين VIP')); ?></div>
                    <div class="card-type"><?php echo e($card->card_type->label()); ?></div>
                </td>
                <td class="td-qr">
                    <div class="qr-box">
                        <img src="data:image/svg+xml;base64,<?php echo e(base64_encode($qrSvg)); ?>" alt="QR">
                    </div>
                </td>
            </tr>
        </table>

        <div class="divider"></div>

        <div class="card-name"><?php echo e($card->customer->name); ?></div>
        <div class="card-number"><?php echo e($card->membership_number); ?></div>

        <div class="card-expiry">صالحة حتى: <?php echo e($card->expires_at->format('d/m/Y')); ?></div>

    </div>
</div>
</body>
</html><?php /**PATH C:\Users\mass\Desktop\vip-insurance-system\resources\views/cards/pdf.blade.php ENDPATH**/ ?>