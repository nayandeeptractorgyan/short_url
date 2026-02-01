<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <h2>Dashboard</h2>
    <div class="info-box">
        <p>Welcome, <strong><?php echo e($user->name); ?></strong></p>
        <p>Role: <strong><?php echo e($user->role->label()); ?></strong></p>
        <?php if($user->company): ?>
            <p>Company: <strong><?php echo e($user->company->name); ?></strong></p>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\abcom\Downloads\url-shortener\url-shortener\resources\views/dashboard.blade.php ENDPATH**/ ?>