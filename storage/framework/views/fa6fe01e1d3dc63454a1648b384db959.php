<?php $__env->startSection('title', 'Create Short URL'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <h2>Create Short URL</h2>
    <form method="POST" action="<?php echo e(route('short-urls.store')); ?>">
        <?php echo csrf_field(); ?>
        <div class="form-group">
            <label for="original_url">Original URL</label>
            <input type="url" id="original_url" name="original_url" value="<?php echo e(old('original_url')); ?>" placeholder="https://example.com/long-url" required>
        </div>
        <button type="submit" class="btn">Create</button>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\abcom\Downloads\url-shortener\url-shortener\resources\views/short-urls/create.blade.php ENDPATH**/ ?>