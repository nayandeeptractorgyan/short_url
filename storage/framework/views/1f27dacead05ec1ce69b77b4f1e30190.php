<?php $__env->startSection('title', 'Invitations'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="header-row">
        <h2>Invitations</h2>
        <a href="<?php echo e(route('invitations.create')); ?>" class="btn">+ Send Invitation</a>
    </div>

    <?php if($invitations->isEmpty()): ?>
        <p class="empty-msg">No invitations yet.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Company</th>
                    <th>Invited By</th>
                    <th>Status</th>
                    <th>Invite Link</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $invitations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($inv->email); ?></td>
                    <td><?php echo e($inv->role->label()); ?></td>
                    <td><?php echo e($inv->company->name); ?></td>
                    <td><?php echo e($inv->inviter->name); ?></td>
                    <td>
                        <?php if($inv->isAccepted()): ?>
                            <span class="status-accepted">Accepted</span>
                        <?php else: ?>
                            <span class="status-pending">Pending</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if(!$inv->isAccepted()): ?>
                            <a href="<?php echo e(route('invite.accept', $inv->token)); ?>" target="_blank">Copy Link</a>
                        <?php else: ?>
                            —
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\abcom\Downloads\url-shortener\url-shortener\resources\views/invitations/index.blade.php ENDPATH**/ ?>