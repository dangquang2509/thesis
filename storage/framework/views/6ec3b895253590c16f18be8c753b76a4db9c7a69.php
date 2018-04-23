<?php $__env->startSection('css'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('title', '登録'); ?>

<?php $__env->startSection('content'); ?>
    <div class="login-page">
        <div class="form">
            <form class="register-form">
                <div class="ot-login-title">360コンテンツ管理システム</div>
                <input type="text" placeholder="ユーザー名"/>
                <input type="password" placeholder="パスワード"/>
                <input type="text" placeholder="メールアドレス"/>
                <button>登録</button>
                <p class="message">すでに登録していますか？<a href="/login">ログイン</a></p>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main-portable', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>