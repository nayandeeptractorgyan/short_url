<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'URL Shortener'); ?></title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Segoe UI',Arial,sans-serif; background:#f0f2f5; color:#333; min-height:100vh; }
        nav {
            background:linear-gradient(135deg,#1a1a2e,#16213e);
            padding:15px 30px;
            display:flex;
            align-items:center;
            gap:25px;
            box-shadow:0 2px 10px rgba(0,0,0,0.2);
        }
        nav .brand { font-size:20px; font-weight:bold; color:#fff; text-decoration:none; margin-right:20px; }
        nav a { color:#a8b2d1; text-decoration:none; font-size:14px; padding:6px 12px; border-radius:5px; transition:background 0.2s; }
        nav a:hover { background:rgba(255,255,255,0.1); color:#fff; }
        nav .user-info { margin-left:auto; display:flex; align-items:center; gap:12px; color:#a8b2d1; font-size:14px; }
        nav .user-info strong { color:#fff; }
        .badge { padding:3px 10px; border-radius:12px; font-size:11px; font-weight:600; text-transform:uppercase; letter-spacing:0.5px; }
        .badge-super_admin { background:#6f42c1; color:#fff; }
        .badge-admin { background:#f0ad4e; color:#fff; }
        .badge-member { background:#5cb85c; color:#fff; }
        .badge-sales { background:#5bc0de; color:#fff; }
        .badge-manager { background:#d9534f; color:#fff; }
        nav .logout-btn { background:#e74c3c; color:#fff; border:none; padding:6px 14px; border-radius:5px; cursor:pointer; font-size:13px; }
        nav .logout-btn:hover { background:#c0392b; }
        .container { max-width:1100px; margin:30px auto; padding:0 20px; }
        .card { background:#fff; border-radius:10px; box-shadow:0 2px 12px rgba(0,0,0,0.08); padding:30px; }
        h2 { font-size:22px; margin-bottom:20px; color:#1a1a2e; }
        .header-row { display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; }
        .btn {
            display:inline-block;
            background:linear-gradient(135deg,#667eea,#764ba2);
            color:#fff; padding:9px 20px; border:none; border-radius:6px;
            font-size:14px; cursor:pointer; text-decoration:none; transition:opacity 0.2s;
        }
        .btn:hover { opacity:0.85; }
        .alert-success { background:#d4edda; color:#155724; border:1px solid #c3e6cb; padding:12px 18px; border-radius:6px; margin-bottom:20px; }
        .alert-error { background:#f8d7da; color:#721c24; border:1px solid #f5c6cb; padding:12px 18px; border-radius:6px; margin-bottom:20px; list-style:none; }
        .alert-error li { margin:4px 0; }
        .form-group { margin-bottom:18px; }
        .form-group label { display:block; font-size:14px; font-weight:600; color:#444; margin-bottom:6px; }
        .form-group input, .form-group select {
            width:100%; max-width:450px; padding:10px 14px; border:1px solid #ddd;
            border-radius:6px; font-size:14px; transition:border 0.2s; background:#fff;
        }
        .form-group input:focus, .form-group select:focus { outline:none; border-color:#667eea; box-shadow:0 0 0 3px rgba(102,126,234,0.2); }
        table { width:100%; border-collapse:collapse; margin-top:10px; }
        thead { background:#1a1a2e; color:#fff; }
        th { text-align:left; padding:12px 16px; font-size:13px; font-weight:600; text-transform:uppercase; letter-spacing:0.5px; }
        td { padding:12px 16px; font-size:14px; border-bottom:1px solid #eee; color:#444; }
        tr:hover td { background:#f9f9fb; }
        td a { color:#667eea; text-decoration:none; }
        td a:hover { text-decoration:underline; }
        .status-pending { color:#f0ad4e; font-weight:600; }
        .status-accepted { color:#5cb85c; font-weight:600; }
        .empty-msg { color:#999; font-size:15px; padding:30px 0; text-align:center; }
        .login-wrap { max-width:420px; margin:80px auto 0; }
        .login-wrap .card { padding:40px 35px; text-align:center; }
        .login-wrap h2 { margin-bottom:25px; }
        .login-wrap .form-group input { max-width:100%; }
        .login-wrap .btn { width:100%; padding:11px; font-size:15px; margin-top:8px; }
        .info-box { background:#f0f4ff; border:1px solid #dce6ff; border-radius:8px; padding:20px 24px; margin-top:20px; }
        .info-box p { font-size:14px; margin:6px 0; color:#444; }
        .info-box strong { color:#1a1a2e; }
    </style>
</head>
<body>

<?php if(auth()->guard()->check()): ?>
<nav>
    <a href="<?php echo e(route('dashboard')); ?>" class="brand">🔗 URL Shortener</a>
    <a href="<?php echo e(route('dashboard')); ?>">Dashboard</a>
    <a href="<?php echo e(route('short-urls.index')); ?>">URLs</a>
    <?php if(auth()->user()->role->canInvite()): ?>
        <a href="<?php echo e(route('invitations.index')); ?>">Invitations</a>
    <?php endif; ?>
    <div class="user-info">
        <strong><?php echo e(auth()->user()->name); ?></strong>
        <span class="badge badge-<?php echo e(auth()->user()->role->value); ?>"><?php echo e(auth()->user()->role->label()); ?></span>
        <?php if(auth()->user()->company): ?>
            <span>| <?php echo e(auth()->user()->company->name); ?></span>
        <?php endif; ?>
        <form action="<?php echo e(route('logout')); ?>" method="POST" style="display:inline;">
            <?php echo csrf_field(); ?>
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>
</nav>
<?php endif; ?>

<div class="container">
    <?php if(session('success')): ?>
        <div class="alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>
    <?php if($errors->any()): ?>
        <ul class="alert-error">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    <?php endif; ?>
    <?php echo $__env->yieldContent('content'); ?>
</div>

</body>
</html>
<?php /**PATH C:\Users\abcom\Downloads\url-shortener\url-shortener\resources\views/layouts/app.blade.php ENDPATH**/ ?>