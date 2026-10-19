

<?php $__env->startSection('title', 'المستخدمين'); ?>
<?php $__env->startSection('page-title', 'إدارة المستخدمين'); ?>
<?php $__env->startSection('page-subtitle', 'Admin فقط'); ?>

<?php $__env->startSection('content'); ?>
<div class="vip-panel">
    <div class="vip-panel-header">
        <h5 class="mb-0">قائمة المستخدمين</h5>
        <a href="<?php echo e(route('users.create')); ?>" class="btn btn-vip-gold">
            <i class="bi bi-person-plus"></i> مستخدم جديد
        </a>
    </div>
    <div class="table-responsive">
        <table class="table table-vip table-hover mb-0">
            <thead>
                <tr>
                    <th>الاسم</th>
                    <th>البريد</th>
                    <th>الصلاحية</th>
                    <th>الحالة</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($user->name); ?></td>
                    <td><?php echo e($user->email); ?></td>
                    <td>
                        <span class="badge <?php echo e($user->isAdmin() ? 'bg-warning text-dark' : 'bg-info'); ?>">
                            <?php echo e($user->role->label()); ?>

                        </span>
                    </td>
                    <td>
                        <span class="badge <?php echo e($user->is_active ? 'bg-success' : 'bg-danger'); ?>">
                            <?php echo e($user->is_active ? 'نشط' : 'معطل'); ?>

                        </span>
                    </td>
                    <td>
                        <a href="<?php echo e(route('users.edit', $user)); ?>" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <?php if($user->id !== auth()->id()): ?>
                        <form action="<?php echo e(route('users.destroy', $user)); ?>" method="POST" class="d-inline"
                              onsubmit="return confirm('حذف المستخدم؟')">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
    <?php if($users->hasPages()): ?>
    <div class="p-3"><?php echo e($users->links()); ?></div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\mass\Desktop\vip-insurance-system\resources\views/users/index.blade.php ENDPATH**/ ?>