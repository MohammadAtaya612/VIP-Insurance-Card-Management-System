<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">اسم العميل <span class="text-danger">*</span></label>
        <input type="text" name="name" class="form-control" value="<?php echo e(old('name', $customer->name ?? '')); ?>" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">رقم الهاتف <span class="text-danger">*</span></label>
        <input type="text" name="phone" class="form-control" dir="ltr" value="<?php echo e(old('phone', $customer->phone ?? '')); ?>" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">البريد الإلكتروني</label>
        <input type="email" name="email" class="form-control" value="<?php echo e(old('email', $customer->email ?? '')); ?>">
    </div>
    <div class="col-md-6">
        <label class="form-label">رقم الهوية</label>
        <input type="text" name="national_id" class="form-control" value="<?php echo e(old('national_id', $customer->national_id ?? '')); ?>">
    </div>
    <div class="col-12">
        <label class="form-label">العنوان</label>
        <textarea name="address" class="form-control" rows="2"><?php echo e(old('address', $customer->address ?? '')); ?></textarea>
    </div>
    <div class="col-12">
        <label class="form-label">ملاحظات</label>
        <textarea name="notes" class="form-control" rows="2"><?php echo e(old('notes', $customer->notes ?? '')); ?></textarea>
    </div>
</div>
<?php /**PATH C:\Users\mass\Desktop\vip-insurance-system\resources\views/customers/_form.blade.php ENDPATH**/ ?>