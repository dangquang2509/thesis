<?php $__env->startSection('css'); ?>
    <style>
        .ot-header {
            display: none;
        }
        .ot-navbar {
            display: none;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('title', 'ログイン'); ?>

<?php $__env->startSection('content'); ?>
<div class="login-page">
    <div class="form">
        <form class="register-form">
            <input type="text" placeholder="name"/>
            <input type="password" placeholder="password"/>
            <input type="text" placeholder="email address"/>
            <button>create</button>
            <p class="message">Already registered? <a href="/admincp/login">Sign In</a></p>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>