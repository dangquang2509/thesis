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
		<form class="login-form">
			<div class="ot-login-title">３６０コンテンツ管理システ</div>
			<input type="text" placeholder="ユーザー名"/>
			<input type="password" placeholder="パスワード"/>
			<button>ログイン</button>
		</form>
	</div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>