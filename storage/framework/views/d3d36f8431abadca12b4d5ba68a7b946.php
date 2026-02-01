<?php $__env->startSection('title', 'Short URLs'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="header-row">
        <h2>Short URLs</h2>
        <?php if(!auth()->user()->isSuperAdmin()): ?>
            <a href="<?php echo e(route('short-urls.create')); ?>" class="btn">+ Create New</a>
        <?php endif; ?>
    </div>

    <?php if($shortUrls->isEmpty()): ?>
        <p class="empty-msg">No short URLs yet.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Short URL</th>
                    <th>Original URL</th>
                    <?php if(auth()->user()->isSuperAdmin()): ?>
                        <th>Company</th>
                        <th>Created By</th>
                    <?php elseif(auth()->user()->isAdmin()): ?>
                        <th>Created By</th>
                    <?php endif; ?>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $shortUrls; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><a href="<?php echo e(url('/' . $url->short_code)); ?>" target="_blank"><?php echo e(url('/' . $url->short_code)); ?></a></td>
                    <td><?php echo e($url->original_url); ?></td>
                    <?php if(auth()->user()->isSuperAdmin()): ?>
                        <td><?php echo e($url->company->name); ?></td>
                        <td><?php echo e($url->creator->name); ?></td>
                    <?php elseif(auth()->user()->isAdmin()): ?>
                        <td><?php echo e($url->creator->name); ?></td>
                    <?php endif; ?>
                    <td><?php echo e($url->created_at->format('Y-m-d H:i')); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\abcom\Downloads\url-shortener\url-shortener\resources\views/short-urls/index.blade.php ENDPATH**/ ?>