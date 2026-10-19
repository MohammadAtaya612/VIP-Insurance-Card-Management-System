

<?php $__env->startSection('title', 'حملة رسائل جديدة'); ?>
<?php $__env->startSection('page-title', 'إنشاء حملة رسائل جماعية'); ?>

<?php $__env->startSection('content'); ?>
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="vip-panel p-4">
            <form method="POST" action="<?php echo e(route('messages.store')); ?>" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="mb-3">
                    <label class="form-label">عنوان الحملة <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control" value="<?php echo e(old('title')); ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">قناة الإرسال <span class="text-danger">*</span></label>
                    <select name="channel" class="form-select" required>
                        <option value="sms" <?php echo e(old('channel') === 'sms' ? 'selected' : ''); ?>>SMS</option>
                        <option value="whatsapp" <?php echo e(old('channel') === 'whatsapp' ? 'selected' : ''); ?>>WhatsApp</option>
                        <option value="both" <?php echo e(old('channel', 'both') === 'both' ? 'selected' : ''); ?>>SMS + WhatsApp</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">نص الرسالة <span class="text-danger">*</span></label>
                    <textarea name="message_body" class="form-control" rows="4" maxlength="1000" required><?php echo e(old('message_body')); ?></textarea>
                    <small class="text-muted">الحد الأقصى 1000 حرف</small>
                </div>

                <div class="mb-3">
                    <label class="form-label">مصدر المستلمين <span class="text-danger">*</span></label>
                    <select name="source_type" class="form-select" id="sourceType" required>
                        <option value="customers" <?php echo e(old('source_type', 'customers') === 'customers' ? 'selected' : ''); ?>>
                            عملاء النظام
                        </option>
                        <option value="excel" <?php echo e(old('source_type') === 'excel' ? 'selected' : ''); ?>>
                            استيراد من Excel
                        </option>
                    </select>
                </div>

                <div class="mb-3" id="excelField" style="display: none;">
                    <label class="form-label">ملف Excel</label>
                    <input type="file" name="excel_file" class="form-control" accept=".xlsx,.xls,.csv">
                    <small class="text-muted">
                        الأعمدة المطلوبة: <code>name</code> (الاسم) و <code>phone</code> (الهاتف).
                        يدعم حتى 40,000 سجل.
                    </small>
                </div>

                <div class="mb-4">
                    <label class="form-label">جدولة الإرسال (اختياري)</label>
                    <input type="datetime-local" name="scheduled_at" class="form-control" value="<?php echo e(old('scheduled_at')); ?>">
                    <small class="text-muted">اتركه فارغاً للإرسال الفوري</small>
                </div>

                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i>
                    يتم الإرسال عبر Queue لدعم الأعداد الكبيرة. تأكد من تشغيل <code>php artisan queue:work</code>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-vip-gold"><i class="bi bi-send"></i> إرسال</button>
                    <a href="<?php echo e(route('messages.index')); ?>" class="btn btn-outline-secondary">إلغاء</a>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    const sourceType = document.getElementById('sourceType');
    const excelField = document.getElementById('excelField');
    function toggleExcel() {
        excelField.style.display = sourceType.value === 'excel' ? 'block' : 'none';
    }
    sourceType.addEventListener('change', toggleExcel);
    toggleExcel();
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\mass\Desktop\vip-insurance-system\resources\views/messages/create.blade.php ENDPATH**/ ?>