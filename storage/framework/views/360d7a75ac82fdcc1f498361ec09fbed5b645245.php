<?php $__env->startSection('css'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('title', 'ログイン'); ?>

<?php $__env->startSection('content'); ?>
	<div class="login-page">
		<div class="form">
			<form class="login-form" role="form" method="POST" action="<?php echo e(url('/login')); ?>">
				<?php echo e(csrf_field()); ?>

				<div class="ot-login-title">360コンテンツ管理システム</div>
				<input id="username" name="username" type="text" placeholder="ユーザー名"/>
				<?php if($errors->has('username')): ?>
					<span class="error-block">
						<strong><?php echo e($errors->first('username')); ?></strong>
					</span>
				<?php endif; ?>
				<input id="password" name="password" type="password" placeholder="パスワード"/>
				<?php if($errors->has('password')): ?>
					<span class="error-block">
						<strong><?php echo e($errors->first('password')); ?> </strong>
					</span>
				<?php endif; ?>
				<?php if($errors->has('errorlogin')): ?>
					<span class="error-block">
						<strong><?php echo e($errors->first('errorlogin')); ?> </strong>
					</span>
				<?php endif; ?>
				<button type="submit">ログイン</button>
			</form>
		</div>
	</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.main-portable', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>