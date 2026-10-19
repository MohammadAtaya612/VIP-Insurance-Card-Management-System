

<?php $__env->startSection('title', 'تعديل مستخدم'); ?>
<?php $__env->startSection('page-title'); ?>
تعديل: <?php echo e($user->name); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="vip-panel p-4">
            <form method="POST" action="<?php echo e(route('users.update', $user)); ?>">
                <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                <?php echo $__env->make('users._form', ['user' => $user], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-vip-gold">تحديث</button>
                    <a href="<?php echo e(route('users.index')); ?>" class="btn btn-outline-secondary">إلغاء</a>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\mass\Desktop\vip-insurance-system\resources\views/users/edit.blade.php ENDPATH**/ ?>