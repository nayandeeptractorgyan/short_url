<?php $__env->startSection('title', 'Send Invitation'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <h2>Send Invitation</h2>
    <form method="POST" action="<?php echo e(route('invitations.store')); ?>">
        <?php echo csrf_field(); ?>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?php echo e(old('email')); ?>" required placeholder="invite@example.com">
        </div>

        <?php if(auth()->user()->isSuperAdmin()): ?>
            <input type="hidden" name="role" value="admin">
            <div class="form-group">
                <label for="company_name">New Company Name</label>
                <input type="text" id="company_name" name="company_name" value="<?php echo e(old('company_name')); ?>" required placeholder="Company name">
            </div>
        <?php else: ?>
            <div class="form-group">
                <label for="role">Role</label>
                <select id="role" name="role" required>
                    <option value="">Select role</option>
                    <option value="admin"  <?php echo e(old('role') === 'admin'  ? 'selected' : ''); ?>>Admin</option>
                    <option value="member" <?php echo e(old('role') === 'member' ? 'selected' : ''); ?>>Member</option>
                </select>
            </div>
        <?php endif; ?>

        <button type="submit" class="btn">Send Invitation</button>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\abcom\Downloads\url-shortener\url-shortener\resources\views/invitations/create.blade.php ENDPATH**/ ?>