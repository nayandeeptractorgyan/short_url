<?php $__env->startSection('title', 'Accept Invitation'); ?>

<?php $__env->startSection('content'); ?>
<div style="max-width:500px; margin:0 auto;">
    <div class="card">
        <h2>Accept Invitation</h2>
        <div class="info-box" style="margin-bottom:25px;">
            <p>Company: <strong><?php echo e($invitation->company->name); ?></strong></p>
            <p>Role: <strong><?php echo e($invitation->role->label()); ?></strong></p>
            <p>Email: <strong><?php echo e($invitation->email); ?></strong></p>
        </div>

        <form method="POST" action="<?php echo e(route('invite.accept.store', $invitation->token)); ?>">
            <?php echo csrf_field(); ?>
            <div class="form-group">
                <label for="name">Your Name</label>
                <input type="text" id="name" name="name" value="<?php echo e(old('name')); ?>" required placeholder="John Doe" style="max-width:100%;">
            </div>
            <div class="form-group">
                <label for="password">Password (min 8 characters)</label>
                <input type="password" id="password" name="password" required placeholder="••••••••" style="max-width:100%;">
            </div>
            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="••••••••" style="max-width:100%;">
            </div>
            <button type="submit" class="btn" style="width:100%; padding:11px;">Create Account</button>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\abcom\Downloads\url-shortener\url-shortener\resources\views/invitations/accept.blade.php ENDPATH**/ ?>