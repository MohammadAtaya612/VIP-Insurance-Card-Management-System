<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'لوحة التحكم'); ?> — <?php echo e(config('vip.company_name')); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="<?php echo e(asset('css/app.css')); ?>" rel="stylesheet">
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>
    <nav class="vip-sidebar">
        <div class="brand">
            <h4><i class="bi bi-shield-check"></i> شركة البديل</h4>
            <small style="font-size:0.65rem; opacity:0.8;">للخدمات العامة واللوجستية</small>
            <p style="color:#fff; opacity:1;" class="mb-2">نظام إدارة بطاقات العضوية</p>
            
        </div>
        <ul class="nav flex-column mt-3">
            <li class="nav-item">
                <a class="nav-link <?php echo e(request()->routeIs('dashboard') ? 'active' : ''); ?>" href="<?php echo e(route('dashboard')); ?>">
                    <i class="bi bi-speedometer2"></i> لوحة التحكم
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(request()->routeIs('customers.*') ? 'active' : ''); ?>" href="<?php echo e(route('customers.index')); ?>">
                    <i class="bi bi-people"></i> العملاء
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(request()->routeIs('cards.*') ? 'active' : ''); ?>" href="<?php echo e(route('cards.index')); ?>">
                    <i class="bi bi-credit-card-2-front"></i> البطاقات
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(request()->routeIs('messages.*') ? 'active' : ''); ?>" href="<?php echo e(route('messages.index')); ?>">
                    <i class="bi bi-chat-dots"></i> الرسائل الجماعية
                </a>
            </li>
            <?php if(auth()->user()->isAdmin()): ?>
            <li class="nav-item">
                <a class="nav-link <?php echo e(request()->routeIs('users.*') ? 'active' : ''); ?>" href="<?php echo e(route('users.index')); ?>">
                    <i class="bi bi-person-gear"></i> المستخدمين
                </a>
            </li>
            <?php endif; ?>
        </ul>
        <div class="position-absolute bottom-0 w-100 p-3 border-top border-secondary border-opacity-25">
            <form action="<?php echo e(route('logout')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <button type="submit" class="nav-link w-100 border-0 bg-transparent text-start">
                    <i class="bi bi-box-arrow-right"></i> تسجيل الخروج
                </button>
            </form>
        </div>
    </nav>

    <main class="vip-main">
        <div class="vip-topbar">
            <div>
                <h5 class="mb-0 text-dark"><?php echo $__env->yieldContent('page-title', 'لوحة التحكم'); ?></h5>
                <small class="text-muted"><?php echo $__env->yieldContent('page-subtitle'); ?></small>
            </div>
            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-light text-dark">
                    <i class="bi bi-person-circle"></i> <?php echo e(auth()->user()->name); ?>

                </span>
                <span class="badge <?php echo e(auth()->user()->isAdmin() ? 'bg-warning text-dark' : 'bg-info'); ?>">
                    <?php echo e(auth()->user()->role->label()); ?>

                </span>
            </div>
        </div>

        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle"></i> <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\Users\mass\Desktop\vip-insurance-system\resources\views/layouts/app.blade.php ENDPATH**/ ?>