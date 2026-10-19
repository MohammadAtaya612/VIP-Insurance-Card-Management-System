

<?php $__env->startSection('title', 'الرسائل الجماعية'); ?>
<?php $__env->startSection('page-title', 'الرسائل الجماعية'); ?>
<?php $__env->startSection('page-subtitle', 'إرسال SMS و WhatsApp جماعي'); ?>

<?php $__env->startSection('content'); ?>
<div class="vip-panel">
    <div class="vip-panel-header">
        <h5 class="mb-0">سجل الحملات</h5>
        <a href="<?php echo e(route('messages.create')); ?>" class="btn btn-vip-gold">
            <i class="bi bi-send"></i> حملة جديدة
        </a>
    </div>
    <div class="table-responsive">
        <table class="table table-vip table-hover mb-0">
            <thead>
                <tr>
                    <th>العنوان</th>
                    <th>القناة</th>
                    <th>الحالة</th>
                    <th>المستلمين</th>
                    <th>مرسلة / فاشلة</th>
                    <th>التاريخ</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $campaigns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $campaign): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><strong><?php echo e($campaign->title); ?></strong></td>
                    <td><?php echo e($campaign->channel->label()); ?></td>
                    <td><span class="badge <?php echo e($campaign->status->badgeClass()); ?>"><?php echo e($campaign->status->label()); ?></span></td>
                    <td><?php echo e(number_format($campaign->total_recipients)); ?></td>
                    <td>
                        <span class="text-success"><?php echo e($campaign->sent_count); ?></span> /
                        <span class="text-danger"><?php echo e($campaign->failed_count); ?></span>
                    </td>
                    <td><?php echo e($campaign->created_at->format('Y-m-d H:i')); ?></td>
                    <td>
                        <a href="<?php echo e(route('messages.show', $campaign)); ?>" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-eye"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="7" class="text-center text-muted py-4">لا توجد حملات</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if($campaigns->hasPages()): ?>
    <div class="p-3"><?php echo e($campaigns->links()); ?></div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\mass\Desktop\vip-insurance-system\resources\views/messages/index.blade.php ENDPATH**/ ?>