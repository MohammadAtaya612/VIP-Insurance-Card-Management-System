

<?php $__env->startSection('title', 'لوحة التحكم'); ?>
<?php $__env->startSection('page-title', 'لوحة التحكم'); ?>
<?php $__env->startSection('page-subtitle', 'نظرة عامة على أداء النظام'); ?>

<?php $__env->startSection('content'); ?>
<div class="row g-4 mb-4">
    <div class="col-md-4 col-lg-2">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">العملاء</div>
                    <div class="stat-value"><?php echo e(number_format($stats['customers_count'])); ?></div>
                </div>
                <div class="stat-icon stat-icon-navy"><i class="bi bi-people"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-lg-2">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">بطاقات فعالة</div>
                    <div class="stat-value text-success"><?php echo e(number_format($stats['active_cards'])); ?></div>
                </div>
                <div class="stat-icon stat-icon-green"><i class="bi bi-check-circle"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-lg-2">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">بطاقات منتهية</div>
                    <div class="stat-value text-warning"><?php echo e(number_format($stats['expired_cards'])); ?></div>
                </div>
                <div class="stat-icon stat-icon-gold"><i class="bi bi-clock-history"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-lg-2">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">Silver</div>
                    <div class="stat-value"><?php echo e(number_format($stats['silver_cards'])); ?></div>
                </div>
                <div class="stat-icon stat-icon-blue"><i class="bi bi-award"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-lg-2">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">Gold</div>
                    <div class="stat-value" style="color: var(--vip-gold);"><?php echo e(number_format($stats['gold_cards'])); ?></div>
                </div>
                <div class="stat-icon stat-icon-gold"><i class="bi bi-gem"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-lg-2">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">الإيرادات</div>
                    <div class="stat-value"><?php echo e(number_format($stats['total_revenue'])); ?> ₪</div>
                </div>
                <div class="stat-icon stat-icon-gold"><i class="bi bi-currency-exchange"></i></div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="vip-panel">
            <div class="vip-panel-header">
                <h5><i class="bi bi-clock-history"></i> آخر البطاقات المصدرة</h5>
                <a href="<?php echo e(route('cards.create')); ?>" class="btn btn-vip-gold btn-sm">
                    <i class="bi bi-plus-lg"></i> إصدار بطاقة
                </a>
            </div>
            <div class="table-responsive">
                <table class="table table-vip table-hover mb-0">
                    <thead>
                        <tr>
                            <th>رقم العضوية</th>
                            <th>العميل</th>
                            <th>النوع</th>
                            <th>الحالة</th>
                            <th>التاريخ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $stats['recent_cards']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><a href="<?php echo e(route('cards.show', $card)); ?>"><?php echo e($card->membership_number); ?></a></td>
                            <td><?php echo e($card->customer->name); ?></td>
                            <td>
                                <span class="badge <?php echo e($card->card_type->value === 'gold' ? 'bg-warning text-dark' : 'bg-secondary'); ?>">
                                    <?php echo e($card->card_type->labelAr()); ?>

                                </span>
                            </td>
                            <td>
                                <span class="badge <?php echo e($card->effectiveStatus()->badgeClass()); ?>">
                                    <?php echo e($card->effectiveStatus()->label()); ?>

                                </span>
                            </td>
                            <td><?php echo e($card->issued_at->format('Y-m-d')); ?></td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr><td colspan="5" class="text-center text-muted py-4">لا توجد بطاقات بعد</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="vip-panel">
            <div class="vip-panel-header">
                <h5><i class="bi bi-lightning"></i> إجراءات سريعة</h5>
            </div>
            <div class="p-4 d-grid gap-2">
                <a href="<?php echo e(route('customers.create')); ?>" class="btn btn-outline-dark">
                    <i class="bi bi-person-plus"></i> إضافة عميل
                </a>
                <a href="<?php echo e(route('cards.create')); ?>" class="btn btn-vip-gold">
                    <i class="bi bi-credit-card"></i> إصدار بطاقة VIP
                </a>
                <a href="<?php echo e(route('messages.create')); ?>" class="btn btn-outline-primary">
                    <i class="bi bi-send"></i> رسالة جماعية
                </a>
            </div>
        </div>

        <div class="vip-panel mt-4">
            <div class="vip-panel-header">
                <h5><i class="bi bi-info-circle"></i> أنواع البطاقات</h5>
            </div>
            <div class="p-4">
                <?php $__currentLoopData = config('vip.card_types'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type => $info): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="mb-3 pb-3 border-bottom">
                    <strong class="<?php echo e($type === 'gold' ? 'text-warning' : 'text-secondary'); ?>">
                        <?php echo e($info['name_ar']); ?>

                    </strong>
                    <span class="float-start badge bg-dark"><?php echo e($info['price']); ?> ₪</span>
                    <ul class="small text-muted mt-2 mb-0 ps-3">
                        <?php $__currentLoopData = $info['benefits']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $benefit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($benefit); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\mass\Desktop\vip-insurance-system\resources\views/dashboard/index.blade.php ENDPATH**/ ?>