

<?php $__env->startSection('title', 'إصدار بطاقة'); ?>
<?php $__env->startSection('page-title', 'إصدار بطاقة VIP جديدة'); ?>

<?php $__env->startSection('content'); ?>
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="vip-panel p-4">
            <form method="POST" action="<?php echo e(route('cards.store')); ?>">
                <?php echo csrf_field(); ?>
                <div class="mb-4">
                    <label class="form-label">العميل <span class="text-danger">*</span></label>
                    <select name="customer_id" class="form-select" required>
                        <option value="">— اختر العميل —</option>
                        <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($customer->id); ?>" <?php echo e(old('customer_id') == $customer->id ? 'selected' : ''); ?>>
                                <?php echo e($customer->name); ?> — <?php echo e($customer->phone); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <small class="text-muted">لا يوجد العميل؟ <a href="<?php echo e(route('customers.create')); ?>">أضف عميلاً جديداً</a></small>
                </div>

                <label class="form-label mb-3">نوع البطاقة <span class="text-danger">*</span></label>
                <div class="row g-3">
                    <?php $__currentLoopData = $cardTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-6">
                        <div class="card h-100 <?php echo e(old('card_type', 'silver') === $type->value ? 'border-warning' : ''); ?>">
                            <div class="card-body">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="card_type"
                                           id="type_<?php echo e($type->value); ?>" value="<?php echo e($type->value); ?>"
                                           <?php echo e(old('card_type', 'silver') === $type->value ? 'checked' : ''); ?>>
                                    <label class="form-check-label w-100" for="type_<?php echo e($type->value); ?>">
                                        <strong class="<?php echo e($type->value === 'gold' ? 'text-warning' : ''); ?>">
                                            <?php echo e($type->labelAr()); ?>

                                        </strong>
                                        <span class="badge bg-dark float-start"><?php echo e($type->price()); ?> ₪</span>
                                        <ul class="small text-muted mt-2 mb-0 ps-3">
                                            <?php $__currentLoopData = $type->benefits(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $benefit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li><?php echo e($benefit); ?></li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-vip-gold"><i class="bi bi-credit-card"></i> إصدار البطاقة</button>
                    <a href="<?php echo e(route('cards.index')); ?>" class="btn btn-outline-secondary">إلغاء</a>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\mass\Desktop\vip-insurance-system\resources\views/cards/create.blade.php ENDPATH**/ ?>