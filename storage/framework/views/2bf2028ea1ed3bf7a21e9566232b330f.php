

<?php $__env->startSection('title', 'عرض البطاقة'); ?>
<?php $__env->startSection('page-title'); ?>
بطاقة VIP — <?php echo e($card->membership_number); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row g-4">
    <div class="col-lg-5">
        <div class="vip-panel p-4 text-center">
          <div class="vip-card-visual <?php echo e($card->card_type->value); ?> mx-auto mb-3">
    <div class="card-logo">
        <i class="bi bi-shield-check"></i> <?php echo e(config('vip.company_name')); ?>

    </div>
    <div class="card-type"><?php echo e($card->card_type->label()); ?></div>
    <div class="card-member">
        <div><?php echo e($card->customer->name); ?></div>
        <div class="card-number"><?php echo e($card->membership_number); ?></div>
    </div>
    <div class="card-expiry">صالحة حتى: <?php echo e($card->expires_at->format('d/m/Y')); ?></div>
    <div class="card-qr"><?php echo $qrSvg; ?></div>
</div>

            <span class="badge <?php echo e($card->effectiveStatus()->badgeClass()); ?> fs-6">
                <?php echo e($card->effectiveStatus()->label()); ?>

            </span>
        </div>
    </div>

    <div class="col-lg-7">
        <div class="vip-panel p-4">
            <h5 class="mb-4">تفاصيل البطاقة</h5>
            <table class="table">
                <tr><th width="35%">العميل</th><td><?php echo e($card->customer->name); ?></td></tr>
                <tr><th>الهاتف</th><td dir="ltr"><?php echo e($card->customer->phone); ?></td></tr>
                <tr><th>نوع البطاقة</th><td><?php echo e($card->card_type->labelAr()); ?></td></tr>
                <tr><th>السعر</th><td><?php echo e(number_format($card->price)); ?> ₪</td></tr>
                <tr><th>تاريخ الإصدار</th><td><?php echo e($card->issued_at->format('Y-m-d H:i')); ?></td></tr>
                <tr><th>تاريخ الانتهاء</th><td><?php echo e($card->expires_at->format('Y-m-d')); ?></td></tr>
                <tr><th>أصدرها</th><td><?php echo e($card->issuer->name); ?></td></tr>
                <tr><th>رابط QR</th><td><a href="<?php echo e($card->qrUrl()); ?>" target="_blank"><?php echo e($card->qrUrl()); ?></a></td></tr>
            </table>

            <h6 class="mt-4">المزايا</h6>
            <ul>
                <?php $__currentLoopData = $card->benefits(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $benefit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($benefit); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>

            <div class="d-flex flex-wrap gap-2 mt-4">
                <a href="<?php echo e(route('cards.pdf', $card)); ?>" class="btn btn-vip-primary">
                    <i class="bi bi-file-pdf"></i> تحميل PDF
                </a>
                <form action="<?php echo e(route('cards.whatsapp', $card)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <button class="btn btn-success"><i class="bi bi-whatsapp"></i> إرسال WhatsApp</button>
                </form>
                <?php if($card->effectiveStatus()->value !== 'cancelled'): ?>
                <form action="<?php echo e(route('cards.renew', $card)); ?>" method="POST"
                      onsubmit="return confirm('تجديد البطاقة لمدة سنة إضافية؟')">
                    <?php echo csrf_field(); ?>
                    <button class="btn btn-warning"><i class="bi bi-arrow-repeat"></i> تجديد</button>
                </form>
                <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#cancelModal">
                    <i class="bi bi-x-circle"></i> إلغاء
                </button>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="cancelModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="<?php echo e(route('cards.cancel', $card)); ?>" method="POST" class="modal-content">
            <?php echo csrf_field(); ?>
            <div class="modal-header">
                <h5 class="modal-title">إلغاء البطاقة</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <label class="form-label">سبب الإلغاء (اختياري)</label>
                <textarea name="cancelled_reason" class="form-control" rows="3"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">تراجع</button>
                <button type="submit" class="btn btn-danger">تأكيد الإلغاء</button>
            </div>
        </form>
    </div>
</div>


<div class="card mt-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="bi bi-clock-history"></i> سجل الاستخدام</h5>
        <button class="btn btn-sm btn-warning" data-bs-toggle="collapse" data-bs-target="#addUsageForm">
            <i class="bi bi-plus-lg"></i> تسجيل استخدام
        </button>
    </div>

    
    <div class="collapse" id="addUsageForm">
        <div class="card-body border-bottom bg-light">
            <form method="POST" action="<?php echo e(route('cards.usages.store', $card)); ?>">
                <?php echo csrf_field(); ?>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">نوع الخدمة</label>
                        <select name="service_type" class="form-select" required>
                            <option value="">-- اختر الخدمة --</option>
                            <?php $__currentLoopData = \App\Http\Controllers\CardUsageController::$services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($label); ?>"><?php echo e($label); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">التكلفة (₪)</label>
                        <input type="number" name="cost" class="form-control" min="0" step="0.01" value="0" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">التاريخ</label>
                        <input type="date" name="used_at" class="form-control" value="<?php echo e(date('Y-m-d')); ?>">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-success w-100">
                            <i class="bi bi-check-lg"></i> حفظ
                        </button>
                    </div>
                    <div class="col-12">
                        <label class="form-label">ملاحظات</label>
                        <textarea name="notes" class="form-control" rows="2" placeholder="أي تفاصيل إضافية..."></textarea>
                    </div>
                </div>
            </form>
        </div>
    </div>

    
    <div class="card-body p-0">
        <?php if($card->usages->isEmpty()): ?>
            <div class="text-center text-muted py-4">
                <i class="bi bi-inbox" style="font-size:2rem;"></i>
                <p class="mt-2">لا توجد استخدامات مسجلة بعد</p>
            </div>
        <?php else: ?>
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>الخدمة</th>
                        <th>التكلفة</th>
                        <th>التاريخ</th>
                        <th>سجّل بواسطة</th>
                        <th>ملاحظات</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $card->usages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $usage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><span class="badge bg-warning text-dark"><?php echo e($usage->service_type); ?></span></td>
                        <td>₪ <?php echo e(number_format($usage->cost, 2)); ?></td>
                        <td><?php echo e($usage->used_at->format('d/m/Y')); ?></td>
                        <td><?php echo e($usage->recorder?->name ?? 'العميل'); ?></td>
                        <td class="text-muted small"><?php echo e($usage->notes ?? '—'); ?></td>
                        <td>
                            <?php if(auth()->guard()->check()): ?>
                            <form method="POST" action="<?php echo e(route('cards.usages.destroy', [$card, $usage])); ?>" onsubmit="return confirm('حذف هذا السجل؟')">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
                <tfoot class="table-light">
                    <tr>
                        <th>الإجمالي</th>
                        <th>₪ <?php echo e(number_format($card->usages->sum('cost'), 2)); ?></th>
                        <th colspan="4"></th>
                    </tr>
                </tfoot>
            </table>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\mass\Desktop\vip-insurance-system\resources\views/cards/show.blade.php ENDPATH**/ ?>