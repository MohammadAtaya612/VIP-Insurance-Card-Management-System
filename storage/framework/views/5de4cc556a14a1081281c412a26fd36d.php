<div class="mb-3">
    <label class="form-label">الاسم</label>
    <input type="text" name="name" class="form-control" value="<?php echo e(old('name', $user->name ?? '')); ?>" required>
</div>
<div class="mb-3">
    <label class="form-label">البريد الإلكتروني</label>
    <input type="email" name="email" class="form-control" value="<?php echo e(old('email', $user->email ?? '')); ?>" required>
</div>
<div class="mb-3">
    <label class="form-label">كلمة المرور <?php echo e(isset($user) ? '(اتركها فارغة للإبقاء)' : ''); ?></label>
    <input type="password" name="password" class="form-control" <?php echo e(isset($user) ? '' : 'required'); ?>>
</div>
<div class="mb-3">
    <label class="form-label">الصلاحية</label>
    <select name="role" class="form-select" required>
        <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($role->value); ?>" <?php echo e(old('role', isset($user) ? $user->role->value : 'employee') === $role->value ? 'selected' : ''); ?>>
                <?php echo e($role->label()); ?>

            </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
</div>
<?php if(isset($user)): ?>
<div class="form-check mb-3">
    <input type="checkbox" name="is_active" value="1" class="form-check-input" id="is_active"
           <?php echo e(old('is_active', $user->is_active) ? 'checked' : ''); ?>>
    <label class="form-check-label" for="is_active">حساب نشط</label>
</div>
<?php endif; ?>
<?php /**PATH C:\Users\mass\Desktop\vip-insurance-system\resources\views/users/_form.blade.php ENDPATH**/ ?>