

<?php $__env->startSection('title', 'العملاء'); ?>
<?php $__env->startSection('page-title', 'إدارة العملاء'); ?>
<?php $__env->startSection('page-subtitle', 'عرض وإدارة بيانات العملاء'); ?>

<?php $__env->startSection('content'); ?>
<div class="vip-panel">
    <div class="vip-panel-header">
        <form class="search-box d-flex" method="GET">
            <input type="text" name="q" class="form-control" placeholder="بحث بالاسم، الهاتف، البريد..." value="<?php echo e(request('q')); ?>">
            <button class="btn btn-vip-primary" type="submit"><i class="bi bi-search"></i></button>
        </form>
        <a href="<?php echo e(route('customers.create')); ?>" class="btn btn-vip-gold">
            <i class="bi bi-person-plus"></i> إضافة عميل
        </a>
    </div>
    <div class="table-responsive">
        <table class="table table-vip table-hover mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>الاسم</th>
                    <th>الهاتف</th>
                    <th>البريد</th>
                    <th>البطاقات</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($customer->id); ?></td>
                    <td><strong><?php echo e($customer->name); ?></strong></td>
                    <td dir="ltr" class="text-end"><?php echo e($customer->phone); ?></td>
                    <td><?php echo e($customer->email ?? '—'); ?></td>
                    <td><span class="badge bg-info"><?php echo e($customer->cards_count); ?></span></td>
                    <td>
                        <a href="<?php echo e(route('customers.edit', $customer)); ?>" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="<?php echo e(route('customers.destroy', $customer)); ?>" method="POST" class="d-inline"
                              onsubmit="return confirm('هل أنت متأكد من حذف هذا العميل؟')">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="6" class="text-center text-muted py-4">لا يوجد عملاء</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if($customers->hasPages()): ?>
    <div class="p-3"><?php echo e($customers->links()); ?></div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\mass\Desktop\vip-insurance-system\resources\views/customers/index.blade.php ENDPATH**/ ?>