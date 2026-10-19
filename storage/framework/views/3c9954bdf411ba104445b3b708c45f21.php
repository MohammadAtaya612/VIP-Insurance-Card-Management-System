

<?php $__env->startSection('title', 'إضافة عميل'); ?>
<?php $__env->startSection('page-title', 'إضافة عميل جديد'); ?>

<?php $__env->startSection('content'); ?>
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="vip-panel p-4">
            <form method="POST" action="<?php echo e(route('customers.store')); ?>">
                <?php echo csrf_field(); ?>
                <?php echo $__env->make('customers._form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-vip-gold"><i class="bi bi-check-lg"></i> حفظ</button>
                    <a href="<?php echo e(route('customers.index')); ?>" class="btn btn-outline-secondary">إلغاء</a>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\mass\Desktop\vip-insurance-system\resources\views/customers/create.blade.php ENDPATH**/ ?>