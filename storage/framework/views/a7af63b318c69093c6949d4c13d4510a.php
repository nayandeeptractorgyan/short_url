<?php $__env->startSection('title', 'Login'); ?>

<?php $__env->startSection('content'); ?>
<div class="login-wrap">
    <div class="card">
        <h2>🔗 URL Shortener</h2>
        <p style="color:#888; margin-bottom:25px; font-size:14px;">Sign in to your account</p>

        <form method="POST" action="<?php echo e(route('login.post')); ?>">
            <?php echo csrf_field(); ?>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo e(old('email')); ?>" required placeholder="you@example.com">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required placeholder="••••••••">
            </div>
            <button type="submit" class="btn">Login</button>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\abcom\Downloads\url-shortener\url-shortener\resources\views/auth/login.blade.php ENDPATH**/ ?>