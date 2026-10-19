

<?php $__env->startSection('title', 'البطاقات'); ?>
<?php $__env->startSection('page-title', 'إدارة البطاقات'); ?>
<?php $__env->startSection('page-subtitle', 'إصدار وتجديد وإدارة بطاقات VIP'); ?>

<?php $__env->startSection('content'); ?>
<div class="vip-panel">
    <div class="vip-panel-header">
        <form class="search-box d-flex" method="GET">
            <input type="text" name="q" class="form-control" placeholder="بحث برقم العضوية أو اسم العميل..." value="<?php echo e(request('q')); ?>">
            <button class="btn btn-vip-primary" type="submit"><i class="bi bi-search"></i></button>
        </form>
        <a href="<?php echo e(route('cards.create')); ?>" class="btn btn-vip-gold">
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
                    <th>السعر</th>
                    <th>الحالة</th>
                    <th>تاريخ الانتهاء</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $cards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><strong><?php echo e($card->membership_number); ?></strong></td>
                    <td><?php echo e($card->customer->name); ?></td>
                    <td>
                        <span class="badge <?php echo e($card->card_type->value === 'gold' ? 'bg-warning text-dark' : 'bg-secondary'); ?>">
                            <?php echo e($card->card_type->labelAr()); ?>

                        </span>
                    </td>
                    <td><?php echo e(number_format($card->price)); ?> ₪</td>
                    <td>
                        <span class="badge <?php echo e($card->effectiveStatus()->badgeClass()); ?>">
                            <?php echo e($card->effectiveStatus()->label()); ?>

                        </span>
                    </td>
                    <td><?php echo e($card->expires_at->format('Y-m-d')); ?></td>
                    <td>
                        <a href="<?php echo e(route('cards.show', $card)); ?>" class="btn btn-sm btn-vip-primary">
                            <i class="bi bi-eye"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="7" class="text-center text-muted py-4">لا توجد بطاقات</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if($cards->hasPages()): ?>
    <div class="p-3"><?php echo e($cards->links()); ?></div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\mass\Desktop\vip-insurance-system\resources\views/cards/index.blade.php ENDPATH**/ ?>